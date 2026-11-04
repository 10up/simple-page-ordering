describe( 'Test Abilities API', () => {
	const abilityRunUrl = '/wp-json/wp-abilities/v1/abilities/simple-page-ordering/reorder-post/run';

	/**
	 * Get the top level pages in menu order, using the REST API as the admin user.
	 *
	 * @param {string} nonce REST nonce.
	 */
	const getTopLevelPages = ( nonce ) =>
		cy
			.request( {
				url: '/wp-json/wp/v2/pages?parent=0&orderby=menu_order&order=asc&per_page=20',
				headers: { 'X-WP-Nonce': nonce },
			} )
			.then( ( response ) => response.body.map( ( page ) => page.id ) );

	beforeEach( () => {
		cy.login();
		cy.visit( '/wp-admin/edit.php?post_type=page' );
		cy.window().then( ( win ) => {
			cy.wrap( win.wpApiSettings.nonce ).as( 'nonce' );
		} );
	} );

	it( 'Is registered and discoverable', function () {
		cy.request( {
			url: '/wp-json/wp-abilities/v1/abilities/simple-page-ordering/reorder-post',
			headers: { 'X-WP-Nonce': this.nonce },
		} ).then( ( response ) => {
			expect( response.status ).to.eq( 200 );
			expect( response.body.category ).to.eq( 'simple-page-ordering' );
			expect( response.body.input_schema.required ).to.include( 'id' );
		} );
	} );

	it( 'Can reorder a page', function () {
		getTopLevelPages( this.nonce ).then( ( before ) => {
			const [ first, second ] = before;

			// Move the first page directly after the second page.
			cy.request( {
				method: 'POST',
				url: abilityRunUrl,
				headers: { 'X-WP-Nonce': this.nonce },
				body: { input: { id: first, previd: second } },
			} ).then( ( response ) => {
				expect( response.status ).to.eq( 200 );
				expect( response.body.success ).to.eq( true );
			} );

			getTopLevelPages( this.nonce ).then( ( after ) => {
				expect( after.indexOf( first ) ).to.be.greaterThan( after.indexOf( second ) );
			} );
		} );
	} );

	it( 'Rejects a request with no neighbors', function () {
		getTopLevelPages( this.nonce ).then( ( [ first ] ) => {
			cy.request( {
				method: 'POST',
				url: abilityRunUrl,
				headers: { 'X-WP-Nonce': this.nonce },
				body: { input: { id: first } },
				failOnStatusCode: false,
			} ).then( ( response ) => {
				expect( response.status ).to.eq( 400 );
			} );
		} );
	} );

	it( 'Rejects requests from logged out users', () => {
		cy.request( {
			method: 'POST',
			url: abilityRunUrl,
			body: { input: { id: 1, previd: 2 } },
			failOnStatusCode: false,
		} ).then( ( response ) => {
			expect( response.status ).to.be.oneOf( [ 401, 403 ] );
		} );
	} );
} );
