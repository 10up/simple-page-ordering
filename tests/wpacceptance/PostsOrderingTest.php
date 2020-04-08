<?php
/**
 * Test if we can order posts.
 *
 * @package wpacceptance
 */

/**
 * PHPUnit test class
 */
class PostsOrderingTest extends \TestCaseBase {

	/**
	 * @testdox Changing posts order works as expected.
	 */
	public function testChangingPostsOrder() {
		$actor = $this->openBrowserPage();
		$actor->loginAs( 'admin' );

		// Activate the helper plugin.
		$actor->moveTo( '/wp-admin/plugins.php' );
		try {
			$element = $actor->getElement( '[data-slug="enable-ordering-for-posts"] .deactivate a' );
			if ( $element ) {
				$actor->click( $element );
				$actor->waitUntilElementVisible( '#message' );
			}
		} catch ( \Exception $e ) {}
		$actor->click( '[data-slug="enable-ordering-for-posts"] .activate a' );
		$actor->waitUntilElementVisible( '#message' );

		$actor->moveTo( 'wp-admin/edit.php?orderby=menu_order+title&order=asc' );

		$first = $actor->getElementInnerText( '.wp-list-table tbody tr:nth-child(2) .row-title' );
		$second = $actor->getElementInnerText( '.wp-list-table tbody tr:nth-child(3) .row-title' );

		$actor->executeJavaScript( 'jQuery(".wp-list-table tbody").sortable("option","update")(null, { item: jQuery(".wp-list-table tbody tr:eq(1)").before(jQuery(".wp-list-table tbody tr:eq(2)")) });' );
		$actor->waitUntilElementVisible( '.wp-list-table tbody tr:nth-child(3) .check-column input' );

		$actor->seeText( $first, '.wp-list-table tbody tr:nth-child(3) .row-title' );
		$actor->seeText( $second, '.wp-list-table tbody tr:nth-child(2) .row-title' );
	}

}

