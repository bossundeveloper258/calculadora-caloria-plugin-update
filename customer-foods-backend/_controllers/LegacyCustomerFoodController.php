<?php

require_once '_helpers.php';
global $wpdb;
global $db_prefix;
require_once __DIR__ . '/../_models/LegacyCustomerFood.php';
$LegacyCustomerFood = new LegacyCustomerFood($wpdb, $db_prefix);

add_action('rest_api_init', function () {
  global $api_prefix;

  register_rest_route($api_prefix, 'init_legacy_customer_foods', [
    'methods' => 'POST',
    'callback' => 'init_legacy_customer_foods'
  ]);

  register_rest_route($api_prefix, 'legacy_customer_foods', [
    'methods' => 'GET',
    'callback' => 'legacy_customer_foods'
  ]);
  register_rest_route($api_prefix, 'legacy_customer_food', [
    'methods' => 'POST',
    'callback' => 'store_legacy_customer_food'
  ]);

  register_rest_route($api_prefix, 'legacy_customer_food', [
    'methods' => 'PUT',
    'callback' => 'update_legacy_customer_food'
  ]);

  register_rest_route($api_prefix, 'legacy_customer_food', [
    'methods' => 'DELETE',
    'callback' => 'delete_legacy_customer_food'
  ]);
});

function init_legacy_customer_foods($request)
{
  global $LegacyCustomerFood;

  return api_response($LegacyCustomerFood->init_legacy_customer_foods(json_decode($request->get_body(), true)));
}

function legacy_customer_foods()
{
  global $LegacyCustomerFood;

  return api_response($LegacyCustomerFood->legacy_customer_foods());
}

function store_legacy_customer_food($request)
{
  global $LegacyCustomerFood;

  return api_response($LegacyCustomerFood->store_legacy_customer_food(json_decode($request->get_body(), true)));
}

function update_legacy_customer_food($request)
{
  global $LegacyCustomerFood;

  return api_response($LegacyCustomerFood->update_legacy_customer_food(json_decode($request->get_body(), true)));
}

function delete_legacy_customer_food($request)
{
  global $LegacyCustomerFood;

  return api_response($LegacyCustomerFood->delete_legacy_customer_food(json_decode($request->get_body(), true)));
}
