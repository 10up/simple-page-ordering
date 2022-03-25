describe( 'Post ordering', () => {
	before( () => {
		cy.login( 'admin', 'password' );
	} );

	it( 'Posts can be reordered', async () => {
		cy.visit( `${ Cypress.config().baseUrl }wp-admin/edit.php?orderby=menu_order+title&order=asc` );

		cy
			.get( '.wp-list-table tbody tr:nth-child(1) .row-title' )
			.then( $anchor => {
				const postTitle = $anchor.text();
				cy.wrap( postTitle ).as( 'firstPostTitle' );
			} );


		cy
			.get( '.wp-list-table tbody tr:nth-child(2) .row-title' )
			.then( $anchor => {
				const postTitle = $anchor.text();
				cy.wrap( postTitle ).as( 'secondPostTitle' );
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
					cy.get( '@firstPostTitle' ).then( postTitle => {
						expect( $anchor.text() ).equals( postTitle )
					} );
				} );

			cy
				.get( '.wp-list-table tbody tr:nth-child(1) .row-title' )
				.then( $anchor => {
					cy.get( '@secondPostTitle' ).then( postTitle => {
						expect( $anchor.text() ).equals( postTitle )
					} );
				} );
		} );
	} );
} );