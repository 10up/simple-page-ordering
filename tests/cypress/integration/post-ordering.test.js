describe('Test Post Order Change', () => {
	it('Can change posts order', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?orderby=menu_order+title&order=asc');

		const first = '.wp-list-table tbody tr:nth-child(1)';
		const second = '.wp-list-table tbody tr:nth-child(2)';
		const firstText = cy.get(`${first} .row-title`).invoke('text');
		const secondText = cy.get(`${second} .row-title`).invoke('text');

		cy.get(first).drag(second);
		// wait for order update done.
		cy.get(`${second}  .check-column input`).should('exist');

	  	cy.get(`${first} .row-title`).then($el => {
			secondText.should('have.text', $el.text());
		});
		cy.get(`${second} .row-title`).then($el => {
			firstText.should('have.text', $el.text());
		});
	});
});
  