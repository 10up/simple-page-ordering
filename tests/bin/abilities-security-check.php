<?php
// Temporary test script. Creates its own pages and users, then deletes them.
$results = array();
$check   = function ( $name, $pass, $detail = '' ) use ( &$results ) {
	$results[] = array( $name, $pass ? 'PASS' : 'FAIL', $detail );
};

// 1. Registration.
do_action( 'init' );
$ability = wp_get_ability( 'simple-page-ordering/reorder-post' );
$check( 'Ability registered', (bool) $ability );
$check( 'Category registered', (bool) wp_get_ability_category( 'simple-page-ordering' ) );
$check( 'Exposed to REST', $ability && ! empty( $ability->get_meta()['show_in_rest'] ) );

// 2. Fixtures.
$suffix = wp_generate_password( 4, false );
$users  = array();
foreach ( array( 'subscriber', 'contributor', 'author', 'editor' ) as $role ) {
	$users[ $role ] = wp_insert_user(
		array(
			'user_login' => "spo_test_{$role}_{$suffix}",
			'user_pass'  => wp_generate_password( 24 ),
			'user_email' => "spo_{$role}_{$suffix}@example.test",
			'role'       => $role,
		)
	);
}
$pages = array();
foreach ( array( 10, 20, 30 ) as $i => $order ) {
	$pages[ $i ] = wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => "SPO test page {$suffix} " . ( $i + 1 ),
			'menu_order'  => $order,
		)
	);
}
$post_id = wp_insert_post(
	array(
		'post_type'   => 'post',
		'post_status' => 'publish',
		'post_title'  => "SPO test post {$suffix}",
	)
);
$order_of = function () use ( $pages ) {
	$out = array();
	foreach ( $pages as $p ) {
		$out[] = (int) get_post_field( 'menu_order', $p, 'raw' );
	}
	return $out;
};

$run = function ( $uid, $input ) use ( $ability ) {
	wp_set_current_user( $uid );
	return $ability->execute( $input );
};

// 3. Permissions.
$before = $order_of();
foreach ( array( 'subscriber', 'contributor', 'author' ) as $role ) {
	$res = $run( $users[ $role ], array( 'id' => $pages[0], 'previd' => $pages[1] ) );
	$denied = is_wp_error( $res ) || false === $res;
	$check( "Role {$role} is denied", $denied, is_wp_error( $res ) ? $res->get_error_code() : '' );
}
$check( 'Denied roles changed nothing', $order_of() === $before, wp_json_encode( $order_of() ) );

$res = $run( 0, array( 'id' => $pages[0], 'previd' => $pages[1] ) );
$check( 'Logged-out user is denied', is_wp_error( $res ) || false === $res, is_wp_error( $res ) ? $res->get_error_code() : '' );

// 4. Editor can reorder.
$res = $run( $users['editor'], array( 'id' => $pages[0], 'previd' => $pages[1] ) );
$ok  = is_array( $res ) && ! empty( $res['success'] );
$check( 'Editor can move page 1 after page 2', $ok, is_wp_error( $res ) ? $res->get_error_message() : '' );
$after = $order_of();
$check( 'Page 1 now sorts after page 2', $after[0] > $after[1], wp_json_encode( $after ) );

