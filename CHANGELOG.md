# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/).

## [2.3.2] - 2018-05-08
### Added
- Allow cancellation of drag operation by pressing escape key

### Fixed
- Allow form input elements added to a row by plugins to be interacted with

## [2.3.1] - 2018-04-13
### Fixed
- Prevent rows with hidden columns from jumping around while dragging

## [2.3] - 2018-03-06
### Added
- Use WordPress core's spinner class
- Grunt-based build process with Sass

### Changed
- Use `WP_Query` instead of `get_posts()` for better performance
- Remove bundled translations in favor of WordPress.org language packs

### Fixed
- Avoid exceeding PHP's max input variables, which could cause incorrectly assigned page order
- Malformed URL that would take you to posts instead of pages
- PHPDoc and coding standards to align with 10up's Engineering Best Practices

## [2.2.4] - 2018-03-06
### Fixed
- Redundant URL encoding when sorting in admin page list

## [2.2.3] - 
### Fixed
- Ordering in WordPress 4.0 following core changes to ORDER BY in WP_Query

## [2.2.2] - 
### Added
- German localization (props [@glueckpress](https://github.com/glueckpress)).

### Fixed
- Column widths no longer change when dragging a row (partial props griffinjt)

### Security
- Closed obscure XSS vulnerability related to Sort by Order link (props simon-waters)

## [2.2.1] - 
### Added
- Brazilian translation (props to "felds")

### Fixed
- Bring back translations / text domain (yikes!)

## [2.2] - 
### Changed
- Look and feel to better match WordPress 3.8 admin redesign
- Improved awareness of and compatibility with Quick Edit (inline editor)

### Fixed
- Prevent collisions with themes and plugins bundling Simple Page Ordering

## [2.1.2] - 
### Fixed
- Extreme edge case where post columns did not include the post title now supported

## [2.1.1] - 
### Fixed
- Custom post types with page-attributes or hierarchical properties, but not both, breaking ordering

## [2.1] - 
### Added
- Awareness of custom user capabilities for post types, in addition to a filter (`simple_page_ordering_edit_rights`) for overriding reordering rights (previously used `edit_others_pages` globally)
- Awareness of custom post statuses (so they are not skipped during backend ordering operation)

### Changed
- UI refinements: Better "spinner" positioning (and HiDPI), translucent row when moving, improved appearance of "drop" placeholder, wait till row dragged by at least 5px to start sorting
- Major JavaScript refactoring and simplification (combined with new stylesheet) for better performance

## [2.0] - 
### Added
- Drag pages into any part of the page hierarchy! No longer limited to same branch of tree!
- Big performance improvements under the hood: leaner queries, batched requests, less processing
- New filters and hooks to extend / override default functionality

### Changed
- Scales much more reliably in situations with very high page counts due to batching of requests
- Order of the first page is now set to "1" instead of "0", so pages added after ordering are added at the top (instead of second)
- Removed "number of pages" drop down, which is repetitive of a field accessible under Screen Options
- Improved compatibility with newer versions of WordPress

## [1.0] - 
### Added
- Support for ordering non-hierarchical post types that have "page-attributes" support
- New filter link for "Sort by Order" to restore (hierarchical) or set (non-hierarchical, page attributes support) post list sort to menu order

### Changed
- Users are now forced to wait for current sort operation to finish before they can sort another item
- Smarter about "not sortable" view states
- Localization ready! Rough Spanish translation included.
- Assorted other performance and code improvements

### Fixed
- Unexpected page ordering results when pages have not been explictly ordered yet (sorts by menu_order, then title, not just menu_order)
- "Per page" drop down filter selection not saving between page loads (was broken in 3.1)
- Items are always ordered with positive integers (potential negative sort orders had some performance benefits in last version, but sometimes caused issues)

## [0.9.6] - 
### Fixed
- Broken inline editing (quick edit) fields in Firefox

## [0.9.5] - 
### Changed
- Smarter awareness of "sorted" modes in WordPress 3.1 (can only use when sorted by menu order)
- Smarter awareness of "quick edit" mode (can't drag)
- Generally simplified / better organized code

## [0.9] - 
### Added
- Further directions in the plug-in description (some users were confused about how to use it)
- Basic compatibility with 3.1 RC (prevent clashes with post list sorting)

### Changed
- "Move" cursor only set if JavaScript enabled

### Fixed
- Page count display always showing "0" on non-hierarchical post types (Showing 1-X of X)
- Hidden menu order not updating after sort (causing Quick Edit to reset order when used right after sorting)

## [0.8.4] - 
### Changed
- Loosened constraints on drag and drop to ease dropping into top and bottom position
- Improved some terminology (with custom post types in mind)

### Fixed
- Row background staying "white" after dropping into a new position
- Double border on the bottom of the row while dragging

## [0.8.2] - 
### Changed
- Simplified code - consolidated hooks
- Updated version requirements

[2.3.2]: https://github.com/10up/simple-page-ordering/compare/2.3.1...2.3.2
[2.3.1]: https://github.com/10up/simple-page-ordering/compare/2.3...2.3.1
[2.3]: https://github.com/10up/simple-page-ordering/compare/2.2.4...2.3
[2.2.4]: https://github.com/10up/simple-page-ordering/releases/tag/2.2.4
