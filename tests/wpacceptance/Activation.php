<?php
/**
 * The plugin activates correctly.
 *
 * @package wpacceptance
 */

/**
 * PHPUnit test class
 */
class ActivationTest extends \TestCaseBase {

	/**
	 * @testdox Plugin successfully activates.
	 */
	public function testActivation() {
		$actor = $this->openBrowserPage();
		$actor->loginAs( 'admin' );

		// Activate the plugin.
		$this->activatePlugin( $actor );

		$actor->seeText( 'Plugin activated.', '#message' );
	}

	/**
	 * @testdox Plugin is enabled for page.
	 */
	public function testPluworksginEnabledForPage() {
		$actor = $this->openBrowserPage();
		$actor->loginAs( 'admin' );
		$actor->moveTo( 'wp-admin/edit.php?post_type=page' );
		$actor->seeText( 'Sort by Order', '.subsubsub .byorder' );
	}
}
