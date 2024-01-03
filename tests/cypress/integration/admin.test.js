describe('Admin can login and make sure plugin is activated', () => {
	it('Can activate plugin if it is deactivated', () => {
		cy.login();
		cy.visit('/wp-admin/plugins.php');

		cy.get('body')
			.then(($body) => {
				if ($body.find('#the-list tr[data-slug="simple-page-ordering"] .deactivate > a').length > 0) {
					cy.get('#the-list tr[data-slug="simple-page-ordering"] .deactivate > a').click();
					cy.get('#the-list tr[data-slug="simple-page-ordering"] .activate > a').click();
					cy.get('#the-list tr[data-slug="simple-page-ordering"] .deactivate > a').should('have.text', 'Deactivate');
				} else {
					cy.get('#the-list tr#simple-page-ordering .deactivate > a').click();
					cy.get('#the-list tr#simple-page-ordering .activate > a').click();
					cy.get('#the-list tr#simple-page-ordering .deactivate > a').should('have.text', 'Deactivate');
				}
			});
	});

	it('Can see "Sort by Order" on Pages list page.', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');
		cy.get('.subsubsub .byorder').should('have.text', 'Sort by Order');
	});

	it('Pagination is visible when Clicking "Sort by Order"', () => {
		cy.login();
		cy.visit( '/wp-admin/edit.php?post_type=page' );
		cy.get( '#show-settings-link' ).click();
		cy.get( '#edit_page_per_page' ).type( '{selectAll}{del}2' );
		cy.get( '#screen-options-apply' ).click();
		cy.get( '.byorder' ).click();
		cy.get( '.pagination-links' ).should( 'be.visible' );

		// Restore default pagination.
		cy.get( '#show-settings-link' ).click();
		cy.get( '#edit_page_per_page' ).type( '{selectAll}{del}60' );
		cy.get( '#screen-options-apply' ).click();
	});
});
