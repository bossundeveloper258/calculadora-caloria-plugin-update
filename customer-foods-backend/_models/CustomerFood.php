<?php
require_once 'LegacyCustomerFood.php';
require_once 'Model.php';
require_once 'iModel.php';

class CustomerFood extends Model implements iModel
{
  protected $wpdb;
  protected $table_customer_foods;
  protected $db_prefix;

  function __construct($wpdb, $db_prefix)
  {
    $this->wpdb = $wpdb;
    $this->db_prefix = $db_prefix;
    $this->table_customer_foods = $db_prefix . 'customer_foods';
    $this->table_wp_users = $wpdb->prefix . 'users';
    $this->table_meal_product = $wpdb->prefix . 'cc_meal_product';
  }

  public function store_rules()
  {
    return [
      'description' => 'required',
      'amount' => 'required|numeric',
      'unit' => 'required',
      'kCalories' => 'required|numeric',
      'protein' => 'required|numeric',
      'carbohydrates' => 'required|numeric',
      'fat' => 'required|numeric',
      'vitA' => 'numeric',
      'vitB1' => 'numeric',
      'vitB2' => 'numeric',
      'vitB3' => 'numeric',
      'vitB5' => 'numeric',
      'vitB6' => 'numeric',
      'vitB9' => 'numeric',
      'vitB12' => 'numeric',
      'vitC' => 'numeric',
      'vitD' => 'numeric',
      'vitE' => 'numeric',
      'vitK' => 'numeric',
      'choline' => 'numeric',
      'calcium' => 'numeric',
      'copper' => 'numeric',
      'iron' => 'numeric',
      'magnesium' => 'numeric',
      'manganese' => 'numeric',
      'phosphorus' => 'numeric',
      'potassium' => 'numeric',
      'selenium' => 'numeric',
      'sodium' => 'numeric',
      'zinc' => 'numeric',
      'water' => 'numeric',
      'fiber' => 'numeric',
      'cholesterol' => 'numeric',
      'saturatedFat' => 'numeric',
      'monoUnsaturatedFat' => 'numeric',
      'polyUnsaturatedFat' => 'numeric',
      'glycemicIndex' => 'numeric',
      'id_user' => 'numeric',
    ];
  }

  public function update_rules()
  {
    return [
      'description' => 'required',
      'amount' => 'required|numeric',
      'unit' => 'required',
      'kCalories' => 'required|numeric',
      'protein' => 'required|numeric',
      'carbohydrates' => 'required|numeric',
      'fat' => 'required|numeric',
      'vitA' => 'numeric',
      'vitB1' => 'numeric',
      'vitB2' => 'numeric',
      'vitB3' => 'numeric',
      'vitB5' => 'numeric',
      'vitB6' => 'numeric',
      'vitB9' => 'numeric',
      'vitB12' => 'numeric',
      'vitC' => 'numeric',
      'vitD' => 'numeric',
      'vitE' => 'numeric',
      'vitK' => 'numeric',
      'choline' => 'numeric',
      'calcium' => 'numeric',
      'copper' => 'numeric',
      'iron' => 'numeric',
      'magnesium' => 'numeric',
      'manganese' => 'numeric',
      'phosphorus' => 'numeric',
      'potassium' => 'numeric',
      'selenium' => 'numeric',
      'sodium' => 'numeric',
      'zinc' => 'numeric',
      'water' => 'numeric',
      'fiber' => 'numeric',
      'cholesterol' => 'numeric',
      'saturatedFat' => 'numeric',
      'monoUnsaturatedFat' => 'numeric',
      'polyUnsaturatedFat' => 'numeric',
      'glycemicIndex' => 'numeric',
      'id_user' => 'numeric',
    ];
  }

