describe("Admin can login and make sure plugin is activated", () => {
	it("Can activate plugin if it is deactivated", () => {
		cy.login();
		cy.visit("/wp-admin/plugins.php");

		cy.get('#the-list tr[data-slug="simple-page-ordering"] .deactivate > a').click();
		cy.get('#the-list tr[data-slug="simple-page-ordering"] .activate > a').click();
		cy.get('#the-list tr[data-slug="simple-page-ordering"] .deactivate > a').should('have.text', 'Deactivate');
	});

	it('Can see "Sort by Order" on Pages list page.', () => {
		cy.login();
		cy.visit("/wp-admin/edit.php?post_type=page");
		cy.get('.subsubsub .byorder').should('have.text', 'Sort by Order');
	});
});
