<?php
/**
 * Registers Simple Page Ordering abilities with the WordPress Abilities API.
 *
 * @package simple-page-ordering
 */

namespace SimplePageOrdering;

use stdClass;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\Simple_Page_Ordering_Abilities' ) ) :

	/**
	 * Simple_Page_Ordering_Abilities class
	 *
	 * Exposes the reordering feature to AI agents and other clients
	 * through the Abilities API (WordPress 6.9+).
	 *
	 * @since x.x.x
	 */
	class Simple_Page_Ordering_Abilities {

		/**
		 * Slug of the ability category.
		 *
		 * @var string
		 */
		const CATEGORY = 'simple-page-ordering';

		/**
		 * Name of the reorder ability.
		 *
		 * @var string
		 */
		const REORDER_ABILITY = 'simple-page-ordering/reorder-post';

		/**
		 * Most follow-up passes one reorder may run before giving up.
		 *
		 * Each pass renumbers up to the `simple_page_ordering_limit` siblings, so
		 * this only stops a runaway loop.
		 *
		 * @var int
		 */
		const MAX_PASSES = 200;

		/**
		 * Registers the hooks.
		 *
		 * The plugin requires WordPress 6.9, which includes the Abilities API.
		 */
		public static function init() {
			add_action( 'wp_abilities_api_categories_init', array( __CLASS__, 'register_category' ) );
			add_action( 'wp_abilities_api_init', array( __CLASS__, 'register_abilities' ) );
		}

		/**
		 * Registers the ability category.
		 */
		public static function register_category() {
			wp_register_ability_category(
				self::CATEGORY,
				array(
					'label'       => __( 'Simple Page Ordering', 'simple-page-ordering' ),
					'description' => __( 'Abilities for changing the order of pages and other sortable content.', 'simple-page-ordering' ),
				)
			);
		}

		/**
		 * Registers the abilities.
		 */
		public static function register_abilities() {
			wp_register_ability(
				self::REORDER_ABILITY,
				array(
					'label'               => __( 'Reorder a post', 'simple-page-ordering' ),
					'description'         => __( 'Moves a page, or another sortable post, to a new position. Pass the ID of the item that should come before it, after it, or both. At least one of previd or nextid is required. The item can also move under a new parent when its new neighbors have a different parent.', 'simple-page-ordering' ),
					'category'            => self::CATEGORY,
					'input_schema'        => self::get_reorder_input_schema(),
					'output_schema'       => self::get_reorder_output_schema(),
					'execute_callback'    => array( __CLASS__, 'execute_reorder' ),
					'permission_callback' => array( __CLASS__, 'reorder_permission_check' ),
					'meta'                => array(
						'show_in_rest' => true,
						// Opt in to the MCP Adapter so AI agents can discover this ability.
						'mcp'          => array(
							'public' => true,
						),
						'annotations'  => array(
							'readonly'    => false,
							/*
							 * Reordering rewrites the stored order of many items, but it deletes
							 * nothing. Core requires the DELETE method for abilities that are both
							 * destructive and idempotent, so `true` here would break POST clients.
							 */
							'destructive' => false,
							'idempotent'  => true,
						),
					),
				)
			);
		}

		/**
		 * Input schema for the reorder ability.
		 *
		 * @return array
		 */
		private static function get_reorder_input_schema() {
			return array(
				'type'                 => 'object',
				'properties'           => array(
					'id'      => array(
						'description' => __( 'ID of the item to move.', 'simple-page-ordering' ),
						'type'        => 'integer',
						'minimum'     => 1,
					),
					'previd'  => array(
						'description' => __( 'ID of the item that should come directly before the moved item. Use 0 for none. Send this, nextid, or both.', 'simple-page-ordering' ),
						'type'        => 'integer',
						'minimum'     => 0,
						'default'     => 0,
					),
					'nextid'  => array(
						'description' => __( 'ID of the item that should come directly after the moved item. Use 0 for none. Send this, previd, or both.', 'simple-page-ordering' ),
						'type'        => 'integer',
						'minimum'     => 0,
						'default'     => 0,
					),
					'start'   => array(
						'description' => __( 'Menu order index to start numbering from.', 'simple-page-ordering' ),
						'type'        => 'integer',
						'minimum'     => 1,
						'default'     => 1,
					),
					// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- Not a query; this is a schema key.
					'exclude' => array(
						'description' => __( 'IDs of items to leave out of the renumbering.', 'simple-page-ordering' ),
						'type'        => 'array',
						'items'       => array(
							'type'    => 'integer',
							'minimum' => 1,
						),
						'default'     => array(),
					),
				),
				'required'             => array( 'id' ),
				/*
				 * "At least one neighbor" is not a schema rule here. Some AI providers reject
				 * anyOf at the top level of a tool schema, so the callback checks it and the
				 * descriptions below tell the caller.
				 */
				'additionalProperties' => false,
			);
		}

		/**
		 * Output schema for the reorder ability.
		 *
		 * @return array
		 */
		private static function get_reorder_output_schema() {
			return array(
				'type'       => 'object',
				'properties' => array(
					'success'      => array(
						'description' => __( 'Whether the item was moved.', 'simple-page-ordering' ),
						'type'        => 'boolean',
					),
					'new_pos'      => array(
						'description' => __( 'New position data keyed by item ID. The moved item has menu_order, post_parent and depth. Siblings have their new menu order. This can be empty when has_children is true, so read the items again to confirm their order.', 'simple-page-ordering' ),
						'type'        => 'object',
					),
					'has_children' => array(
						'description' => __( 'Whether the moved item has child items.', 'simple-page-ordering' ),
						'type'        => 'boolean',
					),
				),
				'required'   => array( 'success' ),
			);
		}

		/**
		 * Permission check for the reorder ability.
		 *
		 * @param array|null $input The ability input.
		 * @return bool|WP_Error
		 */
		public static function reorder_permission_check( $input = null ) {
			$post_id = is_array( $input ) && isset( $input['id'] ) ? (int) $input['id'] : 0;

			if ( $post_id < 1 ) {
				return false;
			}

			return Simple_Page_Ordering::can_reorder_post( $post_id );
		}

		/**
		 * Checks that the neighbor items are usable for moving a post.
		 *
		 * The permission callback only checks the item being moved. A neighbor
		 * must exist, must be the same post type, and must be editable by the
		 * current user. Otherwise the ordering routine would treat an unrelated
		 * post as a sibling, or silently do nothing and still report success.
		 *
		 * @param int   $post_id      The ID of the item being moved.
		 * @param int[] $neighbor_ids IDs of the items before and after it. Zero means none.
		 * @return true|WP_Error True if every neighbor is valid, a WP_Error if not.
		 */
		private static function check_neighbors( $post_id, $neighbor_ids ) {
			$post = get_post( $post_id );
			if ( ! $post ) {
				return new WP_Error(
					'invalid',
					__( 'Missing mandatory parameters.', 'simple-page-ordering' ),
					array( 'status' => 400 )
				);
			}

			foreach ( $neighbor_ids as $neighbor_id ) {
				if ( 0 === $neighbor_id ) {
					continue;
				}

				$neighbor = get_post( $neighbor_id );
				if ( ! $neighbor || $neighbor->post_type !== $post->post_type ) {
					return new WP_Error(
						'invalid_neighbor',
						__( 'The previous and next items must exist and be the same post type as the item being moved.', 'simple-page-ordering' ),
						array( 'status' => 400 )
					);
				}

				if ( ! current_user_can( 'edit_post', $neighbor_id ) ) {
					return new WP_Error(
						'invalid_neighbor_permissions',
						__( 'You are not allowed to edit the previous or next item.', 'simple-page-ordering' ),
						array( 'status' => 403 )
					);
				}
			}

			return true;
		}

		/**
		 * Builds the error for a reorder that stopped after some items were already saved.
		 *
		 * Running the same request again is safe. It renumbers the same items and finishes the job.
		 *
		 * @param WP_Error|null $cause The error from the failed pass, if there was one.
		 * @return WP_Error
		 */
		private static function partial_update_error( $cause = null ) {
			$message = __( 'The order was only partly updated. Some items already have their new position. Run the same request again to finish.', 'simple-page-ordering' );

			if ( $cause instanceof WP_Error ) {
				$message .= ' ' . $cause->get_error_message();
			}

			return new WP_Error(
				'partial_update',
				$message,
				array( 'status' => 500 )
			);
		}

		/**
		 * Runs the reorder ability.
		 *
		 * @param array|null $input The validated ability input.
		 * @return array|WP_Error
		 */
		public static function execute_reorder( $input = null ) {
			$input   = is_array( $input ) ? $input : array();
			$post_id = isset( $input['id'] ) ? (int) $input['id'] : 0;
			$previd  = isset( $input['previd'] ) ? (int) $input['previd'] : 0;
			$nextid  = isset( $input['nextid'] ) ? (int) $input['nextid'] : 0;
			$start   = isset( $input['start'] ) ? (int) $input['start'] : 1;
			$exclude = isset( $input['exclude'] ) ? array_map( 'intval', (array) $input['exclude'] ) : array();

			if ( $post_id < 1 || ( 0 === $previd && 0 === $nextid ) ) {
				return new WP_Error(
					'invalid',
					__( 'Missing mandatory parameters.', 'simple-page-ordering' ),
					array( 'status' => 400 )
				);
			}

			$neighbors_check = self::check_neighbors( $post_id, array( $previd, $nextid ) );
			if ( is_wp_error( $neighbors_check ) ) {
				return $neighbors_check;
			}

			$new_pos      = array();
			$has_children = false;
			$next         = false;
			$passes       = 0;

			/*
			 * The ordering routine renumbers a limited number of siblings per call
			 * and returns a `next` array when more are left. The wp-admin script
			 * sends follow-up requests. Do the same here so the caller never gets
			 * a success response for a partly renumbered list.
			 */
			do {
				$result = Simple_Page_Ordering::page_ordering( $post_id, $previd, $nextid, $start, $exclude );

				if ( is_wp_error( $result ) ) {
					// An earlier pass already saved new positions, so say that the update is partial.
					if ( $passes > 0 ) {
						return self::partial_update_error( $result );
					}

					return $result;
				}

				// The ordering routine returns the string "children" when the moved item has children.
				if ( 'children' === $result ) {
					$has_children = true;
					$next         = false;
					break;
				}

				if ( isset( $result->new_pos ) ) {
					$new_pos = array_replace( $new_pos, (array) $result->new_pos );
				}

				$next = ! empty( $result->next ) ? (array) $result->next : false;

				if ( $next ) {
					$post_id = (int) $next['id'];
					$previd  = (int) $next['previd'];
					$nextid  = (int) $next['nextid'];
					$start   = (int) $next['start'];
					$exclude = array_map( 'intval', (array) $next['excluded'] );
				}

				++$passes;
			} while ( $next && $passes < self::MAX_PASSES );

			if ( $next ) {
				return self::partial_update_error();
			}

			return array(
				'success'      => true,
				'new_pos'      => (object) $new_pos,
				'has_children' => $has_children,
			);
		}
	}

	Simple_Page_Ordering_Abilities::init();

endif;
