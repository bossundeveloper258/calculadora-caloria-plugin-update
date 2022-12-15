<?php

require_once '_helpers.php';
global $wpdb;
global $db_prefix;
require_once __DIR__ . '/../_models/Testing.php';
$Testing = new Testing( $wpdb, $db_prefix );

add_action( 'rest_api_init', function () {
	global $api_prefix;
	// /wp-json/cs/v1/test_plans

	register_rest_route( $api_prefix, 'sandbox', [
		'methods'  => 'GET',
		'callback' => 'sandbox'
	] );
} );

function sandbox() {
	global $Testing;

	return api_response( $Testing->sandbox() );
}
