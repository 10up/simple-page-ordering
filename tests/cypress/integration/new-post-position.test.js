describe( 'New item position', () => {
	// Pages created during this run, removed again in after() so other specs
	// keep the seeded page list they expect.
	const createdPageIds = [];

	// The seeded top level pages all have a menu order, so the first and last
	// rows of the ordered list are a stable way to spot where a new page landed.
	const firstTopLevelPageId = () =>
		cy.wpCli(
			'wp post list --post_type=page --post_status=publish --post_parent=0 --orderby=menu_order --order=asc --field=ID --posts_per_page=1'
		);

	const lastTopLevelPageId = () =>
		cy.wpCli(
			'wp post list --post_type=page --post_status=publish --post_parent=0 --orderby=menu_order --order=desc --field=ID --posts_per_page=1'
		);

	const createPage = ( title ) =>
		cy
			.wpCli( `wp post create --post_type=page --post_status=publish --post_title=${ title } --porcelain` )
			.then( ( response ) => {
				const id = parseInt( response.stdout, 10 );
				createdPageIds.push( id );

				return id;
			} );

	after( () => {
		cy.wpCli( 'wp option delete spo_test_new_post_position', true );

		createdPageIds.forEach( ( id ) => {
			cy.wpCli( `wp post delete ${ id } --force`, true );
		} );
	} );

	it( 'Places a new page before its siblings when the filter returns top', () => {
		cy.wpCli( 'wp option update spo_test_new_post_position top' );

		createPage( 'new-page-at-top' ).then( ( id ) => {
			firstTopLevelPageId().its( 'stdout' ).then( ( firstId ) => {
				expect( parseInt( firstId, 10 ) ).to.equal( id );
			} );
		} );
	} );

	it( 'Places a new page after its siblings when the filter returns bottom', () => {
		cy.wpCli( 'wp option update spo_test_new_post_position bottom' );

		createPage( 'new-page-at-bottom' ).then( ( id ) => {
			lastTopLevelPageId().its( 'stdout' ).then( ( lastId ) => {
				expect( parseInt( lastId, 10 ) ).to.equal( id );
			} );
		} );
	} );

	it( 'Keeps the default menu order when the filter is not used', () => {
		cy.wpCli( 'wp option delete spo_test_new_post_position', true );

		createPage( 'new-page-default' ).then( ( id ) => {
			cy.wpCli( `wp post get ${ id } --field=menu_order` ).its( 'stdout' ).then( ( menuOrder ) => {
				expect( parseInt( menuOrder, 10 ) ).to.equal( 0 );
			} );
		} );
	} );
} );
