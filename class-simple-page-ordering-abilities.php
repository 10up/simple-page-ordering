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
		 * Registers the hooks. Does nothing when the Abilities API is missing.
		 */
		public static function init() {
			if ( ! function_exists( 'wp_register_ability' ) ) {
				return;
			}

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
					'description'         => __( 'Moves a page, or another sortable post, to a new position. Pass the ID of the item that should come before it, after it, or both. The item can also move under a new parent when its new neighbors have a different parent.', 'simple-page-ordering' ),
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
						'description' => __( 'ID of the item that should come directly before the moved item. Use 0 for none.', 'simple-page-ordering' ),
						'type'        => 'integer',
						'minimum'     => 0,
						'default'     => 0,
					),
					'nextid'  => array(
						'description' => __( 'ID of the item that should come directly after the moved item. Use 0 for none.', 'simple-page-ordering' ),
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
						'description' => __( 'New position data keyed by item ID. The moved item has menu_order, post_parent and depth. Siblings have their new menu order.', 'simple-page-ordering' ),
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

			$result = Simple_Page_Ordering::page_ordering( $post_id, $previd, $nextid, $start, $exclude );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			// The ordering routine returns the string "children" when the moved item has children.
			if ( 'children' === $result ) {
				return array(
					'success'      => true,
					'new_pos'      => new stdClass(),
					'has_children' => true,
				);
			}

			return array(
				'success'      => true,
				'new_pos'      => (object) ( isset( $result->new_pos ) ? $result->new_pos : array() ),
				'has_children' => false,
			);
		}
	}

	Simple_Page_Ordering_Abilities::init();

endif;
