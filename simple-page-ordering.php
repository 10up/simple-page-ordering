<?php
/**
 * Plugin Name:       Simple Page Ordering
 * Plugin URI:        http://10up.com/plugins/simple-page-ordering-wordpress/
 * Description:       Order your pages and hierarchical post types using drag and drop on the built in page list. For further instructions, open the "Help" tab on the Pages screen.
 * Version:           2.7.4
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            10up
 * Author URI:        https://10up.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-page-ordering
 *
 * @package simple-page-ordering
 */

if ( ! is_readable( __DIR__ . '/10up-lib/wp-compat-validation-tool/src/Validator.php' ) ) {
	return;
}

// Useful global constants.
require_once '10up-lib/wp-compat-validation-tool/src/Validator.php';

$compat_checker = new \Simple_Page_Ordering_Validator\Validator();
$compat_checker
	->set_plugin_name( 'Simple Page Ordering' )
	->set_php_min_required_version( '7.4' );

if ( ! $compat_checker->is_plugin_compatible() ) {
	return;
}

require_once 'class-simple-page-ordering.php';
