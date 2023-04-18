describe('Test Page Order Change', () => {
	it('Can change parent pages order', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		const first = '.wp-list-table tbody tr:nth-child(1)';
		const second = '.wp-list-table tbody tr:nth-child(2)';
		const firstText = cy.get(`${first} .row-title`);
		const secondText = cy.get(`${second} .row-title`);

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

	it('Can change Child pages order', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');
	
		const first = '.wp-list-table .level-0 + .level-1';
		const second = '.wp-list-table .level-0 + .level-1 + .level-1';
		const firstText = cy.get(`${first} .row-title`);
		const secondText = cy.get(`${second} .row-title`);

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

	// Reset page ordering state.
	after( () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		const firstRow = '.wp-list-table tbody tr:nth-child(1)';
		const secondRow = '.wp-list-table tbody tr:nth-child(2)';

		cy.get( firstRow ).drag( secondRow );
	} );
});
