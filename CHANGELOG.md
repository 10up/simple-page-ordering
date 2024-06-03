# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/), and will adhere to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased] - TBD

## [2.7.1] - 2024-06-03
### Added
- The missing Text Domain (props [@alexclassroom](https://github.com/alexclassroom), [@dkotter](https://github.com/dkotter) via [#199](https://github.com/10up/simple-page-ordering/pull/199)).
- The "Testing" section in the `CONTRIBUTING.md` file (props [@kmgalanakis](https://github.com/kmgalanakis), [@jeffpaul](https://github.com/jeffpaul) via [#202](https://github.com/10up/simple-page-ordering/pull/202)).

### Changed
- Bump WordPress "tested up to" version 6.5 (props [@jeffpaul](https://github.com/jeffpaul), [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter) via [#201](https://github.com/10up/simple-page-ordering/pull/201)).
- Bump WordPress minimum from 5.7 to 6.3 (props [@jeffpaul](https://github.com/jeffpaul), [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter) via [#201](https://github.com/10up/simple-page-ordering/pull/201)).

### Fixed
- Fixed error in call to `get_walked_pages` for custom post types (props [@sissibieber](https://github.com/sissibieber), [@zachgibb](https://github.com/zachgibb), [@peterwilsoncc](https://github.com/peterwilsoncc), [@mjot](https://github.com/mjot), [@jeffpaul](https://github.com/jeffpaul) via [#200](https://github.com/10up/simple-page-ordering/pull/200)).

## [2.7.0] - 2024-04-03
### Added
- Ability to modify the page hierarchy (props [@amityweb](https://github.com/amityweb), [@jeffpaul](https://github.com/jeffpaul), [@peterwilsoncc](https://github.com/peterwilsoncc), [@shannonmfisher](https://github.com/shannonmfisher), [@ankitguptaindia](https://github.com/ankitguptaindia), [@faisal-alvi](https://github.com/faisal-alvi) via [#172](https://github.com/10up/simple-page-ordering/pull/172)).
- Support for the WordPress.org plugin preview (props [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#183](https://github.com/10up/simple-page-ordering/pull/183)).

### Changed
- Replaced custom HTML entity decoding code in favor of the `@wordpress/html-entities` package (props [@helen](https://github.com/helen), [@jeffpaul](https://github.com/jeffpaul), [@psorensen](https://github.com/psorensen), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#189](https://github.com/10up/simple-page-ordering/pull/189)).
- Bump minimum `node` version from `16` to `20` and clean up NPM dependencies (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#188](https://github.com/10up/simple-page-ordering/pull/188)).
- Updated CODEOWNERS (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#186](https://github.com/10up/simple-page-ordering/pull/186)).
- Upgrade the download-artifact from v3 to v4 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#194](https://github.com/10up/simple-page-ordering/pull/194)).
- Replaced [lee-dohm/no-response](https://github.com/lee-dohm/no-response) with [actions/stale](https://github.com/actions/stale) to help with closing no-response/stale issues (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [@195](https://github.com/10up/simple-page-ordering/pull/195)).
- Disabled auto sync pull requests with target branch (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#196](https://github.com/10up/simple-page-ordering/pull/196)).

### Security
- Bump `@babel/traverse` from `7.20.12` to `7.23.6` (props [@dependabot](https://github.com/apps/dependabot), [@ravinderk](https://github.com/ravinderk) via [#184](https://github.com/10up/simple-page-ordering/pull/184)).
- Bump `sharp` from `0.30.7` to `0.32.1` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#182](https://github.com/10up/simple-page-ordering/pull/184)).
- Bump `10up-toolkit` from `4.3.1` to `5.2.2` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#182](https://github.com/10up/simple-page-ordering/pull/182)).

## [2.6.3] - 2023-11-09
### Fixed
- Deployment issue with version 2.6.2 (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#181](https://github.com/10up/simple-page-ordering/pull/181))

## [2.6.2] - 2023-11-09
### Changed
- Update the `wp-compat-validation-tool` composer package to version `0.3.1` which properly removes the `.git` directory (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#180](https://github.com/10up/simple-page-ordering/pull/180)).

## [2.6.1] - 2023-11-08
### Changed
- Bump WordPress "tested up to" version 6.4 (props [@jeffpaul](https://github.com/jeffpaul), [@qasumitbagthariya](https://github.com/qasumitbagthariya), [@faisal-alvi](https://github.com/faisal-alvi) via [#177](https://github.com/10up/simple-page-ordering/pull/177)).
- Remove the .git directory from the `10up-lib` directory (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#175](https://github.com/10up/simple-page-ordering/pull/175)).

### Security
- Bumps `@babel/traverse` from `7.20.12` to `7.23.2` (props [@peterwilsoncc](https://github.com/peterwilsoncc) via [#170](https://github.com/10up/simple-page-ordering/pull/170)).

## [2.6.0] - 2023-10-25
### Added
- A check for minimum required PHP version before loading the plugin (props [@vikrampm1](https://github.com/vikrampm1), [@kmgalanakis](https://github.com/kmgalanakis), [@Sidsector9](https://github.com/Sidsector9) via [#153](https://github.com/10up/simple-page-ordering/pull/153)).
- Mochawesome reporter added for Cypress test report (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#146](https://github.com/10up/simple-page-ordering/pull/146)).
- Repo Automator GitHub Action (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#158](https://github.com/10up/simple-page-ordering/pull/158)).

### Changed
- Bump WordPress "tested up to" version 6.3 (props [@jeffpaul](https://github.com/jeffpaul), [@QAharshalkadu](https://github.com/QAharshalkadu) via [#156](https://github.com/10up/simple-page-ordering/pull/156)).
- Slightly change how some of our text is translated, passing in the post type (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
- Updates the Dependency Review GitHub Action to check for GPL-compatible licenses (props [@jeffpaul](https://github.com/jeffpaul), [@Sidsector9](https://github.com/Sidsector9) via [#147](https://github.com/10up/simple-page-ordering/pull/147)).
- Updated 10up Cypress Utilities to 0.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#160](https://github.com/10up/simple-page-ordering/pull/160)).

### Fixed
- The "Are you sure..." popup text to be translatable (props [@kebbet](https://github.com/kebbet), [@bmarshall511](https://github.com/bmarshall511), [@dkotter](https://github.com/dkotter) via [#148](https://github.com/10up/simple-page-ordering/pull/148)).
- Remove code that was no longer needed (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
- Add missing escaping (props [@dkotter](https://github.com/dkotter), [@ravinderk](https://github.com/ravinderk) via [#149](https://github.com/10up/simple-page-ordering/pull/149)).
- Fatal error following the introduction of a namespace (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@iamdharmesh](https://github.com/iamdharmesh), [@dkotter](https://github.com/dkotter) via [#162](https://github.com/10up/simple-page-ordering/pull/162)).
- Hidden pagination in admin screen when Sort by Order is clicked (props [@tlovett1](https://github.com/tlovett1), [@dkotter](https://github.com/dkotter), [@Sidsector9](https://github.com/Sidsector9) via [#165](https://github.com/10up/simple-page-ordering/pull/165)).
- Fatal errors on PHP 5.6 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@Sidsector9](https://github.com/Sidsector9), [@iamdharmesh](https://github.com/iamdharmesh) via [#166](https://github.com/10up/simple-page-ordering/pull/166)).

### Security
- Bump `word-wrap` from 1.2.3 to 1.2.4 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#](https://github.com/10up/simple-page-ordering/pull/151)).
- Bump `tough-cookie` from 4.1.2 to 4.1.3 (props [@faisal-alvi](https://github.com/faisal-alvi) via [#152](https://github.com/10up/simple-page-ordering/pull/152)).
- Bump `node-sass` from 7.0.3 to 9.0.0 (props [@faisal-alvi](https://github.com/faisal-alvi) via [#152](https://github.com/10up/simple-page-ordering/pull/152)).
- Bump `@cypress/request` from 2.88.11 to 3.0.0 to resolve SSRF issue (props [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh), [@peterwilsoncc](https://github.com/peterwilsoncc), [@dkotter](https://github.com/dkotter) via [#152](https://github.com/10up/simple-page-ordering/pull/152), [#160](https://github.com/10up/simple-page-ordering/pull/160)).

## [2.5.1] - 2023-05-16
### Security
- Ensure we check user permissions properly in our REST endpoint (props [@mikhail-net](https://github.com/mikhail-net), [@dkotter](https://github.com/dkotter), [@peterwilsoncc](https://github.com/peterwilsoncc)).

## [2.5.0] - 2023-04-18
**Note that this release bumps the minimum required versions of PHP from 5.6 to 7.4 and WordPress from 3.8 to 5.7.**

### Added
- Feature to reset page order (props [@pattonwebz](https://github.com/pattonwebz), [@ruscoe](https://github.com/ruscoe), [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter)) via [#129](https://github.com/10up/simple-page-ordering/pull/129).
- JS linting GitHub Action (props [@Sidsector9](https://github.com/Sidsector9), [@kmgalanakis](https://github.com/kmgalanakis), [@peterwilsoncc](https://github.com/peterwilsoncc)) via [#136](https://github.com/10up/simple-page-ordering/pull/136).

### Changed
- Bump minimum PHP version to 7.4 (props [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9), [@ravinderk](https://github.com/ravinderk), [@cadic](https://github.com/cadic)) via [#111](https://github.com/10up/simple-page-ordering/pull/111).
- Bump minimum required WordPress version from 3.8 to 5.7 (props [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9), [@ravinderk](https://github.com/ravinderk), [@cadic](https://github.com/cadic)) via [#111](https://github.com/10up/simple-page-ordering/pull/111).
- Bump WordPress "tested up to" version 6.2 (props [@av3nger](https://github.com/av3nger) via [#138](https://github.com/10up/simple-page-ordering/pull/138)).
- Run E2E tests on the zip generated by "Build release zip" action (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@dkotter](https://github.com/dkotter)) via [#135](https://github.com/10up/simple-page-ordering/pull/135).

### Fixed
- Removed a typo in a REST response message (props [@ruscoe](https://github.com/ruscoe), [@Sidsector9](https://github.com/Sidsector9)) via [#133](https://github.com/10up/simple-page-ordering/pull/133).

### Security
- Removed vulnerable NPM dependencies (props [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9), [@ravinderk](https://github.com/ravinderk), [@cadic](https://github.com/cadic)) via [#111](https://github.com/10up/simple-page-ordering/pull/111).
- Bump `cypress` from `9.5.2` to `11.2.0` (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@Sidsector9](https://github.com/Sidsector9)) via [#120](https://github.com/10up/simple-page-ordering/pull/120).
- Bump `http-cache-semantics` from 4.1.0 to 4.1.1 (props [@peterwilsoncc](https://github.com/peterwilsoncc) via [#131](https://github.com/10up/simple-page-ordering/pull/131)).
- Bump `webpack` from `5.75.0` to `5.76.1` (props [@Sidsector9](https://github.com/Sidsector9)) via [#134](https://github.com/10up/simple-page-ordering/pull/134).

## [2.4.4] - 2023-01-10
### Changed
- Update Support Level from `Active` to `Stable` (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#123](https://github.com/10up/simple-page-ordering/pull/123)).
- Bump WordPress "tested up to" version to 6.1 (props [@jayedul](https://github.com/jayedul), [@dkotter](https://github.com/dkotter) via [#118](https://github.com/10up/simple-page-ordering/pull/118)).
- Update the "Build release zip" workflow to use 10up's `build-zip` action (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter) via [#119](https://github.com/10up/simple-page-ordering/pull/119)).

### Security
- Bump `loader-utils` from 2.0.3 to 2.0.4 (props [@dependabot](https://github.com/apps/dependabot) via [#115](https://github.com/10up/simple-page-ordering/pull/115)).
- Bump `simple-git` from 3.12.0 to 3.15.1 (props [@dependabot](https://github.com/apps/dependabot) via [#121](https://github.com/10up/simple-page-ordering/pull/121)).

## [2.4.3] - 2022-11-08
### Changed
- Allow hierarchical post types that don't have `page-attributes` set to be sorted properly (props [@dkotter](https://github.com/dkotter), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#108](https://github.com/10up/simple-page-ordering/pull/108)).

### Security
- Bump `got` from 10.7.0 to 11.8.5 (props [@dependabot](https://github.com/apps/dependabot) via [#106](https://github.com/10up/simple-page-ordering/pull/106)).
- Bump `@wordpress/env` from 4.9.0 to 5.3.0 (props [@dependabot](https://github.com/apps/dependabot) via [#106](https://github.com/10up/simple-page-ordering/pull/106)).
- Bump `scss-tokenizer` from 0.3.0 to 0.4.3 (props [@dependabot](https://github.com/apps/dependabot) via [#107](https://github.com/10up/simple-page-ordering/pull/107)).
- Bump `node-sass` from 7.0.1 to 7.0.3 (props [@dependabot](https://github.com/apps/dependabot) via [#107](https://github.com/10up/simple-page-ordering/pull/107)).

## [2.4.2] - 2022-09-28
### Changed
- Replaced our Grunt build process with `10up-toolkit` (props [@cadic](https://github.com/cadic), [@peterwilsoncc](https://github.com/peterwilsoncc), [@dinhtungdu](https://github.com/dinhtungdu) via [#97](https://github.com/10up/simple-page-ordering/pull/97)).

### Fixed
- Disable reordering for CPTs that don't support `page-attributes` (props [@dhanendran](https://github.com/dhanendran), [@dinhtungdu](https://github.com/dinhtungdu), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#103](https://github.com/10up/simple-page-ordering/pull/103)).

## [2.4.1] - 2022-06-21
### Added
- Missing text domain to strings (props [@kebbet](https://github.com/kebbet), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#92](https://github.com/10up/simple-page-ordering/pull/92)).

### Fixed
- Condition in REST page sorting logic in `rest_page_ordering` method (props [@szepeviktor](https://github.com/szepeviktor), [@iamdharmesh](https://github.com/iamdharmesh) via [#94](https://github.com/10up/simple-page-ordering/pull/94)).
- PHP Coding standards (props [@szepeviktor](https://github.com/szepeviktor), [@dinhtungdu](https://github.com/dinhtungdu) via [#93](https://github.com/10up/simple-page-ordering/pull/93)).

### Changed
- Bump WordPress "tested up to" version to 6.0 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9), [@jeffpaul](https://github.com/jeffpaul) via [#95](https://github.com/10up/simple-page-ordering/pull/95), [#98](https://github.com/10up/simple-page-ordering/pull/98)).

### Security
- Bump `grunt` from 1.5.2 to 1.5.3 (props [@dependabot](https://github.com/apps/dependabot) via [#99](https://github.com/10up/simple-page-ordering/pull/99)).

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

[Unreleased]: https://github.com/10up/simple-page-ordering/compare/trunk...develop
[2.7.1]: https://github.com/10up/simple-page-ordering/compare/2.7.0...2.7.1
[2.7.0]: https://github.com/10up/simple-page-ordering/compare/2.6.3...2.7.0
[2.6.3]: https://github.com/10up/simple-page-ordering/compare/2.6.2...2.6.3
[2.6.2]: https://github.com/10up/simple-page-ordering/compare/2.6.1...2.6.2
[2.6.1]: https://github.com/10up/simple-page-ordering/compare/2.6.0...2.6.1
[2.6.0]: https://github.com/10up/simple-page-ordering/compare/2.5.1...2.6.0
[2.5.1]: https://github.com/10up/simple-page-ordering/compare/2.5.0...2.5.1
[2.5.0]: https://github.com/10up/simple-page-ordering/compare/2.4.4...2.5.0
[2.4.4]: https://github.com/10up/simple-page-ordering/compare/2.4.3...2.4.4
[2.4.3]: https://github.com/10up/simple-page-ordering/compare/2.4.2...2.4.3
[2.4.2]: https://github.com/10up/simple-page-ordering/compare/2.4.1...2.4.2
[2.4.1]: https://github.com/10up/simple-page-ordering/compare/2.4.0...2.4.1
[2.4.0]: https://github.com/10up/simple-page-ordering/compare/2.3.4...2.4.0
[2.3.4]: https://github.com/10up/simple-page-ordering/compare/2.3.3...2.3.4
[2.3.3]: https://github.com/10up/simple-page-ordering/compare/2.3.2...2.3.3
[2.3.2]: https://github.com/10up/simple-page-ordering/compare/2.3.1...2.3.2
[2.3.1]: https://github.com/10up/simple-page-ordering/compare/2.3...2.3.1
[2.3.0]: https://github.com/10up/simple-page-ordering/compare/2.2.4...2.3
[2.2.4]: https://github.com/10up/simple-page-ordering/releases/tag/2.2.4
