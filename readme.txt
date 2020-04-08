=== Simple Page Ordering ===
Contributors: 10up, jakemgold, welcher, helen, thinkoomph
Donate link: http://10up.com/plugins/simple-page-ordering-wordpress/
Tags: order, re-order, ordering, pages, page, manage, menu_order, hierarchical, ajax, drag-and-drop, admin
Requires at least: 3.8
Tested up to: 5.4
Stable tag: 2.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Order your pages and other hierarchical post types with simple drag and drop right from the standard page list.

== Description ==

Order your pages, hierarchical custom post types, or custom post types with "page-attributes" with simple drag and drop right from the built in page list.

Simply drag and drop the page into the desired position. It's that simple. No new admin menus pages, no clunky, bolted on user interfaces. Just drag and drop on the page or post-type screen.

The plug-in is "capabilities aware" - only users with the ability to edit others' pages (editors and administrators) will be able to reorder content.

Integrated help is included: just click the "help" tab at the top right of the screen.

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

Yep. There are two ways to turn on support for Simple Page Ordering.

Ideally, when you register the post type, set `hierarchical` to `true` - hierarchical post types natively order by menu order.

Alternatively, when you define the features the post type supports, include `page-attributes`. This will add a `Sort by Order` option to the filter links above the drop downs. Once you sort by order, you can drag and drop the content.

Finally, you can take advantage of the `simple_page_ordering_is_sortable` filter, which passes the result of the default check and the post type name, to override default behavior.

= I want my non-hierarchical post type to be sortable. Help! =

See the previous two answers - just add `page-attributes` to the list of supported post type features.

= I reordered my posts, but the order didn't change on the front end of my site! =

This plug-in doesn't change any *behavior* on the front end, it simply changes the menu order stored in WordPress.

If you want a list of pages or custom post types to display in that defined order, you must change the post query's `orderby` parameter to `menu_order` (if it's not already).

= I reordered my content, it seemed to work, but when I refreshed, it went back to the old order! =

This most likely means the AJAX request - the server side code - failed after you dropped the content into the new position. Some shared hosts aggressively time out and limit AJAX requests. Version 2.0 batches these requests so you can try reducing the number of items it updates on each request using a filter in your theme's functions.php or a custom plug-in:

`add_filter( 'simple_page_ordering_limit', function($number) { return 5; } );`

Where 5 is the number of items to batch on each request (the default is 50). Note that this example uses PHP 5.3+ callback functions, so if you're still on PHP 5.2, you'll need to add a traditional callback.

= What happened to the drop down box that let me change the number of items on each page in the admin?? =

This feature is already built into WordPress natively, but a bit tucked away. If you pull down the "Screen Options" tab up top (on the list of post objects) there's a field where you can specify the number of items to show per page. I decided it was not a very good practice to duplicate this.

== Screenshots ==

1. Dragging the page to its new position
1. Processing indicator

== Changelog ==

