<?php
/**
 * Manual test: lets an AI model reorder pages through the Abilities API.
 *
 * Uses the AI provider configured on Settings > Connectors. It sends a real
 * request to that provider, which uses a small amount of API credit.
 *
 * Run with: wp eval-file tests/bin/abilities-ai-check.php <user-login>
 * Use an Editor to test the normal case, or a Subscriber to see it denied.
 *
 * The script creates three temporary pages and deletes them at the end.
 */

use WordPress\AiClient\Messages\DTO\UserMessage;
use WordPress\AiClient\Messages\DTO\MessagePart;

$login = isset( $args[0] ) ? $args[0] : '';
$user  = $login ? get_user_by( 'login', $login ) : false;
if ( ! $user ) {
	WP_CLI::error( 'Pass the login of an existing user, for example: wp eval-file ... spo-editor' );
}
wp_set_current_user( $user->ID );
WP_CLI::log( "Running as: {$user->user_login} (" . implode( ',', $user->roles ) . ')' );

// Temporary pages in a known order: A=10, B=20, C=30.
$ids = array();
foreach ( array(
	'A' => 10,
	'B' => 20,
	'C' => 30,
) as $letter => $order ) {
	$ids[ $letter ] = wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => "AI Test Page {$letter}",
			'menu_order'  => $order,
		)
	);
}
$show_order = function () use ( $ids ) {
	$rows = array();
	foreach ( $ids as $letter => $id ) {
		$rows[ $letter ] = (int) get_post_field( 'menu_order', $id, 'raw' );
	}
	asort( $rows );
	return implode( ' < ', array_map( fn( $l, $o ) => "{$l}({$o})", array_keys( $rows ), $rows ) );
};
WP_CLI::log( 'Order before: ' . $show_order() );

$problem = '';

try {
	$ability  = 'simple-page-ordering/reorder-post';
	$resolver = new WP_AI_Client_Ability_Function_Resolver( $ability );
	$request  = sprintf(
		'Using the available function, move the page "AI Test Page C" so it comes directly before "AI Test Page A". Page IDs: A=%d, B=%d, C=%d. Then tell me in one sentence what happened.',
		$ids['A'],
		$ids['B'],
		$ids['C']
	);

	$history = array( new UserMessage( array( new MessagePart( $request ) ) ) );
	$final   = '';

	for ( $turn = 1; $turn <= 4; $turn++ ) {
		$builder = wp_ai_client_prompt()->using_abilities( $ability )->with_history( ...$history );

		if ( true !== $builder->is_supported_for_text_generation() ) {
			$problem = 'No AI provider is configured for text generation. Add an API key on Settings > Connectors first.';
			break;
		}

		$result = $builder->generate_result();
		if ( is_wp_error( $result ) ) {
			$problem = 'AI request failed: ' . $result->get_error_message();
			break;
		}

		$candidates = $result->getCandidates();
		$message    = $candidates[0]->getMessage();
		$history[]  = $message;

		if ( ! $resolver->has_ability_calls( $message ) ) {
			foreach ( $message->getParts() as $part ) {
				$final .= (string) $part->getText();
			}
			break;
		}

		foreach ( $message->getParts() as $part ) {
			$call = $part->getFunctionCall();
			if ( $call ) {
				WP_CLI::log( "Turn {$turn}: model called " . $call->getName() . ' with ' . wp_json_encode( $call->getArgs() ) );
			}
		}

		// Runs the ability. The ability's own permission check decides if it is allowed.
		$response  = $resolver->execute_abilities( $message );
		$history[] = $response;
		foreach ( $response->getParts() as $part ) {
			$fr = $part->getFunctionResponse();
			if ( $fr ) {
				WP_CLI::log( "Turn {$turn}: ability returned " . wp_json_encode( $fr->getResponse() ) );
			}
		}
	}

	WP_CLI::log( 'Model said: ' . ( $final ? $final : '(no final text)' ) );
	WP_CLI::log( 'Order after:  ' . $show_order() );

	// The request asked for page C to come before page A.
	$after_a = (int) get_post_field( 'menu_order', $ids['A'], 'raw' );
	$after_c = (int) get_post_field( 'menu_order', $ids['C'], 'raw' );
	if ( '' === $problem && $after_c >= $after_a ) {
		$problem = 'The AI did not move page C before page A. This is expected when you run as a user who is not allowed to reorder.';
	}
} finally {
	// Always remove the temporary pages, even when the AI request fails.
	foreach ( $ids as $id ) {
		wp_delete_post( $id, true );
	}
}

if ( '' !== $problem ) {
	WP_CLI::error( $problem . ' Temporary pages were deleted.' );
}
WP_CLI::success( 'The AI moved page C before page A. Temporary pages deleted.' );