  public function validation_messages()
  {
    return [
      'description.required' => 'Por favor introduzca el nombre',
      'amount.required' => 'Por favor introduzca la cantidad',
      'unit.required' => 'Por favor introduzca las unidades',
      'kCalories.required' => 'Por favor introduzca las kilocalor??as',
      'protein.required' => 'Por favor introduzca las prote??nas',
      'carbohydrates.required' => 'Por favor introduzca los carbohidratos',
      'fat.required' => 'Por favor introduzca la grasa',

      'amount.numeric' => 'La cantidad debe ser un n??mero',
      'kCalories.numeric' => 'Las kilocalor??as debe ser un n??mero',
      'protein.numeric' => 'Las prote??nas debe ser un n??mero',
      'carbohydrates.numeric' => 'Los carbohidratos debe ser un n??mero',
      'fat.numeric' => 'La grasa debe ser un n??mero',

      'vitA.numeric' => 'La vitamina A debe ser un n??mero',
      'vitB1.numeric' => 'La vitamina B1 debe ser un n??mero',
      'vitB2.numeric' => 'La vitamina B2 debe ser un n??mero',
      'vitB3.numeric' => 'La vitamina B3 debe ser un n??mero',
      'vitB5.numeric' => 'La vitamina B5 debe ser un n??mero',
      'vitB6.numeric' => 'La vitamina B6 debe ser un n??mero',
      'vitB9.numeric' => 'La vitamina B9 debe ser un n??mero',
      'vitB12.numeric' => 'La vitamina B12 debe ser un n??mero',
      'vitC.numeric' => 'La vitamina C debe ser un n??mero',
      'vitD.numeric' => 'La vitamina D debe ser un n??mero',
      'vitE.numeric' => 'La vitamina E debe ser un n??mero',
      'vitK.numeric' => 'La vitamina K debe ser un n??mero',
      'choline.numeric' => 'La colina debe ser un n??mero',
      'calcium.numeric' => 'El calcio debe ser un n??mero',
      'copper.numeric' => 'El cobre debe ser un n??mero',
      'iron.numeric' => 'El hierro debe ser un n??mero',
      'magnesium.numeric' => 'El magnesio debe ser un n??mero',
      'manganese.numeric' => 'El manganeso debe ser un n??mero',
      'phosphorus.numeric' => 'El f??sforo debe ser un n??mero',
      'potassium.numeric' => 'El potasio debe ser un n??mero',
      'selenium.numeric' => 'El selenio debe ser un n??mero',
      'sodium.numeric' => 'El sodio debe ser un n??mero',
      'zinc.numeric' => 'El zinc debe ser un n??mero',
      'water.numeric' => 'El agua debe ser un n??mero',
      'fiber.numeric' => 'La fibra debe ser un n??mero',
      'cholesterol.numeric' => 'El colesterol debe ser un n??mero',
      'saturatedFat.numeric' => 'La grasa saturada debe ser un n??mero',
      'monoUnsaturatedFat.numeric' => 'La grasa mono saturada debe ser un n??mero',
      'polyUnsaturatedFat.numeric' => 'Las grasa poli saturada debe ser un n??mero',
      'glycemicIndex.numeric' => 'El ??ndice glic??mico debe ser un n??mero',
      'id_user.numeric' => 'El id de usuario debe ser un n??mero'
    ];
  }

  public function init_customer_foods($data)
  {
    return [
      "customer_foods" => $this->paginated_customer_foods($data)
    ];
  }

  public function paginated_customer_foods($data)
  {
    $page = $data["page"];
    $term = $data["term"] ? Helper::mysql_escape(trim($data["term"])) : '';
    $length = $data["length"];
    $offset = $length * ($page - 1);

    $mainQuery = "SELECT * from $this->table_customer_foods cf LEFT JOIN $this->table_wp_users wu ON cf.id_user = wu.id";
    $filterQuery = "WHERE description like '%$term%'";
    $order = "ORDER BY cf.id ASC";

    $query = $term ? $mainQuery . ' ' . $filterQuery . ' ' . $order : $mainQuery . ' ' . $order;

    $notFiltered = $this->wpdb->get_results($query);
    $filtered = $this->wpdb->get_results("$query LIMIT $offset, $length");

    $itemsNumber = count($notFiltered);
    $pagesNumber = $itemsNumber ? (integer)(ceil($itemsNumber / $length)) : 1;
    $currentPage = $pagesNumber > 1 ? $page : 1;

    return [
      "itemsNumber" => $itemsNumber,
      "itemsRows" => $filtered,
      "pagesNumber" => $pagesNumber,
      "currentPage" => $currentPage,
      "term" => $term,
    ];
  }

  public function customer_foods()
  {
    return $this->wpdb->get_results(
      "SELECT * FROM $this->table_customer_foods ORDER BY id ASC"
    );
  }

  public function customer_food_by_id($id)
  {
    return $this->wpdb->get_results(
      "SELECT * FROM $this->table_customer_foods WHERE ID = $id"
    );
  }

  public function store_customer_food($data)
  {
    $item = $data["item"];
    $errors = $this->get_store_errors($item);
    $created = false;
    if (!$errors) {
      try {
        $created = $this->wpdb->insert(
          $this->table_customer_foods,
          [
            'description' => $item['description'],
            'amount' => $item['amount'],
            'unit' => $item['unit'],
            'kCalories' => $item['kCalories'],
            'protein' => $item['protein'],
            'carbohydrates' => $item['carbohydrates'],
            'fat' => $item['fat'],
            'vitA' => $item['vitA'],
            'vitB1' => $item['vitB1'],
            'vitB2' => $item['vitB2'],
            'vitB3' => $item['vitB3'],
            'vitB5' => $item['vitB5'],
            'vitB6' => $item['vitB6'],
            'vitB9' => $item['vitB9'],
            'vitB12' => $item['vitB12'],
            'vitC' => $item['vitC'],
            'vitD' => $item['vitD'],
            'vitE' => $item['vitE'],
            'vitK' => $item['vitK'],
            'choline' => $item['choline'],
            'calcium' => $item['calcium'],
            'copper' => $item['copper'],
            'iron' => $item['iron'],
            'magnesium' => $item['magnesium'],
            'manganese' => $item['manganese'],
            'phosphorus' => $item['phosphorus'],
            'potassium' => $item['potassium'],
            'selenium' => $item['selenium'],
            'sodium' => $item['sodium'],
            'zinc' => $item['zinc'],
            'water' => $item['water'],
            'fiber' => $item['fiber'],
            'cholesterol' => $item['cholesterol'],
            'saturatedFat' => $item['saturatedFat'],
            'monoUnsaturatedFat' => $item['monoUnsaturatedFat'],
            'polyUnsaturatedFat' => $item['polyUnsaturatedFat'],
            'glycemicIndex' => $item['glycemicIndex'],
            'comments' => $item['comments'],
            'id_user' => $this->get_current_user_id()
          ],
          [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
          ]
        );
      } catch (Exception $e) {
        $errors[] = $e->getMessage();
      }

      if ($created === false) {
        $errors[] = "Error de base de datos";
      }
    }

    return ['errors' => $errors];
  }

