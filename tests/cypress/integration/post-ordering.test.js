describe('Test Post Order Change', () => {
	const firstPost = '.wp-list-table tbody tr:nth-child(1)';
	const secondPost = '.wp-list-table tbody tr:nth-child(2)';

	beforeEach(() => {
		cy.login();
		cy.visit('/wp-admin/edit.php?orderby=menu_order+title&order=asc');

		cy.get(`${firstPost} .row-title`).invoke('text').as('initialFirstPostTitle', { type: 'static' } );
		cy.get(`${secondPost} .row-title`).invoke('text').as('initialSecondPostTitle', { type: 'static' } );
	});

	it('Can change posts order', () => {
		cy.get(firstPost).drag(secondPost);
		// wait for order update done.
		cy.get(`${secondPost}  .check-column input`).should('exist');

		cy.get( '@initialSecondPostTitle' ).then( initialSecondPostTitle => {
			// Now that it has been reordered, the first row should have the initial second text.
			cy.get( `${firstPost} .row-title` ).should('have.text', `${initialSecondPostTitle}` );
		} );

		cy.get( '@initialFirstPostTitle' ).then( initialFirstPostTitle => {
			// Now that it has been reordered, the second row should have the initial first text.
			cy.get( `${secondPost} .row-title` ).should('have.text', `${initialFirstPostTitle}` );
		} );
	});
});
