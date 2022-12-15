<?php
require_once 'Model.php';
require_once 'iModel.php';


class Testing extends Model implements iModel
{
  protected $user_id;
  protected $wpdb;
  protected $db_prefix;

  // TO COMPLY WITH INTERFACE iModel
  function update_rules()
  {
  }

  function store_rules()
  {
  }

  function validation_messages()
  {
  }

  function __construct($wpdb, $db_prefix)
  {
    $this->wpdb = $wpdb;
    $this->db_prefix = $db_prefix;
  }

  public function sandbox()
  {
    return $this->table_wp_users = $this->wpdb->prefix . 'users';

    $user_id = $this->get_current_user_id();
    return "The current user id is: $user_id";

    if (is_user_logged_in()) {
      echo 'User ID: ' . $us;
    } else {
      echo 'Hello visitor!';
    }
	  return [
      "user_id" => get_current_user_id()
    ];
    $LegacyCustomerFood = new LegacyCustomerFood($this->wpdb, $this->db_prefix);
    return $LegacyCustomerFood->legacy_customer_food_by_id(7);

	  $CustomerFood = new CustomerFood($this->wpdb, $this->db_prefix);
    return $Customer->customer_food_by_id(2);
		$Customer = new Customer($this->wpdb, $this->db_prefix);
		$Category = new Category($this->wpdb, $this->db_prefix);
		return $Category->get_composition();
		return $Customer->get_contact_requests_pending_qty();
	}
}