= 2.3.4 =
* **Changed:** Avoid failed reordering introduced in v2.3.3 when handling a large number of non-hierarchical items (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/))
* **Changed:** Bump WordPress version support to 5.4 (props [@tmoorewp](https://profiles.wordpress.org/tmoorewp/))
* **Fixed:** Ensure titles of reordered items appear in a human-readable way (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/))

= 2.3.3 =
* **Added:** Nonce verify for AJAX requests (props [@williampatton](https://profiles.wordpress.org/williampatton/), [@dtbaker](https://profiles.wordpress.org/dtbaker/))
* **Changed:** Disable Post Revisions now using the correct action of `post_updated` (props [@blue-liquid-designs](https://profiles.wordpress.org/blue-liquid-designs/))
* **Changed:** Bump WordPress version "tested up to" 5.3 (props [@adamsilverstein](https://profiles.wordpress.org/adamsilverstein/), [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/))
* **Changed:** Documentation updates (props [@jeffpaul](https://profiles.wordpress.org/jeffpaul/))
* **Fixed:** Mismatched localized data variable name (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/))
* **Fixed:** VIP Go coding standards (props [@mrasharirfan](https://profiles.wordpress.org/mrasharirfan/), [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@pereirinha](https://profiles.wordpress.org/pereirinha/), [@brentvr](https://profiles.wordpress.org/brentvr/))

= 2.3.2 =
* **Added:** Allow cancellation of drag operation by pressing escape key
* **Fixed:** Allow form input elements added to a row by plugins to be interacted with

= 2.3.1 =
* **Fixed:** Prevent rows with hidden columns from jumping around while dragging

= 2.3.0 =
* **Added:** Use WordPress core's spinner class
* **Added:** Grunt-based build process with Sass
* **Changed:** Use `WP_Query` instead of `get_posts()` for better performance
* **Changed:** Remove bundled translations in favor of WordPress.org language packs
* **Fixed:** Avoid exceeding PHP's max input variables, which could cause incorrectly assigned page order
* **Fixed:** Malformed URL that would take you to posts instead of pages
* **Fixed:** PHPDoc and coding standards to align with 10up's Engineering Best Practices

= 2.2.4 =
* **Fixed:** Redundant URL encoding when sorting in admin page list

= 2.2.3 =
* **Fixed:** Ordering in WordPress 4.0 following core changes to `ORDER BY` in `WP_Query`

= 2.2.2 =
* **Added:** German localization (props [@glueckpress](https://profiles.wordpress.org/glueckpress/))
* **Fixed:** Column widths no longer change when dragging a row (partial props [@griffinjt](https://profiles.wordpress.org/griffinjt/))
* **Security:** Closed obscure XSS vulnerability related to Sort by Order link (props [@simon-waters](https://profiles.wordpress.org/simon-waters/))

= 2.2.1 =
* **Added:** Brazilian translation (props [@felds](https://profiles.wordpress.org/felds/))
* **Fixed:** Bring back translations / text domain (yikes!)

= 2.2.0 =
* **Changed:** Look and feel to better match WordPress 3.8 admin redesign
* **Changed:** Improved awareness of and compatibility with Quick Edit (inline editor)
* **Fixed:** Prevent collisions with themes and plugins bundling Simple Page Ordering

= 2.1.2 =
* **Fixed:** Hierarchical custom post types without page-attributes was still broken - doh!
* **Fixed:** Extreme edge case where post columns did not include the post title now supported

= 2.1.1 =
* **Fixed:** custom post types with page-attributes or hierarchical properties, but not both, breaking ordering

= 2.1.0 =
* **Added:** Awareness of custom user capabilities for post types, in addition to a filter (`simple_page_ordering_edit_rights`) for overriding reordering rights (previously used `edit_others_pages` globally)
* **Added:** Awareness of custom post statuses (so they are not skipped during backend ordering operation)
* **Changed:** UI refinements: Better "spinner" positioning (and HiDPI), translucent row when moving, improved appearance of "drop" placeholder, wait till row dragged by at least 5px to start sorting
* **Changed:** Major JavaScript refactoring and simplification (combined with new stylesheet) for better performance

= 2.0.0 =
* **Added:** Drag pages into any part of the page hierarchy! No longer limited to same branch of tree!
* **Added:** Big performance improvements under the hood: leaner queries, batched requests, less processing
* **Added:** New filters and hooks to extend / override default functionality
* **Changed:** Scales much more reliably in situations with very high page counts due to batching of requests
* **Changed:** Order of the first page is now set to "1" instead of "0", so pages added after ordering are added at the top (instead of second)
* **Changed:** Removed "number of pages" drop down, which is repetitive of a field accessible under Screen Options
* **Changed:** Improved compatibility with newer versions of WordPress

= 1.0.0 =
* **Added:** Support for ordering non-hierarchical post types that have "page-attributes" support
* **Added:** New filter link for "Sort by Order" to restore (hierarchical) or set (non-hierarchical, page attributes support) post list sort to menu order
* **Changed:** Users are now forced to wait for current sort operation to finish before they can sort another item
* **Changed:** Smarter about "not sortable" view states
* **Changed:** Localization ready! Rough Spanish translation included.
* **Changed:** Assorted other performance and code improvements
* **Fixed:** Unexpected page ordering results when pages have not been explictly ordered yet (sorts by menu_order, then title, not just menu_order)
* **Fixed:** "Per page" drop down filter selection not saving between page loads (was broken in 3.1)
* **Fixed:** Items are always ordered with positive integers (potential negative sort orders had some performance benefits in last version, but sometimes caused issues)

= 0.9.6 =
* **Fixed:** for broken inline editing (quick edit) fields in Firefox

= 0.9.5 =
* **Changed:** Smarter awareness of "sorted" modes in WordPress 3.1 (can only use when sorted by menu order)
* **Changed:** Smarter awareness of "quick edit" mode (can't drag)
* **Changed:** Generally simplified / better organized code

= 0.9.0 =
* **Added:** Further directions in the plug-in description (some users were confused about how to use it)
* **Added:** Basic compatibility with 3.1 RC (prevent clashes with post list sorting)
* **Changed:** "Move" cursor only set if JavaScript enabled
* **Fixed:** Page count display always showing "0" on non-hierarchical post types (Showing 1-X of X)
* **Fixed:** Hidden menu order not updating after sort (causing Quick Edit to reset order when used right after sorting)

= 0.8.4 =
* **Changed:** Loosened constraints on drag and drop to ease dropping into top and bottom position
* **Changed:** Improved some terminology (with custom post types in mind)
* **Fixed:** Row background staying "white" after dropping into a new position
* **Fixed:** Double border on the bottom of the row while dragging

= 0.8.2 =
* **Changed:** Simplified code - consolidated hooks
* **Changed:** Updated version requirements