// 5. Bad input.
$res = $run( $users['editor'], array( 'id' => $pages[0] ) );
$check( 'No neighbors is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'previd' => $pages[1] ) );
$check( 'Missing id is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'id' => 'abc', 'previd' => $pages[1] ) );
$check( 'Non-integer id is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'id' => -5, 'previd' => $pages[1] ) );
$check( 'Negative id is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'id' => 99999999, 'previd' => $pages[1] ) );
$check( 'Nonexistent id is rejected', is_wp_error( $res ) || false === $res, is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'id' => $pages[0], 'previd' => $pages[1], 'evil' => 'x' ) );
$check( 'Unknown property is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$res = $run( $users['editor'], array( 'id' => $pages[0], 'previd' => "1 OR 1=1" ) );
$check( 'SQL-looking string is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );

// 6. Non-sortable post type (posts are not sortable by default).
$res = $run( $users['editor'], array( 'id' => $post_id, 'previd' => $pages[1] ) );
$check( 'Non-sortable post type is rejected', is_wp_error( $res ) || false === $res, is_wp_error( $res ) ? $res->get_error_code() : 'no error' );

// 6b. Neighbors must be real posts of the same type as the moved post.
$q = wp_insert_post(
	array(
		'post_type'   => 'page',
		'post_status' => 'publish',
		'post_title'  => "SPO test parent {$suffix}",
	)
);
$x = wp_insert_post(
	array(
		'post_type'   => 'page',
		'post_status' => 'publish',
		'post_title'  => "SPO test child {$suffix}",
		'post_parent' => $q,
	)
);

// A regular post has parent 0, so using it as a neighbor would move the child to the top level.
$res = $run( $users['editor'], array( 'id' => $x, 'nextid' => $post_id ) );
$check( 'Neighbor of another post type is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );
$check( 'Rejected neighbor left the parent unchanged', (int) get_post_field( 'post_parent', $x, 'raw' ) === $q, 'parent ' . get_post_field( 'post_parent', $x, 'raw' ) );

$res = $run( $users['editor'], array( 'id' => $x, 'previd' => 99999999 ) );
$check( 'Nonexistent neighbor is rejected', is_wp_error( $res ), is_wp_error( $res ) ? $res->get_error_code() : 'no error' );

$res = $run( $users['editor'], array( 'id' => $pages[2], 'previd' => $pages[0] ) );
$check( 'Neighbor of the same post type is accepted', is_array( $res ) && ! empty( $res['success'] ), is_wp_error( $res ) ? $res->get_error_code() : '' );

// 7. REST route (ability endpoint) via internal dispatch.
wp_set_current_user( 0 );
$req = new WP_REST_Request( 'POST', '/wp-abilities/v1/abilities/simple-page-ordering/reorder-post/run' );
$req->set_header( 'Content-Type', 'application/json' );
$req->set_body( wp_json_encode( array( 'input' => array( 'id' => $pages[0], 'previd' => $pages[2] ) ) ) );
$resp = rest_do_request( $req );
$check( 'REST run endpoint blocks logged-out user', in_array( $resp->get_status(), array( 401, 403 ), true ), 'status ' . $resp->get_status() );

wp_set_current_user( $users['subscriber'] );
$resp = rest_do_request( $req );
$check( 'REST run endpoint blocks subscriber', in_array( $resp->get_status(), array( 401, 403 ), true ), 'status ' . $resp->get_status() );

wp_set_current_user( $users['editor'] );
$resp = rest_do_request( $req );
$check( 'REST run endpoint allows editor', 200 === $resp->get_status(), 'status ' . $resp->get_status() );

// 8. Existing REST route still behaves.
wp_set_current_user( $users['subscriber'] );
$old = new WP_REST_Request( 'POST', '/simple-page-ordering/v1/page_ordering' );
$old->set_param( 'id', $pages[0] );
$old->set_param( 'previd', $pages[1] );
$old->set_param( 'nextid', 0 );
$resp = rest_do_request( $old );
$check( 'Old REST route still blocks subscriber', in_array( $resp->get_status(), array( 401, 403 ), true ), 'status ' . $resp->get_status() );

// 9. Cleanup.
foreach ( $pages as $p ) {
	wp_delete_post( $p, true );
}
wp_delete_post( $post_id, true );
wp_delete_post( $x, true );
wp_delete_post( $q, true );
require_once ABSPATH . 'wp-admin/includes/user.php';
foreach ( $users as $uid ) {
	wp_delete_user( $uid );
}

foreach ( $results as $r ) {
	echo str_pad( $r[1], 5 ) . ' ' . $r[0] . ( $r[2] ? "  [{$r[2]}]" : '' ) . "\n";
}
