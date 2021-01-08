# Simple Page Ordering

> Order your pages and other hierarchical post types with simple drag and drop right from the standard page list.

[![Support Level](https://img.shields.io/badge/support-active-green.svg)](#support-level) [![Release Version](https://img.shields.io/github/release/10up/simple-page-ordering.svg)](https://github.com/10up/simple-page-ordering/releases/latest) ![WordPress tested up to version](https://img.shields.io/badge/WordPress-v5.4%20tested-success.svg) [![GPLv2 License](https://img.shields.io/github/license/10up/simple-page-ordering.svg)](https://github.com/10up/simple-page-ordering/blob/develop/LICENSE.md)

Order your pages, hierarchical custom post types, or custom post types with "page-attributes" with simple drag and drop right from the built in page list.

Simply drag and drop the page into the desired position. It's that simple. No new admin menus pages, no clunky, bolted on user interfaces. Just drag and drop on the page or post-type screen.

The plug-in is "capabilities aware" - only users with the ability to edit others' pages (editors and administrators) will be able to reorder content.

Integrated help is included: just click the "help" tab at the top right of the screen.

Please note that the plug-in is not compatible with Internet Explorer 7 and earlier, due to limitations within those browsers.

Want to help? Check out our [contributing guidelines](CONTRIBUTING.md) to get started.

## Installation

1. Install either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Get to work reordering your content!

## Frequently Asked Questions

### Why can't I reorder my posts?

Generic posts are not displayed by menu order - they're displayed by chronology. You can theoretically add menu ordering to posts in your code (theme functions.php, plug-in) by using:

`add_post_type_support( 'post', 'page-attributes' );`

### Can I make my custom post type take advantage of this plug-in?

Yep. There are two ways to turn on support for Simple Page Ordering.

Ideally, when you register the post type, set `hierarchical` to `true` - hierarchical post types natively order by menu order.

Alternatively, when you define the features the post type supports, include `page-attributes`. This will add a `Sort by Order` option to the filter links above the drop downs. Once you sort by order, you can drag and drop the content.

Finally, you can take advantage of the `simple_page_ordering_is_sortable` filter, which passes the result of the default check and the post type name, to override default behavior.

### I want my non-hierarchical post type to be sortable. Help!

See the previous two answers - just add `page-attributes` to the list of supported post type features.

### I reordered my posts, but the order didn't change on the front end of my site!

This plug-in doesn't change any *behavior* on the front end, it simply changes the menu order stored in WordPress.

If you want a list of pages or custom post types to display in that defined order, you must change the post query's `orderby` parameter to `menu_order` (if it's not already).

### I reordered my content, it seemed to work, but when I refreshed, it went back to the old order!

This most likely means the AJAX request - the server side code - failed after you dropped the content into the new position. Some shared hosts aggressively time out and limit AJAX requests. Version 2.0 batches these requests so you can try reducing the number of items it updates on each request using a filter in your theme's functions.php or a custom plug-in:

`add_filter( 'simple_page_ordering_limit', function($number) { return 5; } );`

Where 5 is the number of items to batch on each request (the default is 50). Note that this example uses PHP 5.3+ callback functions, so if you're still on PHP 5.2, you'll need to add a traditional callback.

### What happened to the drop down box that let me change the number of items on each page in the admin?

This feature is already built into WordPress natively, but a bit tucked away. If you pull down the "Screen Options" tab up top (on the list of post objects) there's a field where you can specify the number of items to show per page. I decided it was not a very good practice to duplicate this.

### How can I exclude certain custom post types?

Custom post types can be excluded by using the `simple_page_ordering_is_sortable` filter.

For example, with `excluded_post_type` as the custom post type ID, add the following snippet in the theme function file or custom plugin:

```
add_filter( 'simple_page_ordering_is_sortable', function( $sortable, $post_type ) {
	if ( 'excluded_post_type' === $post_type ) {
		return false;
	}
	return $sortable;
}, 10, 2 );
```

## Support Level

**Active:** 10up is actively working on this, and we expect to continue work for the foreseeable future including keeping tested up to the most recent version of WordPress.  Bug reports, feature requests, questions, and pull requests are welcome.

## Changelog

A complete listing of all notable changes to Simple Page Ordering are documented in [CHANGELOG.md](https://github.com/10up/simple-page-ordering/blob/develop/CHANGELOG.md).

## Contributing

Please read [CODE_OF_CONDUCT.md](https://github.com/10up/simple-page-ordering/blob/develop/CODE_OF_CONDUCT.md) for details on our code of conduct, [CONTRIBUTING.md](https://github.com/10up/simple-page-ordering/blob/develop/CONTRIBUTING.md) for details on the process for submitting pull requests to us, and [CREDITS.md](https://github.com/10up/simple-page-ordering/blob/develop/CREDITS.md) for a listing of maintainers, contributors, and libraries for Simple Page Ordering.

## Like what you see?

<p align="center">
<a href="http://10up.com/contact/"><img src="https://10up.com/uploads/2016/10/10up-Github-Banner.png" width="850"></a>
</p>
