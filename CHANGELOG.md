# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/), and will adhere to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased] - TBD

## [2.4.0] - 2022-04-28
### Added
- REST API for reordering posts: `/wp-json/simplepageordering/v1/page_ordering/` (props [@rmccue](https://github.com/rmccue), [@ciprianimike](https://github.com/ciprianimike), [@cadic](https://github.com/cadic), [@lkraav](https://github.com/lkraav), [@dinhtungdu](https://github.com/dinhtungdu) via [#74](https://github.com/10up/simple-page-ordering/pull/74)).
- [REST Endpoint Documentation](https://github.com/10up/simple-page-ordering/blob/develop/README.md).
- Documentation to exclude post types (props [@dzulfriday](https://profiles.wordpress.org/dzulfriday/) [@dinhtungdu](https://github.com/dinhtungdu), [@jeffpaul](https://github.com/jeffpaul) via [#60](https://github.com/10up/simple-page-ordering/pull/60)).
- PHP8 compatibility testing GitHub Action (props [@Sidsector9](https://profiles.wordpress.org/Sidsector9/), [@iamdharmesh](https://github.com/iamdharmesh) via [#84](https://github.com/10up/simple-page-ordering/pull/84)).
- Cypress E2E tests (props [@dinhtungdu](https://github.com/dinhtungdu), [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#82](https://github.com/10up/simple-page-ordering/pull/82)).
- Dependency security scanning GiHhub Action (props [@jeffpaul](https://github.com/jeffpaul), [Sidsector9](https://profiles.wordpress.org/Sidsector9/) via [#86](https://github.com/10up/simple-page-ordering/pull/86)).

### Changed
- `PLUGIN_VERSION` to `SIMPLE_PAGE_ORDERING_VERSION` (props [@dinhtungdu](https://github.com/dinhtungdu), [@dkotter](https://github.com/dkotter) via [#81](https://github.com/10up/simple-page-ordering/pull/81)).
- Bump WordPress "tested up to" version to 5.9 (props [@ankitguptaindia](https://github.com/ankitguptaindia), [@phpbits](https://github.com/phpbits), [@sudip-10up](https://github.com/sudip-10up) via [#69](https://github.com/10up/simple-page-ordering/pull/69), [#72](https://github.com/10up/simple-page-ordering/pull/72), [#76](https://github.com/10up/simple-page-ordering/pull/76)).

### Security
- Bump `rmccue/requests` from 1.7.0 to 1.8.0 (props [@dependabot](https://github.com/apps/dependabot) via [#70](https://github.com/10up/simple-page-ordering/pull/70)).
- Bump `async` from 2.6.3 to 2.6.4 (props [@dependabot](https://github.com/apps/dependabot) via [#87](https://github.com/10up/simple-page-ordering/pull/87)).

## [2.3.4] - 2020-04-07
### Added
- Acceptance testing using [WP Acceptance](https://github.com/10up/wpacceptance/) (props [@dinhtungdu](https://github.com/dinhtungdu) via [#42](https://github.com/10up/simple-page-ordering/pull/42)).

### Changed
- Avoid failed reordering introduced in v2.3.3 when handling a large number of non-hierarchical items (props [@dinhtungdu](https://github.com/dinhtungdu) via [#51](https://github.com/10up/simple-page-ordering/pull/51)).
- Bump WordPress version support to 5.4 (props [@tmoorewp](https://github.com/tmoorewp) via [#50](https://github.com/10up/simple-page-ordering/pull/50)).

### Fixed
- Ensure titles of reordered items appear in a human-readable way (props [@dinhtungdu](https://github.com/dinhtungdu) via [#53](https://github.com/10up/simple-page-ordering/pull/53)).

## [2.3.3] - 2020-03-04
### Added
- Nonce verify for AJAX requests (props [@pattonwebz](https://github.com/pattonwebz), [@dtbaker](https://github.com/dtbaker) via [#23](https://github.com/10up/simple-page-ordering/pull/23)).

### Changed
- Disable Post Revisions now using the correct action of `post_updated` (props [@jakejackson1](https://github.com/jakejackson1) via [#26](https://github.com/10up/simple-page-ordering/pull/26)).
- Bump WordPress version "tested up to" 5.3 (props [@adamsilverstein](https://github.com/adamsilverstein), [@dinhtungdu](https://github.com/dinhtungdu) via [#30](https://github.com/10up/simple-page-ordering/pull/30), [#36](https://github.com/10up/simple-page-ordering/pull/36)).
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul) via [#31](https://github.com/10up/simple-page-ordering/pull/31), [#33](https://github.com/10up/simple-page-ordering/pull/33)).

### Fixed
- Mismatched localized data variable name (props [@dinhtungdu](https://github.com/dinhtungdu) via [#36](https://github.com/10up/simple-page-ordering/pull/36)).
- VIP Go coding standards (props [@asharirfan](https://github.com/asharirfan), [@dinhtungdu](https://github.com/dinhtungdu), [@pereirinha](https://github.com/pereirinha), [@brentvr](https://github.com/brentvr) via [#38](https://github.com/10up/simple-page-ordering/pull/38)).

## [2.3.2] - 2018-05-08
### Added
- Allow cancellation of drag operation by pressing escape key.

### Fixed
- Allow form input elements added to a row by plugins to be interacted with.

## [2.3.1] - 2018-04-13
### Fixed
- Prevent rows with hidden columns from jumping around while dragging.

## [2.3.0] - 2018-03-05
### Added
- Use WordPress core's spinner class.
- Grunt-based build process with Sass.

### Changed
- Use `WP_Query` instead of `get_posts()` for better performance.
- Remove bundled translations in favor of WordPress.org language packs.

### Fixed
- Avoid exceeding PHP's max input variables, which could cause incorrectly assigned page order.
- Malformed URL that would take you to posts instead of pages.
- PHPDoc and coding standards to align with 10up's Engineering Best Practices.

## [2.2.4] - 2015-02-08
### Fixed
- Redundant URL encoding when sorting in admin page list.

## [2.2.3] - 2014-09-27
### Fixed
- Ordering in WordPress 4.0 following core changes to `ORDER BY` in `WP_Query`.

## [2.2.2] - 2014-08-19
### Added
- German localization (props [@glueckpress](https://github.com/glueckpress)).

### Fixed
- Column widths no longer change when dragging a row (partial props [@thomasgriffin](https://github.com/thomasgriffin)).

### Security
- Closed obscure XSS vulnerability related to Sort by Order link (props [@SimonWaters](https://github.com/SimonWaters)).

## [2.2.1] - 2014-05-31
### Added
- Brazilian translation (props to "felds").

### Fixed
- Bring back translations / text domain (yikes!).

## [2.2.0] - 2014-04-06
### Changed
- Look and feel to better match WordPress 3.8 admin redesign.
- Improved awareness of and compatibility with Quick Edit (inline editor).

### Fixed
- Prevent collisions with themes and plugins bundling Simple Page Ordering.

## [2.1.2] - 2013-05-30
### Fixed
- Extreme edge case where post columns did not include the post title now supported.

## [2.1.1] - 2013-05-27
### Fixed
- Custom post types with page-attributes or hierarchical properties, but not both, breaking ordering.

## [2.1.0] - 2013-05-19
### Added
- Awareness of custom user capabilities for post types, in addition to a filter (`simple_page_ordering_edit_rights`) for overriding reordering rights (previously used `edit_others_pages` globally).
- Awareness of custom post statuses (so they are not skipped during backend ordering operation).

### Changed
- UI refinements: Better "spinner" positioning (and HiDPI), translucent row when.moving, improved appearance of "drop" placeholder, wait till row dragged by at least 5px to start sorting.
- Major JavaScript refactoring and simplification (combined with new stylesheet) for better performance.

## [2.0.0] - 2012-11-12
### Added
- Drag pages into any part of the page hierarchy! No longer limited to same branch of tree!
- Big performance improvements under the hood: leaner queries, batched requests, less processing.
- New filters and hooks to extend / override default functionality.

### Changed
- Scales much more reliably in situations with very high page counts due to batching of requests.
- Order of the first page is now set to "1" instead of "0", so pages added after ordering are added at the top (instead of second).
- Removed "number of pages" drop down, which is repetitive of a field accessible under Screen Options.
- Improved compatibility with newer versions of WordPress.

## [1.0.0] - 2011-07-04
### Added
- Support for ordering non-hierarchical post types that have "page-attributes" support.
- New filter link for "Sort by Order" to restore (hierarchical) or set (non-hierarchical, page attributes support) post list sort to menu order.

### Changed
- Users are now forced to wait for current sort operation to finish before they can sort another item.
- Smarter about "not sortable" view states.
- Localization ready! Rough Spanish translation included.
- Assorted other performance and code improvements.

### Fixed
- Unexpected page ordering results when pages have not been explictly ordered yet (sorts by menu_order, then title, not just menu_order).
- "Per page" drop down filter selection not saving between page loads (was broken in 3.1).
- Items are always ordered with positive integers (potential negative sort orders had some performance benefits in last version, but sometimes caused issues).

## [0.9.6] - 2011-04-04
### Fixed
- Broken inline editing (quick edit) fields in Firefox.

## [0.9.5] - 2011-03-27
### Changed
- Smarter awareness of "sorted" modes in WordPress 3.1 (can only use when sorted by menu order).
- Smarter awareness of "quick edit" mode (can't drag).
- Generally simplified / better organized code.

## [0.9.0] - 2010-12-29
### Added
- Further directions in the plug-in description (some users were confused about how to use it).
- Basic compatibility with 3.1 RC (prevent clashes with post list sorting).

### Changed
- "Move" cursor only set if JavaScript enabled.

### Fixed
- Page count display always showing "0" on non-hierarchical post types (Showing 1-X of X).
- Hidden menu order not updating after sort (causing Quick Edit to reset order when used right after sorting).

## [0.8.4] - 2010-08-24
### Changed
- Loosened constraints on drag and drop to ease dropping into top and bottom position.
- Improved some terminology (with custom post types in mind).

### Fixed
- Row background staying "white" after dropping into a new position.
- Double border on the bottom of the row while dragging.

## [0.8.2] - 2010-08-21
### Changed
- Simplified code - consolidated hooks.
- Updated version requirements.

[Unreleased]: https://github.com/10up/simple-page-ordering/compare/master...develop
[2.4.0]: https://github.com/10up/simple-page-ordering/compare/2.3.4...2.4.0
[2.3.4]: https://github.com/10up/simple-page-ordering/compare/2.3.3...2.3.4
[2.3.3]: https://github.com/10up/simple-page-ordering/compare/2.3.2...2.3.3
[2.3.2]: https://github.com/10up/simple-page-ordering/compare/2.3.1...2.3.2
[2.3.1]: https://github.com/10up/simple-page-ordering/compare/2.3...2.3.1
[2.3.0]: https://github.com/10up/simple-page-ordering/compare/2.2.4...2.3
[2.2.4]: https://github.com/10up/simple-page-ordering/releases/tag/2.2.4
