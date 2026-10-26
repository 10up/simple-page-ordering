<?php
/**
 * Plugin Name: Enable new item position for tests.
 * Version:     1.0.0
 * Author:      10up Inc.
 * License:     GPLv2 or later
 */

/**
 * Enable the new item position filter for a single test.
 *
 * The position is read from the `spo_test_new_post_position` option so tests
 * can opt in and other tests keep the plugin's default behavior.
 */
add_filter(
	'simple_page_ordering_new_post_position',
	function ( $position ) {
		$option = get_option( 'spo_test_new_post_position' );

		if ( in_array( $option, array( 'top', 'bottom' ), true ) ) {
			return $option;
		}

		return $position;
	}
);
