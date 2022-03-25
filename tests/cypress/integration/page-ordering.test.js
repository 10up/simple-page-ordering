describe( 'Page ordering', () => {
	before( () => {
		cy.login( 'admin', 'password' );
	} );

	it( 'Pages can be reordered', async () => {
		cy.visit( `${ Cypress.config().baseUrl }wp-admin/edit.php?post_type=page` );

		cy
			.get( '.wp-list-table tbody tr:nth-child(1) .row-title' )
			.then( $anchor => {
				const pageTitle = $anchor.text();
				cy.wrap( pageTitle ).as( 'firstPageTitle' );
			} );


		cy
			.get( '.wp-list-table tbody tr:nth-child(2) .row-title' )
			.then( $anchor => {
				const pageTitle = $anchor.text();
				cy.wrap( pageTitle ).as( 'secondPageTitle' );
			} );


		cy.window().then( win => {
			const { jQuery } = win;

			jQuery( '.wp-list-table tbody' ).sortable( 'option', 'update' )( null, {
				item: jQuery( '.wp-list-table tbody tr:eq(0)' ).before(
					jQuery( '.wp-list-table tbody tr:eq(1)' )
				)
			} );

			cy
				.get( '.wp-list-table tbody tr:nth-child(2) .row-title' )
				.then( $anchor => {
					cy.get( '@firstPageTitle' ).then( pageTitle => {
						expect( $anchor.text() ).equals( pageTitle )
					} );
				} );

			cy
				.get( '.wp-list-table tbody tr:nth-child(1) .row-title' )
				.then( $anchor => {
					cy.get( '@secondPageTitle' ).then( pageTitle => {
						expect( $anchor.text() ).equals( pageTitle )
					} );
				} );
		} );
	} );
} );