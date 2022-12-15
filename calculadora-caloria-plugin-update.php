<?php
/*
Plugin Name: Calculadora Calorías - Actualización
Plugin URI: https://apazim.com
Description: Actualización con ajustes varios
Version: 1.0
Author: Alcides Apaza Yanarico
Author URI: apaza.alcides@gmail.com
License: GPLv2
*/

add_action('wp_enqueue_scripts', 'enqueue_scripts');
function enqueue_scripts($hook)
{
  wp_enqueue_style('customstyle',
    plugins_url('style.css', __FILE__));
  wp_enqueue_script('customscript',
    plugins_url('script.js', __FILE__));
}

global $cca_db_version;
$cca_db_version = '1.0'; // plugin database version
global $db_prefix;
global $wpdb;
$db_prefix = $wpdb->prefix . 'cca_'; //wp_cca_

// get the logged in user id
global $cca_current_user_id;
add_action('init', 'cca_get_current_user_id');
function cca_get_current_user_id(){
  global $cca_current_user_id;
  $cca_current_user_id = get_current_user_id();
}

function cca_install()
{
  global $wpdb;
  global $cca_db_version;
  global $db_prefix;
  $charset_collate = $wpdb->get_charset_collate();

  $queries = [];

  $table_name = $db_prefix . 'customer_foods';
  array_push($queries, "CREATE TABLE $table_name (
    id                 mediumint auto_increment,
    description        text           not null,
    amount             smallint(5)    not null,
    unit               varchar(10)    not null,
    kCalories          decimal(10, 2) null,
    protein            decimal(10, 1) null,
    carbohydrates      decimal(10, 1) null,
    fat                decimal(10, 1) null,
    vitA               decimal(10, 1) null,
    vitB1              decimal(10, 1) null,
    vitB2              decimal(10, 1) null,
    vitB3              decimal(10, 1) null,
    vitB5              decimal(10, 1) null,
    vitB6              decimal(10, 1) null,
    vitB9              decimal(10, 1) null,
    vitB12             decimal(10, 1) null,
    vitC               decimal(10, 1) null,
    vitD               decimal(10, 1) null,
    vitE               decimal(10, 1) null,
    vitK               decimal(10, 1) null,
    choline            decimal(10, 1) null,
    calcium            decimal(10, 1) null,
    copper             decimal(10, 1) null,
    iron               decimal(10, 1) null,
    magnesium          decimal(10, 1) null,
    manganese          decimal(10, 1) null,
    phosphorus         decimal(10, 1) null,
    potassium          decimal(10, 1) null,
    selenium           decimal(10, 1) null,
    sodium             decimal(10, 1) null,
    zinc               decimal(10, 1) null,
    water              decimal(10, 1) null,
    fiber              decimal(10, 1) null,
    cholesterol        decimal(10, 1) null,
    saturatedFat       decimal(10, 1) null,
    monoUnsaturatedFat decimal(10, 1) null,
    polyUnsaturatedFat decimal(10, 1) null,
    glycemicIndex      decimal(10, 1) null,
    comments           text           null,
    id_user            mediumint      null,
		PRIMARY KEY  (id)
	) AUTO_INCREMENT = 100000 $charset_collate;");

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  // standard database creation
  foreach ($queries as $query) {
    dbDelta($query);
  }

  // store database version
  add_option('cca_db_version', $cca_db_version);
}

register_activation_hook(__FILE__, 'cca_install');

// admin files
add_action('admin_enqueue_scripts', 'cca_admin_enqueue_scripts', 10000);
function cca_admin_enqueue_scripts($hook)
{

  // add conditional to load only in our own menu
  if ($hook == "toplevel_page_admin_alimentos_calculadora") {
    // webpack assets
    wp_register_script('cca_wadmin_chunk_vendors', plugins_url('customer-foods-backend/dist/js/chunk-vendors.js', __FILE__), '', true);
    wp_enqueue_script('cca_wadmin_chunk_vendors');

    wp_register_script('cca_wadmin_app', plugins_url('customer-foods-backend/dist/js/app.js', __FILE__), '', true);
    wp_enqueue_script('cca_wadmin_app');
  }
}

// add admin page
add_action('admin_menu', 'cca_alimentos_calculadora_menu');
function cca_alimentos_calculadora_menu()
{
  add_menu_page('Alimentos de clientes', 'Alimentos de clientes', 'manage_options', 'admin_alimentos_calculadora', 'render_admin_alimentos_calculadora', plugins_url('cca_icon.png', __FILE__), 100000);
}

// render admin page
function render_admin_alimentos_calculadora()
{
  echo <<<PAGE
<div id="customer-foods-backend">
	<div class="columns nav is-multiline is-mobile">
    <div class="column is-full-mobile is-half-tablet">
      <router-link to="/"
      class="button is-active is-link">Alimentos de clientes</router-link>
    </div>
    <div class="column is-full-mobile is-half-tablet">
      <router-link to="/legacy_customer_foods"
      class="button is-active is-link">Alimentos revisados</router-link>
    </div>
  </div>
  <transition name="router-anim" mode="out-in">
    <router-view></router-view>
  </transition>
</div>
PAGE;
}

// API Endpoints
global $api_prefix;
$api_prefix = "cca/v1";

//require_once 'api_categories.php';
require_once 'customer-foods-backend/_controllers/TestingController.php';
require_once 'customer-foods-backend/_controllers/CustomerFoodController.php';
require_once 'customer-foods-backend/_controllers/LegacyCustomerFoodController.php';

