describe( 'Child page ordering', () => {
	before( () => {
		cy.login( 'admin', 'password' );
	} );

	it( 'Child pages can be reordered', async () => {
		cy.visit( `${ Cypress.config().baseUrl }wp-admin/edit.php?post_type=page` );

		cy
			.get( '.level-0 + .level-1 .row-title' )
			.then( $anchor => {
				const pageTitle = $anchor.text();
				cy.wrap( pageTitle ).as( 'firstChildPageTitle' );
			} );


		cy
			.get( '.level-0 + .level-1 + .level-1 .row-title' )
			.then( $anchor => {
				const pageTitle = $anchor.text();
				cy.wrap( pageTitle ).as( 'secondChildPageTitle' );
			} );


		cy.window().then( win => {
			const { jQuery } = win;

			jQuery( '.wp-list-table tbody' ).sortable( 'option", "update' ) ( null, {
				item: jQuery( '.level-0 + .level-1' )
					.first()
					.before(
						jQuery( '.level-0 + .level-1 + .level-1' ).first()
					)
			} );

			cy
				.get( '.level-0 + .level-1 .row-title' )
				.then( $anchor => {
					cy.get( '@firstChildPageTitle' ).then( pageTitle => {
						expect( $anchor.text() ).equals( pageTitle )
					} );
				} );

			cy
				.get( '.level-0 + .level-1 + .level-1 .row-title' )
				.then( $anchor => {
					cy.get( '@secondChildPageTitle' ).then( pageTitle => {
						expect( $anchor.text() ).equals( pageTitle )
					} );
				} );
		} );
	} );
} );