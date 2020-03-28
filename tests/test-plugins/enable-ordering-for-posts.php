<?php
/**
 * Plugin Name: Enable ordering for posts.
 * Version:     1.0.0
 * Author:      10up Inc.
 * License:     GPLv2 or later
 */

add_action( 'after_setup_theme', function() {
	add_post_type_support( 'post', 'page-attributes' );
} );