  public function update_customer_food($data)
  {
    $item = $data["item"];
    $errors = $this->get_update_errors($item);

    if (!$errors) {
      $updated = false;
      try {
        $updated = $this->wpdb->update(
          $this->table_customer_foods,
          [
            'description' => $item['description'],
            'amount' => $item['amount'],
            'unit' => $item['unit'],
            'kCalories' => $item['kCalories'],
            'protein' => $item['protein'],
            'carbohydrates' => $item['carbohydrates'],
            'fat' => $item['fat'],
            'vitA' => $item['vitA'],
            'vitB1' => $item['vitB1'],
            'vitB2' => $item['vitB2'],
            'vitB3' => $item['vitB3'],
            'vitB5' => $item['vitB5'],
            'vitB6' => $item['vitB6'],
            'vitB9' => $item['vitB9'],
            'vitB12' => $item['vitB12'],
            'vitC' => $item['vitC'],
            'vitD' => $item['vitD'],
            'vitE' => $item['vitE'],
            'vitK' => $item['vitK'],
            'choline' => $item['choline'],
            'calcium' => $item['calcium'],
            'copper' => $item['copper'],
            'iron' => $item['iron'],
            'magnesium' => $item['magnesium'],
            'manganese' => $item['manganese'],
            'phosphorus' => $item['phosphorus'],
            'potassium' => $item['potassium'],
            'selenium' => $item['selenium'],
            'sodium' => $item['sodium'],
            'zinc' => $item['zinc'],
            'water' => $item['water'],
            'fiber' => $item['fiber'],
            'cholesterol' => $item['cholesterol'],
            'saturatedFat' => $item['saturatedFat'],
            'monoUnsaturatedFat' => $item['monoUnsaturatedFat'],
            'polyUnsaturatedFat' => $item['polyUnsaturatedFat'],
            'glycemicIndex' => $item['glycemicIndex'],
            'comments' => $item['comments'],
            'id_user' => $item['id_user']
          ],
          [
            'id' => $item["id"]
          ],
          [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
          ],
          [
            '%d'
          ]
        );
      } catch (Exception $e) {
        $errors[] = $e->getMessage();
      }

      if ($updated === false) {
        $errors[] = "Error de base de datos: actualizaci??n";
      }
    }

    return ['errors' => $errors];
  }

  public function delete_customer_food($data)
  {
    $item = $data["item"];
    $errors = [];

    $deleted = false;
    if (!$errors) {
      try {
        $deleted = $this->wpdb->delete(
          $this->table_customer_foods,
          [
            'id' => $item["id"]
          ],
          [
            '%d'
          ]
        );
      } catch (Exception $e) {
        $errors[] = $e->getMessage();
      }
    }

    if ($deleted === false) {
      $errors[] = "Error al borrar el alimento de cliente";
    }

    return ['errors' => $errors];
  }

  public function approve_customer_food($data)
  {
    $item = $data["item"];
    $LegacyCustomerFood = new LegacyCustomerFood($this->wpdb, $this->dbprefix);
    $errors = [];

    $updated = false;
    if (!$errors) {
      try {
        // get the row (food) here

        $customer_food = $this->customer_food_by_id($item['id']);
        $customer_food = count($customer_food) ? (array)$customer_food[0] : null;

        if ($customer_food) {
          // add the row (food) on the legacy table
          $result = $LegacyCustomerFood->store_legacy_customer_food(["item" => $customer_food]);
          $id_legacy_customer_food = $result["id_legacy_customer_food"];

          // update the table on the other plugin that refers to this

          $updated = $this->wpdb->get_results(
            "UPDATE $this->table_meal_product
                SET productId = $id_legacy_customer_food
                WHERE productId = {$item['id']}
                "
          );

          $errors = $result["errors"];

          // delete the row (food) from here
          $errors = array_merge($this->delete_customer_food(["item" => $customer_food])["errors"], $errors);

        } else {
          $errors = ["No se pudo obtener el alimento del cliente"];
        }

      } catch (Exception $e) {
        $errors[] = $e->getMessage();
      }

      if (count($errors)) {
        $errors[] = "Error de base de datos: aprobaci??n";
      }
    }
    return [
      'errors' => $errors,
      'updated' => $updated
    ];
  }
}

