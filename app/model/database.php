<?php


/**
 * Class for managing database operations.
 */
class database{

    private $pdo;


    /**
     * Initializes the database connection.
     */
    public function __construct(){
        $this->pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
    }


    /**
     * Executes a SQL query and returns the result or null in case of an error.
     *
     * @param string $query SQL query string.
     * @return PDOStatement|null Result set on success, null on failure.
     */
    private function executeQuery(string $query): ?PDOStatement{
        $res = $this->pdo->query($query);
        if ($res) {
            return $res;
        } else {
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        }
    }

    /**
     * Retrieves all users from the database.
     *
     * @return array List of users.
     */
    public function get_users(): array{
        $users = $this->select_from_db(TABLE_CUSTOMER, "", "customer_id");

        return $users;
    }

    /**
     * Retrieves all user roles from the database.
     *
     * @return array List of user roles.
     */
    public function get_rights(): array{
        $rights = $this->select_from_db(TABLE_ROLES, "", "role_id ASC, role_name ASC");

        return $rights;
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return array List of categories.
     */
    public function get_categories(): array{
        $categories = $this->select_from_db(TABLE_CATEGORY, "", "genre_name ASC");

        return $categories;
    }

    /**
     * Retrieves all products from the database.
     *
     * @return array List of products.
     */
    public function get_products(): array{
        $products = $this->select_from_db(TABLE_PRODUCT, "", "name ASC");

        return $products;
    }


    /**
     * Retrieves a specific role by its ID.
     *
     * @param int $id Role ID.
     * @return array|null Role details or null if not found.
     */
    public function get_role_by_id(int $id): ?array{
        $q = "SELECT * FROM " . TABLE_ROLES
            . " WHERE role_id=:role_id;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":role_id", $id);
        if ($user->execute()) {
            return $user->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Retrieves all products in a specific category by its ID.
     *
     * @param int $category_id Category ID.
     * @return array|null List of products or null if none are found.
     */
    public function get_game_by_category_id(int $category_id): ?array{
        $q = "SELECT * FROM " . TABLE_PRODUCT
            . " WHERE CATEGORY_category_id=$category_id;";
        $obj = $this->executeQuery($q);
        if ($obj) {
            return $obj->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Retrieves all items in the cart for a specific customer.
     *
     * @param int $customer_id Customer ID.
     * @return array|null List of cart items or null if the cart is empty.
     */
    public function get_items_in_cart(int $customer_id): ?array{
        $q = "SELECT `order`.*, 
                 order_status.status_name, 
                 customer.name AS customer_name, 
                 customer.surname AS customer_surname, 
                 customer.email AS customer_email,
                 `order`.quantity,
                  product.product_id,
                  product.name AS product_name,
                  product.description AS product_description,
                  product.price AS product_price,
                  product.stock AS product_stock,
                  product.CATEGORY_category_id
          FROM `" . TABLE_ORDER . "` AS `order`
          JOIN `" . TABLE_ORDER_STATUS . "` AS order_status ON order_status.order_status_id = `order`.ORDER_STATUS_order_status_id
          JOIN `" . TABLE_CUSTOMER . "` AS customer ON customer.customer_id = `order`.CUSTOMER_customer_id
           JOIN `" . TABLE_PRODUCT . "` AS product ON product.product_id = `order`.PRODUCT_product_id
          WHERE `order`.CUSTOMER_customer_id = :customer_id";

        $order = $this->pdo->prepare($q);
        $order->bindValue(":customer_id", $customer_id);

        if ($order->execute()) {
            return $order->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Retrieves records from a specific table with optional filtering and sorting.
     *
     * @param string $name Table name.
     * @param string $where Optional WHERE condition.
     * @param string $order Optional ORDER BY clause.
     * @return array List of records matching the criteria.
     */
    public function select_from_db(string $name, string $where = "", string $order = ""): array{
        $q = "SELECT * FROM " . $name
            . (($where == "") ? "" : " WHERE $where")
            . (($order == "") ? "" : " ORDER BY $order");
        $obj = $this->executeQuery($q);

        if ($obj == null) {
            return [];
        }

        return $obj->fetchAll();
    }

    /**
     * Updates rows in a specified table.
     *
     * @param string $name Table name.
     * @param string $statement Update statement (e.g., "column=value").
     * @param string $where WHERE condition for rows to update.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update_in_specific_table(string $name, string $statement, string $where): bool{
        $q = "UPDATE `$name` SET $statement WHERE $where";
        $obj = $this->executeQuery($q);

        return ($obj != null);
    }

    /**
     * Deletes rows from a specific table based on a condition.
     *
     * @param string $table Table name.
     * @param string $what WHERE condition for deletion.
     * @return bool True if rows were deleted, false otherwise.
     */
    public function delete_from_db(string $table, string $what): bool{
        $q = "DELETE FROM `$table` WHERE $what";
        $obj = $this->executeQuery($q);

        return ($obj != null);
    }


    /**
     * Checks if a user exists in the customer table with specific credentials.
     *
     * @param string $login User's login.
     * @param string $email User's email.
     * @param string $password User's password.
     * @return array|null User data if found, null otherwise.
     */
    public function is_in_customer_table($login, $email, $password){

        $q = "SELECT * FROM " . TABLE_CUSTOMER . " WHERE login=:login AND email=:email AND password=:password;";
        $output = $this->pdo->prepare($q);
        $output->bindValue(":login", $login);
        $output->bindValue(":email", $email);
        $output->bindValue(":password", $password);
        if ($output->execute()) {
            return $output->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Adds a new user to the database.
     *
     * @param string $login The login name of the user.
     * @param string $password The password of the user.
     * @param string $name The first name of the user.
     * @param string $surname The last name of the user.
     * @param string $email The email address of the user.
     * @param int $role_id The role ID of the user.
     * @param int $phone The phone number of the user.
     * @param string $address The address of the user.
     * @return bool Returns true if the user was successfully added, otherwise false.
     */
    public function add_user(string $login, string $name, string $surname, string $email, int $phone, string $password, string $address, int $role_id){
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);
        $name = htmlspecialchars($name);
        $surname = htmlspecialchars($surname);
        $email = htmlspecialchars($email);
        $role_id = htmlspecialchars($role_id);
        $phone = htmlspecialchars($phone);
        $address = htmlspecialchars($address);

        $user = $this->is_in_customer_table($login, $email, $password);

        if (!isset($user) || count($user) == 0) {

            $q = "INSERT INTO " . TABLE_CUSTOMER . " (customer_id,login,name,surname, email,phone_number,password,address,ROLES_role_id) VALUES (NULL,:login, :name, :surname, :email,:phone_number, :password,  :address, :ROLES_role_id)";
            $output = $this->pdo->prepare($q);
            $output->bindValue(":login", $login);
            $output->bindValue(":name", $name);
            $output->bindValue(":surname", $surname);
            $output->bindValue(":email", $email);
            $output->bindValue(":phone_number", $phone);
            $output->bindValue(":password", $password);
            $output->bindValue(":address", $address);
            $output->bindValue(":ROLES_role_id", $role_id);

            if ($output->execute()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * Adds a new product to the database.
     *
     * @param string $product_name The name of the product.
     * @param int $price The price of the product.
     * @param int $stock The stock quantity of the product.
     * @param int $category_id The category ID of the product.
     * @param string $description A description of the product.
     * @return bool Returns true if the product was successfully added, otherwise false.
     */
    public function add_product(string $product_name, int $price, int $stock, int $category_id, string $description){
        $name = htmlspecialchars($product_name);
        $price = htmlspecialchars($price);
        $stock = htmlspecialchars($stock);
        $category_id = htmlspecialchars($category_id);
        $description = htmlspecialchars($description);


            $q = "INSERT INTO " . TABLE_PRODUCT . " (product_id,name,price,stock,CATEGORY_category_id,description)
             VALUES (NULL,:name, :price, :stock, :category_id, :description)";

        $output = $this->pdo->prepare($q);
            $output->bindValue(":name", $name);
            $output->bindValue(":price", $price);
            $output->bindValue(":stock", $stock);
            $output->bindValue(":category_id", $category_id);
            $output->bindValue(":description", $description);
        try {
            if ($output->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    /**
     * Adds a new order to the database.
     *
     * @param int $customer_id The ID of the customer placing the order.
     * @param int $order_status_id The status ID of the order.
     * @param float $total_price The total price of the order.
     * @param int $product_id The ID of the product being ordered.
     * @return bool Returns true if the order was successfully added, otherwise false.
     */
    public function add_order(int $customer_id, int $order_status_id, float $total_price, int $product_id) {
        $order_date = date('Y-m-d H:i:s');
        $customer_id = htmlspecialchars($customer_id);
        $order_status_id = htmlspecialchars($order_status_id);
        $total_price = htmlspecialchars($total_price);
        $product_id = htmlspecialchars($product_id);

        $q = "INSERT INTO `" . TABLE_ORDER . "`
      (order_id, order_date, total_price, CUSTOMER_customer_id, SHIPMENT_shipment_id, PAYMENT_payment_id, ORDER_STATUS_order_status_id, PRODUCT_product_id, quantity) 
      VALUES 
      (NULL, :order_date, :total_price, :customer_id, NULL, NULL, :order_status_id, :PRODUCT_product_id, :quantity)";

        $output = $this->pdo->prepare($q);
        $output->bindValue(":order_date", $order_date);
        $output->bindValue(":total_price", $total_price);
        $output->bindValue(":customer_id", $customer_id);
        $output->bindValue(":order_status_id", $order_status_id);
        $output->bindValue(":PRODUCT_product_id", $product_id);
        $output->bindValue(":quantity", 1);

        try {
            if ($output->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Updates the details of a specific user in the database.
     *
     * @param int $customer_id The ID of the user to update.
     * @param string $login The updated login name.
     * @param string $password The updated password.
     * @param string $name The updated first name.
     * @param int $number The updated phone number.
     * @param string $surname The updated last name.
     * @param string $email The updated email address.
     * @param int $role_id The updated role ID.
     * @return bool Returns true if the user was successfully updated, otherwise false.
     */
    public function update_user(int $customer_id, string $login, string $password, string $name, int $number, string $surname, string $email, int $role_id){
        $statement = "login='$login', password='$password', name='$name', email='$email', ROLES_role_id='$role_id', phone_number='$number', surname = '$surname' ";
        $where = "customer_id=$customer_id";

        return $this->update_in_specific_table(TABLE_CUSTOMER, $statement, $where);
    }

    /**
     * Updates the stock quantity of a specific product in the database.
     *
     * @param int $product_id The ID of the product to update.
     * @param int $stock The new stock quantity.
     * @return bool Returns true if the quantity was successfully updated, otherwise false.
     */
    public function update_quantity(int $product_id, int $stock){
        $statement = "stock='$stock'";
        $where = "product_id=$product_id";

        return $this->update_in_specific_table(TABLE_PRODUCT, $statement, $where);
    }

    /**
     * Updates the role of a specific user in the database.
     *
     * @param int $customer_id The ID of the user to update.
     * @param int $role_id The new role ID.
     * @return bool Returns true if the role was successfully updated, otherwise false.
     */
    public function update_roles(int $customer_id, int $role_id){
        $statement = "ROLES_role_id='$role_id'";
        $where = "customer_id=$customer_id";

        return $this->update_in_specific_table(TABLE_CUSTOMER, $statement, $where);
    }



    /**
     * Updates the details of a specific product in the database.
     *
     * @param int $product_id The ID of the product to update.
     * @param int $price The new price of the product.
     * @param int $stock The new stock quantity of the product.
     * @param int $category_id The new category ID of the product.
     * @return bool Returns true if the product was successfully updated, otherwise false.
     */
    public function product_update(int $product_id, int $price, int $stock, int $category_id){
        $statements = "price='$price', stock='$stock', CATEGORY_category_id='$category_id'";
        $where = "product_id=$product_id";

        return $this->update_in_specific_table(TABLE_PRODUCT, $statements, $where);
    }

    /**
     * Decreases a given value by a specified decrement.
     *
     * @param int $value The initial value.
     * @param int $decrement The amount to decrease.
     * @return int The resulting value after the decrement.
     */
    public function decrease(int $value, int $decrement){
        $value = $value - $decrement;

        return $value;
    }

    /**
     * Increases a given value by a specified increment.
     *
     * @param int $value The initial value.
     * @param int $increment The amount to increase.
     * @return int The resulting value after the increment.
     */
    public function increase(int $value, int $increment){
        $value = $value + $increment;

        return $value;
    }

}

?>
