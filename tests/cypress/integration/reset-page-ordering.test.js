describe( 'Test Reset Page Order Change', () => {
	it( 'Can reset pages order', () => {
		cy.login();
		cy.visit('/wp-admin/edit.php?post_type=page');

		const firstRow = '.wp-list-table tbody tr:nth-child(1)';
		const secondRow = '.wp-list-table tbody tr:nth-child(2)';

		// Alias titles as `firstRowText` and `secondRowText` for convenience.
		cy.get( firstRow ).find( '.row-title' ).invoke( 'text' ).as( 'firstRowText' );
		cy.get( secondRow ).find( '.row-title' ).invoke( 'text' ).as( 'secondRowText' );

		// Swap position of `Page 1` with `Page 2`.
		cy.get( firstRow ).drag( secondRow );

		// Verifies if 1st row has title `Page 2`.
		cy.get( firstRow ).find( '.row-title' ).invoke( 'text' ).then( function( text ) {
			expect( text ).to.eq( this.secondRowText );
		} );

		// Verifies if 2nd row has title `Page 1`.
		cy.get( secondRow ).find( '.row-title' ).invoke( 'text' ).then( function( text ) {
			expect( text ).to.eq( this.firstRowText );
		} );

		// Now reset the page order and verify original values are back.
		cy.get( '#contextual-help-link' ).click();
		cy.get( '#tab-link-simple_page_ordering_help_tab' ).click();
		cy.get( '#simple-page-ordering-reset' ).click();
		cy.on( 'window:confirm', () => true );

		// Perform a reload as Cypress won't after window:confirm.
		cy.reload();

		// Verifies if 1st row has title `Page 1`.
		cy.get( firstRow ).find( '.row-title' ).invoke( 'text' ).then( function( text ) {
			expect( text ).to.eq( this.firstRowText );
		} );

		// Verifies if 2nd row has title `Page 2`.
		cy.get( secondRow ).find( '.row-title' ).invoke( 'text' ).then( function( text ) {
			expect( text ).to.eq( this.secondRowText );
		} );
	} );
} );
