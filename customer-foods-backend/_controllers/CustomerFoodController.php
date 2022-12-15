<?php

require_once '_helpers.php';
global $wpdb;
global $db_prefix;
require_once __DIR__ . '/../_models/CustomerFood.php';
$CustomerFood = new CustomerFood($wpdb, $db_prefix);

add_action('rest_api_init', function () {
  global $api_prefix;

  register_rest_route($api_prefix, 'init_customer_foods', [
    'methods' => 'POST',
    'callback' => 'init_customer_foods'
  ]);

  register_rest_route($api_prefix, 'customer_foods', [
    'methods' => 'GET',
    'callback' => 'customer_foods'
  ]);
  register_rest_route($api_prefix, 'customer_food', [
    'methods' => 'POST',
    'callback' => 'store_customer_food'
  ]);

  register_rest_route($api_prefix, 'customer_food', [
    'methods' => 'PUT',
    'callback' => 'update_customer_food'
  ]);

  register_rest_route($api_prefix, 'customer_food', [
    'methods' => 'DELETE',
    'callback' => 'delete_customer_food'
  ]);

  register_rest_route($api_prefix, 'approve_customer_food', [
    'methods' => 'POST',
    'callback' => 'approve_customer_food'
  ]);
});

function init_customer_foods($request)
{
  global $CustomerFood;

  return api_response($CustomerFood->init_customer_foods(json_decode($request->get_body(), true)));
}

function customer_foods()
{
  global $CustomerFood;

  return api_response($CustomerFood->customer_foods());
}

function store_customer_food($request)
{
  global $CustomerFood;

  return api_response($CustomerFood->store_customer_food(json_decode($request->get_body(), true)));
}

function update_customer_food($request)
{
  global $CustomerFood;

  return api_response($CustomerFood->update_customer_food(json_decode($request->get_body(), true)));
}

function delete_customer_food($request)
{
  global $CustomerFood;

  return api_response($CustomerFood->delete_customer_food(json_decode($request->get_body(), true)));
}

function approve_customer_food($request)
{
  global $CustomerFood;

  return api_response($CustomerFood->approve_customer_food(json_decode($request->get_body(), true)));
}
