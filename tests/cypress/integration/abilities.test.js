const abilityUrl = '/wp-json/wp-abilities/v1/abilities/simple-page-ordering/reorder-post';

describe( 'Test Abilities API', () => {
	let nonce;
	let createdPageIds = [];

	/**
	 * Create a page through the REST API and remember it so it can be removed.
	 *
	 * @param {string} title     Page title.
	 * @param {number} menuOrder Starting menu order.
	 */
	const createPage = ( title, menuOrder ) =>
		cy
			.request( {
				method: 'POST',
				url: '/wp-json/wp/v2/pages',
				headers: { 'X-WP-Nonce': nonce },
				body: { title, status: 'publish', menu_order: menuOrder },
			} )
			.then( ( response ) => {
				createdPageIds.push( response.body.id );
				return response.body.id;
			} );

	const getMenuOrder = ( id ) =>
		cy
			.request( {
				url: `/wp-json/wp/v2/pages/${ id }?_fields=menu_order`,
				headers: { 'X-WP-Nonce': nonce },
			} )
			.then( ( response ) => response.body.menu_order );

	const runAbility = ( input, options = {} ) =>
		cy.request( {
			method: 'POST',
			url: `${ abilityUrl }/run`,
			headers: { 'X-WP-Nonce': nonce },
			body: { input },
			...options,
		} );

	beforeEach( () => {
		createdPageIds = [];
		cy.login();
		// The Pages screen does not load the REST API script, so ask for a nonce directly.
		cy.request( '/wp-admin/admin-ajax.php?action=rest-nonce' )
			.its( 'body' )
			.then( ( body ) => {
				nonce = body;
			} );
	} );

	// Remove the pages created by the test so other specs see the original content.
	afterEach( () => {
		createdPageIds.forEach( ( id ) => {
			cy.request( {
				method: 'DELETE',
				url: `/wp-json/wp/v2/pages/${ id }?force=true`,
				headers: { 'X-WP-Nonce': nonce },
			} );
		} );
	} );

	it( 'Is registered and discoverable', () => {
		cy.request( {
			url: abilityUrl,
			headers: { 'X-WP-Nonce': nonce },
		} ).then( ( response ) => {
			expect( response.status ).to.eq( 200 );
			expect( response.body.category ).to.eq( 'simple-page-ordering' );
			expect( response.body.input_schema.required ).to.include( 'id' );
		} );
	} );

	it( 'Can reorder a page', () => {
		createPage( 'Ability test A', 10 ).then( ( first ) => {
			createPage( 'Ability test B', 20 ).then( ( second ) => {
				// Move the first page directly after the second page.
				runAbility( { id: first, previd: second } ).then( ( response ) => {
					expect( response.status ).to.eq( 200 );
					expect( response.body.success ).to.eq( true );
				} );

				getMenuOrder( first ).then( ( firstOrder ) => {
					getMenuOrder( second ).then( ( secondOrder ) => {
						expect( firstOrder ).to.be.greaterThan( secondOrder );
					} );
				} );
			} );
		} );
	} );

	it( 'Rejects a request with no neighbors', () => {
		createPage( 'Ability test C', 10 ).then( ( id ) => {
			runAbility( { id }, { failOnStatusCode: false } ).then( ( response ) => {
				expect( response.status ).to.eq( 400 );
			} );
		} );
	} );

	it( 'Rejects a neighbor that does not exist', () => {
		createPage( 'Ability test D', 10 ).then( ( id ) => {
			runAbility( { id, previd: 99999999 }, { failOnStatusCode: false } ).then(
				( response ) => {
					expect( response.status ).to.eq( 400 );
					expect( response.body.code ).to.eq( 'invalid_neighbor' );
				}
			);
		} );
	} );
} );

// Cypress clears cookies before every test, and this block never logs in.
describe( 'Test Abilities API as a logged out visitor', () => {
	it( 'Cannot run the ability', () => {
		cy.request( {
			method: 'POST',
			url: `${ abilityUrl }/run`,
			body: { input: { id: 1, previd: 2 } },
			failOnStatusCode: false,
		} ).then( ( response ) => {
			expect( response.status ).to.be.oneOf( [ 401, 403 ] );
		} );
	} );
} );
