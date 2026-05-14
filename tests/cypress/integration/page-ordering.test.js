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

	it('Can preserve emojis in page titles during reordering', () => {
		// Find the emoji page that was created during setup
		cy.contains('.row-title', 'Hey there! 👋').should('exist').as('emojiPage');
		
		// Get the parent row of our emoji page
		cy.get('@emojiPage').parents('tr').as('emojiPageRow');
		
		// Store the initial emoji title text
		cy.get('@emojiPage').invoke('text').as('initialEmojiTitle');
		
		// Get the ID of the emoji page row for debugging
		cy.get('@emojiPageRow').invoke('attr', 'id').then(rowId => {
			cy.log('Emoji page row ID:', rowId);
		});
		
		// Perform the drag operation to trigger the callback
		cy.get('@emojiPageRow').drag(secondTopLevelPage);
		
		// Wait for the ordering update to complete with a timeout
		cy.get('.wp-list-table tbody tr .check-column input', { timeout: 10000 }).should('exist');
		
		// Add a small wait to ensure the callback has completed
		cy.wait(1000);
		
		// Verify the emoji is still present and unchanged in the title
		cy.get('@initialEmojiTitle').then(initialTitle => {
			cy.log('Initial title was:', initialTitle);
			cy.contains('.row-title', 'Hey there! 👋')
				.should('exist')
				.should('have.text', initialTitle);
		});
	});

	// Reset page ordering state.
	after( () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		cy.get( firstTopLevelPage ).drag( secondTopLevelPage );
		cy.get( firstChildPage ).drag( secondChildPage );
	} );
});
