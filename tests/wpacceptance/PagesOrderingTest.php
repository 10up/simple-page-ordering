<?php
/**
 * Test if we can order pages
 *
 * @package wpacceptance
 */

/**
 * PHPUnit test class
 */
class PagesOrderingTest extends \TestCaseBase {

	/**
	 * @testdox Changing parent pages order works as expected.
	 */
	public function testChangingParentPagesOrder() {
		$actor = $this->openBrowserPage();
		$actor->loginAs( 'admin' );
		$actor->moveTo( 'wp-admin/edit.php?post_type=page' );

		$first = $actor->getElementInnerText( '.wp-list-table tbody tr:nth-child(1) .row-title' );
		$second = $actor->getElementInnerText( '.wp-list-table tbody tr:nth-child(2) .row-title' );

		$actor->executeJavaScript( 'jQuery(".wp-list-table tbody").sortable("option","update")(null, { item: jQuery(".wp-list-table tbody tr:eq(0)").before(jQuery(".wp-list-table tbody tr:eq(1)")) });' );
		$actor->waitUntilElementVisible( '.wp-list-table tbody tr:nth-child(2) .check-column input' );

		$actor->seeText( $first, '.wp-list-table tbody tr:nth-child(2) .row-title' );
		$actor->seeText( $second, '.wp-list-table tbody tr:nth-child(1) .row-title' );
	}

	/**
	 * @testdox Changing child pages order works as expected.
	 */
	public function testChangingChildPagesOrder() {
		$actor = $this->openBrowserPage();
		$actor->loginAs( 'admin' );
		$actor->moveTo( 'wp-admin/edit.php?post_type=page' );

		$first = $actor->getElementInnerText( '#post-2 + .level-1 .row-title' );
		$second = $actor->getElementInnerText( '#post-2 + .level-1 + .level-1 .row-title' );

		$actor->executeJavaScript( 'jQuery(".wp-list-table tbody").sortable("option","update")(null, { item: jQuery("#post-2 + .level-1").before(jQuery("#post-2 + .level-1 + .level-1")) });' );
		$actor->waitUntilElementVisible( '#post-2 + .level-1 + .level-1 .check-column input' );

		$actor->seeText( $second, '#post-2 + .level-1 .row-title' );
		$actor->seeText( $first, '#post-2 + .level-1 + .level-1 .row-title' );
	}
}

