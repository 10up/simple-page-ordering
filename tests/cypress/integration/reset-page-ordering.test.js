describe('Test Reset Page Order Change', () => {
	it('Can reset pages order', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		const first = '.wp-list-table tbody tr:nth-child(1)';
		const second = '.wp-list-table tbody tr:nth-child(2)';
		const firstText = cy.get(`${first} .row-title`);
		const secondText = cy.get(`${second} .row-title`);

		// first reorder the pages.
		cy.get(first).drag(second);
		// wait for order update done.
		cy.get(`${second}  .check-column input`).should('exist');

		cy.get(`${first} .row-title`).then($el => {
			secondText.should('have.text', $el.text());
		});
		cy.get(`${second} .row-title`).then($el => {
			firstText.should('have.text', $el.text());
		});

		// now reset the page order and verify original values are back.
		cy.get(`#contextual-help-link`).click();
		cy.get(`#tab-link-simple_page_ordering_help_tab`).click();
		cy.get(`#simple-page-ordering-reset`).click();
		cy.on(`window:confirm`, () => true);

		// wait for the page to reload before checking for reset post order.
		cy.wait(1000);

		// Re-query row elements that were detached from the DOM during the page reload.
		const newFirstText = cy.get(`${first} .row-title`);
		const newSecondText = cy.get(`${second} .row-title`);

		cy.get(`${first} .row-title`).then($el => {
			newFirstText.should('have.text', $el.text());
		});
		cy.get(`${second} .row-title`).then($el => {
			newSecondText.should('have.text', $el.text());
		});
	});
});
