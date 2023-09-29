describe('Test Page Order Change', () => {
	const firstTopLevelPage = '.wp-list-table tbody tr:nth-child(1)';
	const secondTopLevelPage = '.wp-list-table tbody tr:nth-child(2)';
	const firstChildPage = '.wp-list-table .level-0 + .level-1';
	const secondChildPage = '.wp-list-table .level-0 + .level-1 + .level-1';

	beforeEach(() => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		cy.get(`${firstTopLevelPage} .row-title`).invoke('text').as('initialFirstTopLevelPageTitle', { type: 'static' } );
		cy.get(`${secondTopLevelPage} .row-title`).invoke('text').as('initialSecondTopLevelPageTitle', { type: 'static' } );

		cy.get(`${firstChildPage} .row-title`).invoke('text').as('initialFirstChildPageTitle', { type: 'static' } );
		cy.get(`${secondChildPage} .row-title`).invoke('text').as('initialSecondChildPageTitle', { type: 'static' } );
	});

	it('Can change parent pages order', () => {
		cy.get(firstTopLevelPage).drag(secondTopLevelPage);
		// wait for order update done.
		cy.get(`${secondTopLevelPage}  .check-column input`).should('exist');

		cy.get( '@initialSecondTopLevelPageTitle' ).then( initialSecondTopLevelPageTitle => {
			// Now that it has been reordered, the first row should have the initial second text.
			cy.get( `${firstTopLevelPage} .row-title` ).should('have.text', `${initialSecondTopLevelPageTitle}` );
		} );

		cy.get( '@initialFirstTopLevelPageTitle' ).then( initialFirstTopLevelPageTitle => {
			// Now that it has been reordered, the second row should have the initial first text.
			cy.get( `${secondTopLevelPage} .row-title` ).should('have.text', `${initialFirstTopLevelPageTitle}` );
		} );
	});

	it('Can change Child pages order', () => {
		cy.get(firstChildPage).drag(secondChildPage);
		// wait for order update done.
		cy.get(`${secondChildPage}  .check-column input`).should('exist');

		cy.get( '@initialSecondChildPageTitle' ).then( initialSecondChildPageTitle => {
			// Now that it has been reordered, the first row should have the initial second text.
			cy.get( `${firstChildPage} .row-title` ).should('have.text', `${initialSecondChildPageTitle}` );
		} );

		cy.get( '@initialFirstChildPageTitle' ).then( initialFirstChildPageTitle => {
			// Now that it has been reordered, the second row should have the initial first text.
			cy.get( `${secondChildPage} .row-title` ).should('have.text', `${initialFirstChildPageTitle}` );
		} );
	});

	// Reset page ordering state.
	after( () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		cy.get( firstTopLevelPage ).drag( secondTopLevelPage );
		cy.get( firstChildPage ).drag( secondChildPage );
	} );
});
