<?php
/**
 * Plugin Name:       Simple Page Ordering
 * Plugin URI:        http://10up.com/plugins/simple-page-ordering-wordpress/
 * Description:       Order your pages and hierarchical post types using drag and drop on the built in page list. For further instructions, open the "Help" tab on the Pages screen.
 * Version:           2.5.1
 * Requires at least: 5.7
 * Requires PHP:      7.4
 * Author:            10up
 * Author URI:        https://10up.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-page-ordering
 *
 * @package simple-page-ordering
 */

// Useful global constants.
define( 'SIMPLE_PAGE_ORDERING_VERSION', '2.5.1' );

if ( ! class_exists( 'Simple_Page_Ordering' ) ) :

	/**
	 * Simple_Page_Ordering class
	 */
	class Simple_Page_Ordering {

		/**
		 * Handles initializing this class and returning the singleton instance after it's been cached.
		 *
		 * @return null|Simple_Page_Ordering
		 */
		public static function get_instance() {
			// Store the instance locally to avoid private static replication
			static $instance = null;

			if ( null === $instance ) {
				$instance = new self();
				self::add_actions();
			}

			return $instance;
		}

		/**
		 * An empty constructor
		 *
		 * Purposely do nothing here
		 */
		public function __construct() {}

		/**
		 * Handles registering hooks that initialize this plugin.
		 */
		public static function add_actions() {
			add_action( 'load-edit.php', array( __CLASS__, 'load_edit_screen' ) );
			add_action( 'wp_ajax_simple_page_ordering', array( __CLASS__, 'ajax_simple_page_ordering' ) );
			add_action( 'wp_ajax_reset_simple_page_ordering', array( __CLASS__, 'ajax_reset_simple_page_ordering' ) );
			add_action( 'plugins_loaded', array( __CLASS__, 'load_textdomain' ) );
			add_action( 'rest_api_init', array( __CLASS__, 'rest_api_init' ) );
		}

		/**
		 * Loads the plugin textdomain
		 */
		public static function load_textdomain() {
			load_plugin_textdomain( 'simple-page-ordering', false, dirname( plugin_basename( __FILE__ ) ) . '/localization/' );
		}

		/**
		 * Determine whether given post type is sortable or not.
		 *
		 * @param string $post_type Post type to check.
		 *
		 * @return boolean
		 */
		private static function is_post_type_sortable( $post_type = 'post' ) {
			$sortable = ( post_type_supports( $post_type, 'page-attributes' ) || is_post_type_hierarchical( $post_type ) );

			/**
			 * Change default ordering support for a post type.
			 *
			 * @since 2.0.0
			 *
			 * @param boolean $sortable Whether this post type is sortable or not.
			 * @param string  $post_type The post type being checked.
			 */
			return apply_filters( 'simple_page_ordering_is_sortable', $sortable, $post_type );
		}

		/**
		 * Load up page ordering scripts for the edit screen
		 */
		public static function load_edit_screen() {
			$screen    = get_current_screen();
			$post_type = $screen->post_type;

			// is post type sortable?
			$sortable = self::is_post_type_sortable( $post_type );
			if ( ! $sortable ) {
				return;
			}

			// does user have the right to manage these post objects?
			if ( ! self::check_edit_others_caps( $post_type ) ) {
				return;
			}

			// add view by menu order to views
			add_filter(
				'views_' . $screen->id,
				array(
					__CLASS__,
					'sort_by_order_link',
				)
			);
			add_action( 'wp', array( __CLASS__, 'wp' ) );
			add_action( 'admin_head', array( __CLASS__, 'admin_head' ) );
		}

		/**
		 * when we load up our posts query, if we're actually sorting by menu order, initialize sorting scripts
		 */
		public static function wp() {
			$orderby = get_query_var( 'orderby' );
			$screen  = get_current_screen();
			if ( ( is_string( $orderby ) && 0 === strpos( $orderby, 'menu_order' ) ) || ( isset( $orderby['menu_order'] ) && 'ASC' === $orderby['menu_order'] ) ) {

				$script_name       = 'dist/js/simple-page-ordering.js';
				$script_asset_path = plugin_dir_path( __FILE__ ) . 'dist/js/simple-page-ordering.asset.php';
				$script_asset      = file_exists( $script_asset_path )
					? require $script_asset_path
					: false;

				if ( false !== $script_asset ) {
					$script_url = plugins_url( $script_name, __FILE__ );
					wp_enqueue_script( 'simple-page-ordering', $script_url, $script_asset['dependencies'], $script_asset['version'], true );

					wp_localize_script(
						'simple-page-ordering',
						'simple_page_ordering_localized_data',
						array(
							'_wpnonce' => wp_create_nonce( 'simple-page-ordering-nonce' ),
						)
					);

					wp_enqueue_style( 'simple-page-ordering', plugins_url( '/dist/css/simple-page-ordering.css', __FILE__ ), [], $script_asset['version'] );
				} else {
					add_action(
						'admin_notices',
						function () {
							?>
							<div class="notice notice-warning is-dismissible">
								<p><?php echo wp_kses_post( __( 'It looks like you are using a development copy of <strong>Simple Page Ordering</strong>. Please run <code>npm i; npm run build</code> to create assets.', 'simple-page-ordering' ) ); ?></p>
							</div>
							<?php
						}
					);
				}
			}
		}

		/**
		 * Add page ordering help to the help tab
		 */
		public static function admin_head() {
			$reset_order = sprintf( '<a href="#" id="simple-page-ordering-reset" data-posttype="%s">%s</a>', get_query_var( 'post_type' ), __( 'Reset post order', 'simple-page-ordering' ) );
			$screen      = get_current_screen();
			$screen->add_help_tab(
				array(
					'id'      => 'simple_page_ordering_help_tab',
					'title'   => esc_html__( 'Simple Page Ordering', 'simple-page-ordering' ),
					'content' => sprintf(
						'<p>%s</p><a href="#" id="simple-page-ordering-reset" data-posttype="%s">%s</a>',
						esc_html__( 'To reposition an item, simply drag and drop the row by "clicking and holding" it anywhere (outside of the links and form controls) and moving it to its new position.', 'simple-page-ordering' ),
						get_query_var( 'post_type' ),
						esc_html__( 'Reset post order', 'simple-page-ordering' )
					),
				)
			);
		}

		/**
		 * Page ordering ajax callback
		 *
		 * @return void
		 */
		public static function ajax_simple_page_ordering() {
			// check and make sure we have what we need
			if ( empty( $_POST['id'] ) || ( ! isset( $_POST['previd'] ) && ! isset( $_POST['nextid'] ) ) ) {
				die( - 1 );
			}

			$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'simple-page-ordering-nonce' ) ) {
				die( -1 );
			}

			$post_id  = empty( $_POST['id'] ) ? false : (int) $_POST['id'];
			$previd   = empty( $_POST['previd'] ) ? false : (int) $_POST['previd'];
			$nextid   = empty( $_POST['nextid'] ) ? false : (int) $_POST['nextid'];
			$start    = empty( $_POST['start'] ) ? 1 : (int) $_POST['start'];
			$excluded = empty( $_POST['excluded'] ) ? array( $_POST['id'] ) : array_filter( (array) json_decode( $_POST['excluded'] ), 'intval' );

			// real post?
			$post = empty( $post_id ) ? false : get_post( (int) $post_id );
			if ( ! $post ) {
				die( - 1 );
			}

			// does user have the right to manage these post objects?
			if ( ! self::check_edit_others_caps( $post->post_type ) ) {
				die( - 1 );
			}

			$result = self::page_ordering( $post_id, $previd, $nextid, $start, $excluded );

			if ( is_wp_error( $result ) ) {
				die( -1 );
			}

			die( wp_json_encode( $result ) );
		}

		/**
		 * Page ordering reset ajax callback
		 *
		 * @return void
		 */
		public static function ajax_reset_simple_page_ordering() {
			global $wpdb;

			$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'simple-page-ordering-nonce' ) ) {
				die( -1 );
			}

			// check and make sure we have what we need
			$post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : '';

			if ( empty( $post_type ) ) {
				die( -1 );
			}

			// does user have the right to manage these post objects?
			if ( ! self::check_edit_others_caps( $post_type ) ) {
				die( -1 );
			}

			// reset the order of all posts of given post type
			$wpdb->update( 'wp_posts', array( 'menu_order' => 0 ), array( 'post_type' => $post_type ), array( '%d' ), array( '%s' ) );

			die( 0 );
		}

		/**
		 * Page ordering function
		 *
		 * @param int   $post_id  The post ID.
		 * @param int   $previd   The previous post ID.
		 * @param int   $nextid   The next post ID.
		 * @param int   $start    The start index.
		 * @param array $excluded Array of post IDs.
		 *
		 * @return object|WP_Error|"children"
		 */
		public static function page_ordering( $post_id, $previd, $nextid, $start, $excluded ) {
			// real post?
			$post = empty( $post_id ) ? false : get_post( (int) $post_id );
			if ( ! $post ) {
				return new WP_Error( 'invalid', __( 'Missing mandatory parameters.', 'simple-page-ordering' ) );
			}

			// Badly written plug-in hooks for save post can break things.
			if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
				error_reporting( 0 ); // phpcs:ignore
			}

			global $wp_version;

			$previd   = empty( $previd ) ? false : (int) $previd;
			$nextid   = empty( $nextid ) ? false : (int) $nextid;
			$start    = empty( $start ) ? 1 : (int) $start;
			$excluded = empty( $excluded ) ? array( $post_id ) : array_filter( (array) $excluded, 'intval' );

			$new_pos     = array(); // store new positions for ajax
			$return_data = new stdClass();

			do_action( 'simple_page_ordering_pre_order_posts', $post, $start );

			// attempt to get the intended parent... if either sibling has a matching parent ID, use that
			$parent_id        = $post->post_parent;
			$next_post_parent = $nextid ? wp_get_post_parent_id( $nextid ) : false;

			if ( $previd === $next_post_parent ) {    // if the preceding post is the parent of the next post, move it inside
				$parent_id = $next_post_parent;
			} elseif ( $next_post_parent !== $parent_id ) {  // otherwise, if the next post's parent isn't the same as our parent, we need to study
				$prev_post_parent = $previd ? wp_get_post_parent_id( $previd ) : false;
				if ( $prev_post_parent !== $parent_id ) {    // if the previous post is not our parent now, make it so!
					$parent_id = ( false !== $prev_post_parent ) ? $prev_post_parent : $next_post_parent;
				}
			}

			// if the next post's parent isn't our parent, it might as well be false (irrelevant to our query)
			if ( $next_post_parent !== $parent_id ) {
				$nextid = false;
			}

			$max_sortable_posts = (int) apply_filters( 'simple_page_ordering_limit', 50 );    // should reliably be able to do about 50 at a time

			if ( $max_sortable_posts < 5 ) {    // don't be ridiculous!
				$max_sortable_posts = 50;
			}

			// we need to handle all post stati, except trash (in case of custom stati)
			$post_stati = get_post_stati(
				array(
					'show_in_admin_all_list' => true,
				)
			);

			$siblings_query = array(
				'depth'                  => 1,
				'posts_per_page'         => $max_sortable_posts,
				'post_type'              => $post->post_type,
				'post_status'            => $post_stati,
				'post_parent'            => $parent_id,
				'post__not_in'           => $excluded, // phpcs:ignore
				'orderby'                => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'suppress_filters'       => true, // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.SuppressFiltersTrue
				'ignore_sticky_posts'    => true,
			);

			if ( version_compare( $wp_version, '4.0', '<' ) ) {
				$siblings_query['orderby'] = 'menu_order title';
				$siblings_query['order']   = 'ASC';
			}

			$siblings = new WP_Query( $siblings_query ); // fetch all the siblings (relative ordering)

			// don't waste overhead of revisions on a menu order change (especially since they can't *all* be rolled back at once)
			remove_action( 'post_updated', 'wp_save_post_revision' );

			foreach ( $siblings->posts as $sibling ) :
				// don't handle the actual post
				if ( $sibling->ID === $post->ID ) {
					continue;
				}

				// if this is the post that comes after our repositioned post, set our repositioned post position and increment menu order
				if ( $nextid === $sibling->ID ) {
					wp_update_post(
						array(
							'ID'          => $post->ID,
							'menu_order'  => $start,
							'post_parent' => $parent_id,
						)
					);

					$ancestors            = get_post_ancestors( $post->ID );
					$new_pos[ $post->ID ] = array(
						'menu_order'  => $start,
						'post_parent' => $parent_id,
						'depth'       => count( $ancestors ),
					);

					$start ++;
				}

				// if repositioned post has been set, and new items are already in the right order, we can stop
				if ( isset( $new_pos[ $post->ID ] ) && $sibling->menu_order >= $start ) {
					$return_data->next = false;
					break;
				}

				// set the menu order of the current sibling and increment the menu order
				if ( $sibling->menu_order !== $start ) {
					wp_update_post(
						array(
							'ID'         => $sibling->ID,
							'menu_order' => $start,
						)
					);
				}
				$new_pos[ $sibling->ID ] = $start;
				$start ++;

				if ( ! $nextid && $previd === $sibling->ID ) {
					wp_update_post(
						array(
							'ID'          => $post->ID,
							'menu_order'  => $start,
							'post_parent' => $parent_id,
						)
					);

					$ancestors            = get_post_ancestors( $post->ID );
					$new_pos[ $post->ID ] = array(
						'menu_order'  => $start,
						'post_parent' => $parent_id,
						'depth'       => count( $ancestors ),
					);
					$start ++;
				}

			endforeach;

			// max per request
			if ( ! isset( $return_data->next ) && $siblings->max_num_pages > 1 ) {
				$return_data->next = array(
					'id'       => $post->ID,
					'previd'   => $previd,
					'nextid'   => $nextid,
					'start'    => $start,
					'excluded' => array_merge( array_keys( $new_pos ), $excluded ),
				);
			} else {
				$return_data->next = false;
			}

			do_action( 'simple_page_ordering_ordered_posts', $post, $new_pos );

			if ( ! $return_data->next ) {
				// if the moved post has children, we need to refresh the page (unless we're continuing)
				$children = new WP_Query(
					array(
						'posts_per_page'         => 1,
						'post_type'              => $post->post_type,
						'post_status'            => $post_stati,
						'post_parent'            => $post->ID,
						'fields'                 => 'ids',
						'update_post_term_cache' => false,
						'update_post_meta_cache' => false,
						'ignore_sticky'          => true,
						'no_found_rows'          => true,
					)
				);

				if ( $children->have_posts() ) {
					return 'children';
				}
			}

			$return_data->new_pos = $new_pos;

			return $return_data;
		}

		/**
		 * Append a sort by order link to the post actions
		 *
		 * @param array $views An array of available list table views.
		 *
		 * @return array
		 */
		public static function sort_by_order_link( $views ) {
			$class        = ( get_query_var( 'orderby' ) === 'menu_order title' ) ? 'current' : '';
			$query_string = remove_query_arg( array( 'orderby', 'order' ) );
			if ( ! is_post_type_hierarchical( get_post_type() ) ) {
				$query_string = add_query_arg( 'orderby', 'menu_order title', $query_string );
				$query_string = add_query_arg( 'order', 'asc', $query_string );
			}
			$views['byorder'] = sprintf( '<a href="%s" class="%s">%s</a>', esc_url( $query_string ), $class, __( 'Sort by Order', 'simple-page-ordering' ) );

			return $views;
		}

		/**
		 * Checks to see if the current user has the capability to "edit others" for a post type
		 *
		 * @param string $post_type Post type name
		 *
		 * @return bool True or false
		 */
		private static function check_edit_others_caps( $post_type ) {
			$post_type_object = get_post_type_object( $post_type );
			$edit_others_cap  = empty( $post_type_object ) ? 'edit_others_' . $post_type . 's' : $post_type_object->cap->edit_others_posts;

			return apply_filters( 'simple_page_ordering_edit_rights', current_user_can( $edit_others_cap ), $post_type );
		}

		/**
		 * Registers the API endpoint for sorting from the REST endpoint
		 */
		public static function rest_api_init() {
			register_rest_route(
				'simple-page-ordering/v1',
				'page_ordering',
				[
					'methods'             => 'POST',
					'callback'            => array( __CLASS__, 'rest_page_ordering' ),
					'permission_callback' => array( __CLASS__, 'rest_page_ordering_permissions_check' ),
					'args'                => [
						'id'      => [
							'description' => __( 'ID of item we want to sort', 'simple-page-ordering' ),
							'required'    => true,
							'type'        => 'integer',
							'minimum'     => 1,
						],
						'previd'  => [
							'description' => __( 'ID of item we want to be previous to after sorting', 'simple-page-ordering' ),
							'required'    => true,
							'type'        => [ 'boolean', 'integer' ],
						],
						'nextid'  => [
							'description' => __( 'ID of item we want to be next to after sorting', 'simple-page-ordering' ),
							'required'    => true,
							'type'        => [ 'boolean', 'integer' ],
						],
						'start'   => [
							'default'     => 1,
							'description' => __( 'Index we start with when sorting', 'simple-page-ordering' ),
							'required'    => false,
							'type'        => 'integer',
						],
						'exclude' => [
							'default'     => [],
							'description' => __( 'Array of IDs we want to exclude', 'simple-page-ordering' ),
							'required'    => false,
							'type'        => 'array',
							'items'       => [
								'type' => 'integer',
							],
						],
					],
				]
			);
		}

		/**
		 * Check if a given request has access to reorder content.
		 *
		 * This check ensures the current user making the request has
		 * proper permissions to edit the item, that the post type
		 * is allowed in REST requests and the post type is sortable.
		 *
		 * @since 2.5.1
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return bool|WP_Error
		 */
		public static function rest_page_ordering_permissions_check( WP_REST_Request $request ) {
			$post_id = $request->get_param( 'id' );

			// Ensure we have a logged in user that can edit the item.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return false;
			}

			$post_type     = get_post_type( $post_id );
			$post_type_obj = get_post_type_object( $post_type );

			// Ensure the post type is allowed in REST endpoints.
			if ( ! $post_type || empty( $post_type_obj ) || empty( $post_type_obj->show_in_rest ) ) {
				return false;
			}

			// Ensure this post type is sortable.
			if ( ! self::is_post_type_sortable( $post_type ) ) {
				return new WP_Error( 'not_enabled', esc_html__( 'This post type is not sortable.', 'simple-page-ordering' ) );
			}

			return true;
		}

		/**
		 * Handle REST page sorting
		 *
		 * @param WP_REST_Request $request The REST request object.
		 */
		public static function rest_page_ordering( WP_REST_Request $request ) {
			$post_id  = empty( $request->get_param( 'id' ) ) ? false : (int) $request->get_param( 'id' );
			$previd   = empty( $request->get_param( 'previd' ) ) ? false : (int) $request->get_param( 'previd' );
			$nextid   = empty( $request->get_param( 'nextid' ) ) ? false : (int) $request->get_param( 'nextid' );
			$start    = empty( $request->get_param( 'start' ) ) ? 1 : (int) $request->get_param( 'start' );
			$excluded = empty( $request->get_param( 'excluded' ) ) ? array( $request->get_param( 'id' ) ) : array_filter( (array) json_decode( $request->get_param( 'excluded' ) ), 'intval' );

			// Check and make sure we have what we need.
			if ( false === $post_id || ( false === $previd && false === $nextid ) ) {
				return new WP_Error( 'invalid', __( 'Missing mandatory parameters.', 'simple-page-ordering' ) );
			}

			$page_ordering = self::page_ordering( $post_id, $previd, $nextid, $start, $excluded );

			if ( is_wp_error( $page_ordering ) ) {
				return $page_ordering;
			}

			return new WP_REST_Response(
				array(
					'status'        => 200,
					'response'      => 'success',
					'body_response' => $page_ordering,
				)
			);
		}
	}

	Simple_Page_Ordering::get_instance();

endif;
