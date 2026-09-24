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

	it( 'Can preserve emojis in page titles during reordering', () => {
		const emojiTitle = 'Hey there! 👋';

		// Current WP replaces emoji with images when the browser does not support
		// the latest emoji set. The character then lives in the image alt text.
		const readRowTitle = ( titleLink ) => {
			const altText = Array.from( titleLink.querySelectorAll( 'img' ) )
				.map( ( img ) => img.getAttribute( 'alt' ) || '' )
				.join( '' );

			return `${ titleLink.textContent || '' }${ altText }`;
		};

		cy.get( '.row-title' ).should( ( $titles ) => {
			const found = [ ...$titles ].some(
				( el ) => readRowTitle( el ).includes( emojiTitle )
			);
			expect( found, 'emoji page title' ).to.equal( true );
		} ).then( ( $titles ) => {
			const match = [ ...$titles ].find(
				( el ) => readRowTitle( el ).includes( emojiTitle )
			);

			cy.wrap( readRowTitle( match ) ).as( 'initialEmojiTitle' );
			cy.wrap( Cypress.$( match ).parents( 'tr' ) ).as( 'emojiPageRow' );
		} );

		cy.intercept( 'POST', '**/admin-ajax.php', ( req ) => {
			let action = '';

			if ( 'string' === typeof req.body ) {
				action = new URLSearchParams( req.body ).get( 'action' ) || '';
			} else if ( req.body && req.body.action ) {
				action = req.body.action;
			}

			if ( 'simple_page_ordering' === action ) {
				req.alias = 'pageOrdering';
			}
		} );

		// Drag onto a different row. The emoji page is not always in the same position.
		cy.get( '@emojiPageRow' ).invoke( 'index' ).then( ( index ) => {
			const target = 0 === index ? secondTopLevelPage : firstTopLevelPage;
			cy.get( '@emojiPageRow' ).drag( target );
		} );

		cy.wait( '@pageOrdering' );

		cy.get( '@initialEmojiTitle' ).then( ( initialTitle ) => {
			cy.get( '.row-title' ).should( ( $titles ) => {
				const titles = [ ...$titles ].map( ( el ) => readRowTitle( el ) );
				expect( titles, 'row titles after reorder' ).to.include( initialTitle );
			} );
		} );
	} );

	// Reset page ordering state.
	after( () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		cy.get( firstTopLevelPage ).drag( secondTopLevelPage );
		cy.get( firstChildPage ).drag( secondChildPage );
	} );
});
