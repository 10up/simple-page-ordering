=== Simple Page Ordering ===
Contributors:      10up, jakemgold, welcher, helen, thinkoomph, jeffpaul
Donate link:       http://10up.com/plugins/simple-page-ordering-wordpress/
Tags:              order, re-order, ordering, page, menu order
Tested up to:      7.0
Stable tag:        2.8.0
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

Order your pages and other custom post types that support "page-attributes" with drag and drop right from the standard page list.

== Description ==

Order your pages, hierarchical custom post types, or custom post types with "page-attributes" with drag and drop right from the built in page list.

Drag and drop the page into the desired position. No new admin menus pages, no clunky, bolted on user interfaces. Drag and drop on the page or post-type screen.

The plug-in is "capabilities aware" - only users with the ability to edit others' pages (editors and administrators) will be able to reorder content.

Integrated help is included: click the "help" tab at the top right of the screen.

Please note that the plug-in is not compatible with Internet Explorer 7 and earlier, due to limitations within those browsers.

=== Contributing ===

We'd love to have you join in on development over on [GitHub](https://github.com/10up/simple-page-ordering).

== Installation ==

1. Install either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Get to work reordering your content!

== Frequently Asked Questions ==

= Why can't I reorder my posts? =

Generic posts are not displayed by menu order - they're displayed by chronology. You can theoretically add menu ordering to posts in your code (theme functions.php, plug-in) by using:

`add_post_type_support( 'post', 'page-attributes' );`

= Can I make my custom post type take advantage of this plug-in? =

Yep. When you register the post type, include the `page-attributes` feature in the support list. This will add a `Sort by Order` option to the filter links above the drop downs. Once you sort by order, you can drag and drop the content.

`'supports' => array( 'title', 'editor', 'page-attributes' ),`

Alternatively, when you register the post type, set `hierarchical` to `true` - hierarchical post types natively order by menu order.

You can also take advantage of the `simple_page_ordering_is_sortable` filter, which passes the result of the default check and the post type name, to override default behavior.

= I want my non-hierarchical post type to be sortable. Help! =

See the previous two answers - just add `page-attributes` to the list of supported post type features.

= I reordered my posts, but the order didn't change on the front end of my site! =

This plug-in doesn't change any *behavior* on the front end, it simply changes the menu order stored in WordPress.

If you want a list of pages or custom post types to display in that defined order, you must change the post query's `orderby` parameter to `menu_order` (if it's not already).

= I reordered my content, it seemed to work, but when I refreshed, it went back to the old order! =

This most likely means the AJAX request - the server side code - failed after you dropped the content into the new position. Some shared hosts aggressively time out and limit AJAX requests. Version 2.0 batches these requests so you can try reducing the number of items it updates on each request using a filter in your theme's functions.php or a custom plug-in:

`add_filter( 'simple_page_ordering_limit', function($number) { return 5; } );`

Where 5 is the number of items to batch on each request (the default is 50). Note that this example uses PHP 5.3+ callback functions, so if you're still on PHP 5.2, you'll need to add a traditional callback.

= What happened to the drop down box that let me change the number of items on each page in the admin? =

This feature is already built into WordPress natively, but a bit tucked away. If you pull down the "Screen Options" tab up top (on the list of post objects) there's a field where you can specify the number of items to show per page. I decided it was not a very good practice to duplicate this.

= How can I modify sortable post types? =

Post types can be included or excluded by using the `simple_page_ordering_is_sortable` filter.

For example, to exclude the `excluded_post_type` custom post type, add the following snippet in the theme function file or custom plugin:

`
add_filter( 'simple_page_ordering_is_sortable', function( $sortable, $post_type ) {
	if ( 'excluded_post_type' === $post_type ) {
		return false;
	}
	return $sortable;
}, 10, 2 );
`

To include the `include_post_type` custom post type, add the following snippet in the theme function file or custom plugin:

`
add_filter( 'simple_page_ordering_is_sortable', function( $sortable, $post_type ) {
	if ( 'include_post_type' === $post_type ) {
		return true;
	}
	return $sortable;
}, 10, 2 );
`

= Can I use REST to order posts? =

Yes. The plugin registers the REST endpoint `simple-page-ordering/v1/page_ordering`.

= Where do I report security bugs found in this plugin? =

