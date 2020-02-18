<?php
/**
 * Test if the plugin works without issue.
 *
 * @package wpacceptance
 */

/**
 * PHPUnit test class
 */
class Ordering extends \TestCaseBase {

	/**
	 * @testdox Changing parent pages order works as expected.
	 */
	public function testChangingParentPageOrder() {
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
}