Please report security bugs found in the source code of the Simple Page Ordering plugin through the [Patchstack Vulnerability Disclosure  Program](https://patchstack.com/database/vdp/9e5fbbad-6488-4bba-851e-b300dabc33a2).  The Patchstack team will assist you with verification, CVE assignment, and notify the developers of this plugin.

== Screenshots ==

1. Dragging the page to its new position
1. Processing indicator

== Changelog ==

= 2.8.0 - 2026-05-15 =
* **Added:** Add filter to disable page row actions (props [@sanketio](https://github.com/sanketio), [@faisal-alvi](https://github.com/faisal-alvi) via [#249](https://github.com/10up/simple-page-ordering/pull/249)).
* **Fixed:** Resolved issue with emoji in page titles (props [@jamesmorrison](https://github.com/jamesmorrison), [@dkotter](https://github.com/dkotter) via [#248](https://github.com/10up/simple-page-ordering/pull/248)).
* **Changed:** Indicate WordPress 7.0 compatibility (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@jasperfrontend](https://github.com/jasperfrontend), [@jeffpaul](https://github.com/jeffpaul) via [#254](https://github.com/10up/simple-page-ordering/pull/254), [#271](https://github.com/10up/simple-page-ordering/pull/271)).
* **Changed:** Remove bundled translation file in favour of wp.org distributed file (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@dkotter](https://github.com/dkotter) via [#279](https://github.com/10up/simple-page-ordering/pull/279)).
* **Changed:** Bump WordPress minimum supported version to 6.8 (props [@jeffpaul](https://github.com/jeffpaul), [@jasperfrontend](https://github.com/jasperfrontend) via [#271](https://github.com/10up/simple-page-ordering/pull/271)).
* **Security:** Bump 10up-toolkit to 6.5.0 (props [@jamesmorrison](https://github.com/jamesmorrison), [@dkotter](https://github.com/dkotter) via [#247](https://github.com/10up/simple-page-ordering/pull/247)).
* **Security:** Bump `http-proxy-middleware` from 2.0.6 to 2.0.9 and `tar-fs` from 2.1.2 to 3.0.9 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#244](https://github.com/10up/simple-page-ordering/pull/244)).
* **Security:** Bump `bytes` from 3.0.0 to 3.1.2 and `compression` from 1.7.4 to 1.8.1 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#246](https://github.com/10up/simple-page-ordering/pull/246)).
* **Security:** Bump `tmp` from 0.2.1 to 0.2.5, `@wordpress/env` from 9.2.0 to 10.28.0, `inquirer` from 8.2.6 to 8.2.7, `form-data` from 2.3.3 to 4.0.4, and `@cypress/request` from 3.0.1 to 3.0.9 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#250](https://github.com/10up/simple-page-ordering/pull/250)).
* **Security:** Bump `@babel/plugin-transform-modules-systemjs` from 7.23.9 to 7.29.4, `postcss` from 8.4.33 to 8.5.14, and `simple-git` from 3.33.0 to 3.36.0 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#277](https://github.com/10up/simple-page-ordering/pull/277)).
* **Security:** Updates the NPM dependencies throwing security alerts via NPM audit (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@dkotter](https://github.com/dkotter) via [#256](https://github.com/10up/simple-page-ordering/pull/256)).
* **Security:** Bump `lodash` from 4.17.21 to 4.18.1 (props [@dependabot](https://github.com/apps/dependabot), [@dkotter](https://github.com/dkotter) via [#258](https://github.com/10up/simple-page-ordering/pull/258), [#269](https://github.com/10up/simple-page-ordering/pull/269)).
* **Security:** Bump `webpack` from 5.94.0 to 5.105.0 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@dependabot](https://github.com/apps/dependabot) via [#259](https://github.com/10up/simple-page-ordering/pull/259)).
* **Security:** Bump `qs` from 6.14.1 to 6.14.2 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#260](https://github.com/10up/simple-page-ordering/pull/260)).
* **Security:** Bump `immutable` from 4.3.5 to 4.3.8 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#261](https://github.com/10up/simple-page-ordering/pull/261)).
* **Security:** Bump `svgo` from 3.2.0 to 3.3.3 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#262](https://github.com/10up/simple-page-ordering/pull/262)).
* **Security:** Bump `simple-git` from 3.22.0 to 3.33.0 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#263](https://github.com/10up/simple-page-ordering/pull/263)).
* **Security:** Bump `flatted` from 3.2.9 to 3.4.2 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#264](https://github.com/10up/simple-page-ordering/pull/264)).
* **Security:** Bump `picomatch` from 2.3.1 to 2.3.2 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#266](https://github.com/10up/simple-page-ordering/pull/266)).
* **Security:** Bump `node-forge` from 1.3.3 to 1.4.0 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#268](https://github.com/10up/simple-page-ordering/pull/268)).
* **Security:** Bump `follow-redirects` from 1.15.11 to 1.16.0 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#270](https://github.com/10up/simple-page-ordering/pull/270)).
* **Security:** Bump `fast-uri` from 3.1.0 to 3.1.2 (props [@dkotter](https://github.com/dkotter), [@dependabot](https://github.com/apps/dependabot) via [#274](https://github.com/10up/simple-page-ordering/pull/274)).

= 2.7.4 - 2025-05-19 =
* **Changed:** Bump WordPress "tested up to" version 6.8 (props [@jeffpaul](https://github.com/jeffpaul) via [#239](https://github.com/10up/simple-page-ordering/pull/239), [#240](https://github.com/10up/simple-page-ordering/pull/240)).
* **Changed:** Bump WordPress minimum from 6.5 to 6.6 (props [@jeffpaul](https://github.com/jeffpaul) via [#239](https://github.com/10up/simple-page-ordering/pull/239)).
* **Security:** Bump `tar-fs` from 2.1.1 to 3.0.8 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#238](https://github.com/10up/simple-page-ordering/pull/238)).
* **Security:** Bump `@babel/runtime` from 7.23.9 to 7.27.0 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#237](https://github.com/10up/simple-page-ordering/pull/237)).

= 2.7.3 - 2025-03-11 =
* **Changed:** Bump WordPress "tested up to" version 6.7 (props [@sudip-md](https://github.com/sudip-md), [@godleman](https://github.com/godleman), [@jeffpaul](https://github.com/jeffpaul) via [#230](https://github.com/10up/simple-page-ordering/pull/230), [#231](https://github.com/10up/simple-page-ordering/pull/231)).
* **Changed:** Bump WordPress minimum from 6.4 to 6.5 (props [@sudip-md](https://github.com/sudip-md), [@godleman](https://github.com/godleman), [@jeffpaul](https://github.com/jeffpaul) via [#230](https://github.com/10up/simple-page-ordering/pull/230), [#231](https://github.com/10up/simple-page-ordering/pull/231)).
* **Security:** Bump `webpack` from 5.90.0 to 5.94.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#224](https://github.com/10up/simple-page-ordering/pull/224)).
* **Security:** Bump `serve-static` from 1.15.0 to 1.16.2 and `express` from 4.19.2 to 4.21.0 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#226](https://github.com/10up/simple-page-ordering/pull/226)).
* **Security:** Bump `cookie` from 0.6.0 to 0.7.1 and `express` from 4.21.0 to 4.21.1 (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#228](https://github.com/10up/simple-page-ordering/pull/228)).
* **Security:** Bump `serialize-javascript` from 6.0.0 to 6.0.2 and `mocha` from 10.2.0 to 11.1.0 (props [@dependabot](https://github.com/apps/dependabot), [@dkotter](https://github.com/dkotter) via [#232](https://github.com/10up/simple-page-ordering/pull/232)).

= 2.7.2 - 2024-08-21 =
* **Changed:** Bump WordPress "tested up to" version 6.6 (props [@sudip-md](https://github.com/sudip-md), [@ankitguptaindia](https://github.com/ankitguptaindia), [@jeffpaul](https://github.com/jeffpaul) via [#216](https://github.com/10up/simple-page-ordering/pull/216), [#217](https://github.com/10up/simple-page-ordering/pull/217)).
* **Changed:** Bump WordPress minimum from 6.3 to 6.4 (props [@sudip-md](https://github.com/sudip-md), [@ankitguptaindia](https://github.com/ankitguptaindia), [@jeffpaul](https://github.com/jeffpaul) via [#216](https://github.com/10up/simple-page-ordering/pull/216)).
* **Fixed:** Issue where an `Undefined array key` error occurs when a post parent ID does not exist in the `$children_pages` array (props [@xDehy](https://github.com/xDehy), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#219](https://github.com/10up/simple-page-ordering/pull/219)).
* **Security:** Bump `express` from 4.18.2 to 4.19.2, `follow-redirects` from 1.15.5 to 1.15.6, `postcss` from 7.0.39 to 8.4.33, `10up-toolkit` from 5.2.3 to 6.1.0 and `webpack-dev-middleware` from 5.3.3 to 5.3.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#208](https://github.com/10up/simple-page-ordering/pull/208)).
* **Security:** Bump `braces` from 3.0.2 to 3.0.3 and `ws` from 7.5.9 to 7.5.10 (props [@dependabot](https://github.com/apps/dependabot), [@iamdharmesh](https://github.com/iamdharmesh) via [#214](https://github.com/10up/simple-page-ordering/pull/214)).

= 2.7.1 - 2024-06-03 =
* **Added:** The missing Text Domain (props [@alexclassroom](https://github.com/alexclassroom), [@dkotter](https://github.com/dkotter) via [#199](https://github.com/10up/simple-page-ordering/pull/199)).
* **Added:** The "Testing" section in the `CONTRIBUTING.md` file (props [@kmgalanakis](https://github.com/kmgalanakis), [@jeffpaul](https://github.com/jeffpaul) via [#202](https://github.com/10up/simple-page-ordering/pull/202)).
* **Changed:** Bump WordPress "tested up to" version 6.5 (props [@jeffpaul](https://github.com/jeffpaul), [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter) via [#201](https://github.com/10up/simple-page-ordering/pull/201)).
* **Changed:** Bump WordPress minimum from 5.7 to 6.3 (props [@jeffpaul](https://github.com/jeffpaul), [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter) via [#201](https://github.com/10up/simple-page-ordering/pull/201)).
* **Fixed:** Fixed error in call to `get_walked_pages` for custom post types (props [@sissibieber](https://github.com/sissibieber), [@zachgibb](https://github.com/zachgibb), [@peterwilsoncc](https://github.com/peterwilsoncc), [@mjot](https://github.com/mjot), [@jeffpaul](https://github.com/jeffpaul) via [#200](https://github.com/10up/simple-page-ordering/pull/200)).

= 2.7.0 - 2024-04-03 =
* **Added:** Ability to modify the page hierarchy (props [@amityweb](https://github.com/amityweb), [@jeffpaul](https://github.com/jeffpaul), [@peterwilsoncc](https://github.com/peterwilsoncc), [@shannonmfisher](https://github.com/shannonmfisher), [@ankitguptaindia](https://github.com/ankitguptaindia), [@faisal-alvi](https://github.com/faisal-alvi) via [#172](https://github.com/10up/simple-page-ordering/pull/172)).
* **Added:** Support for the WordPress.org plugin preview (props [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#183](https://github.com/10up/simple-page-ordering/pull/183)).
* **Changed:** Replaced custom HTML entity decoding code in favor of the `@wordpress/html-entities` package (props [@helen](https://github.com/helen), [@jeffpaul](https://github.com/jeffpaul), [@psorensen](https://github.com/psorensen), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#189](https://github.com/10up/simple-page-ordering/pull/189)).
* **Changed:** Bump minimum `node` version from `16` to `20` and clean up NPM dependencies (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#188](https://github.com/10up/simple-page-ordering/pull/188)).
* **Changed:** Updated CODEOWNERS (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#186](https://github.com/10up/simple-page-ordering/pull/186)).
* **Changed:** Upgrade the download-artifact from v3 to v4 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#194](https://github.com/10up/simple-page-ordering/pull/194)).
* **Changed:** Replaced [lee-dohm/no-response](https://github.com/lee-dohm/no-response) with [actions/stale](https://github.com/actions/stale) to help with closing no-response/stale issues (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [@195](https://github.com/10up/simple-page-ordering/pull/195)).
* **Changed:** Disabled auto sync pull requests with target branch (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#196](https://github.com/10up/simple-page-ordering/pull/196)).
* **Security:** Bump `@babel/traverse` from `7.20.12` to `7.23.6` (props [@dependabot](https://github.com/apps/dependabot), [@ravinderk](https://github.com/ravinderk) via [#184](https://github.com/10up/simple-page-ordering/pull/184)).
* **Security:** Bump `sharp` from `0.30.7` to `0.32.1` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#182](https://github.com/10up/simple-page-ordering/pull/184)).
* **Security:** Bump `10up-toolkit` from `4.3.1` to `5.2.2` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#182](https://github.com/10up/simple-page-ordering/pull/182)).

= 2.6.3 - 2023-11-09 =
* **Fix:** Deployment issue with version 2.6.2 (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#181](https://github.com/10up/simple-page-ordering/pull/181))

= 2.6.2 - 2023-11-09 =
* **Changed:** Update the `wp-compat-validation-tool` composer package to version `0.3.1` which properly removes the `.git` directory (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#180](https://github.com/10up/simple-page-ordering/pull/180)).

= 2.6.1 - 2023-11-08 =
* **Changed:** Bump WordPress "tested up to" version 6.4 (props [@jeffpaul](https://github.com/jeffpaul), [@qasumitbagthariya](https://github.com/qasumitbagthariya), [@faisal-alvi](https://github.com/faisal-alvi) via [#177](https://github.com/10up/simple-page-ordering/pull/177)).
* **Changed:** Remove the .git directory from the `10up-lib` directory (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#175](https://github.com/10up/simple-page-ordering/pull/175)).
* **Security:** Bumps `@babel/traverse` from `7.20.12` to `7.23.2` (props [@peterwilsoncc](https://github.com/peterwilsoncc) via [#170](https://github.com/10up/simple-page-ordering/pull/170)).

= 2.6.0 - 2023-10-25 =
* **Added:** A check for minimum required PHP version before loading the plugin (props [@vikrampm1](https://github.com/vikrampm1), [@kmgalanakis](https://github.com/kmgalanakis), [@Sidsector9](https://github.com/Sidsector9) via [#153](https://github.com/10up/simple-page-ordering/pull/153)).
* **Added:** Mochawesome reporter added for Cypress test report (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#146](https://github.com/10up/simple-page-ordering/pull/146)).
* **Added:** Repo Automator GitHub Action (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#158](https://github.com/10up/simple-page-ordering/pull/158)).
* **Changed:** Bump WordPress "tested up to" version 6.3 (props [@jeffpaul](https://github.com/jeffpaul), [@QAharshalkadu](https://github.com/QAharshalkadu)).
* **Changed:** Slightly change how some of our text is translated, passing in the post type (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
* **Changed:** Updates the Dependency Review GitHub Action to check for GPL-compatible licenses (props [@jeffpaul](https://github.com/jeffpaul), [@Sidsector9](https://github.com/Sidsector9) via [#147](https://github.com/10up/simple-page-ordering/pull/147)).
* **Changed:** Updated 10up Cypress Utilities to 0.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#160](https://github.com/10up/simple-page-ordering/pull/160)).
* **Fixed:** The "Are you sure..." popup text to be translatable (props [@kebbet](https://github.com/kebbet), [@bmarshall511](https://github.com/bmarshall511), [@dkotter](https://github.com/dkotter) via [#148](https://github.com/10up/simple-page-ordering/pull/148)).
* **Fixed:** Remove code that was no longer needed (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
* **Fixed:** Add missing escaping (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
* **Fixed:** Fatal error following the introduction of a namespace (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@iamdharmesh](https://github.com/iamdharmesh), [@dkotter](https://github.com/dkotter) via [#162](https://github.com/10up/simple-page-ordering/pull/162)).
* **Fixed:** Hidden pagination in admin screen when Sort by Order is clicked (props [@tlovett1](https://github.com/tlovett1), [@dkotter](https://github.com/dkotter), [@Sidsector9](https://github.com/Sidsector9) via [#165](https://github.com/10up/simple-page-ordering/pull/165)).
* **Fixed:** Fatal errors on PHP 5.6 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@Sidsector9](https://github.com/Sidsector9), [@iamdharmesh](https://github.com/iamdharmesh) via [#166](https://github.com/10up/simple-page-ordering/pull/166)).
* **Security:** Bump `word-wrap` from 1.2.3 to 1.2.4 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#](https://github.com/10up/simple-page-ordering/pull/151)).
* **Security:** Bump `tough-cookie` from 4.1.2 to 4.1.3 (props [@faisal-alvi](https://github.com/faisal-alvi) via [#152](https://github.com/10up/simple-page-ordering/pull/152)).
* **Security:** Bump `node-sass` from 7.0.3 to 9.0.0 (props [@faisal-alvi](https://github.com/faisal-alvi) via [#152](https://github.com/10up/simple-page-ordering/pull/152)).
* **Security:** Bump `@cypress/request` from 2.88.11 to 3.0.0 to resolve SSRF issue (props [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh), [@peterwilsoncc](https://github.com/peterwilsoncc), [@dkotter](https://github.com/dkotter) via [#152](https://github.com/10up/simple-page-ordering/pull/152), [#160](https://github.com/10up/simple-page-ordering/pull/160)).

[View historical changelog details here](https://github.com/10up/simple-page-ordering/blob/develop/CHANGELOG.md).

== Upgrade Notice ==

= 2.8.0 =
This release bumps the minimum required version of WordPress from 6.6 to 6.8.

= 2.7.4 =
This release bumps the minimum required version of WordPress from 6.5 to 6.6.

= 2.7.3 =
This release bumps the minimum required version of WordPress from 6.4 to 6.5.

= 2.7.2 =
This release bumps the minimum required version of WordPress from 6.3 to 6.4.

= 2.5.0 =
This release bumps the minimum required versions of PHP from 5.6 to 7.4 and WordPress from 3.8 to 5.7.

