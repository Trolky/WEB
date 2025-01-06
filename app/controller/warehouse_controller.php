<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class warehouse_controller
 * Controller for managing the warehouse, including viewing products, deleting products, and updating product details.
 */
class warehouse_controller implements IController {

    /**
     * @var database $db Instance of the database class for database operations.
     */
    private $db;

    /**
     * @var user_manager $user Instance of the user_manager class for user authentication and management.
     */
    private $user;

    /**
     * Constructor to initialize the database and user manager.
     * Includes the necessary files and creates instances for handling database operations and user management.
     */
    public function __construct() {
        // Initialize database operations
        require_once (DIRECTORY_MODELS ."/database.php");
        $this->db = new database();

        // Initialize user manager for user operations
        require_once (DIRECTORY_MODELS ."/user_manager.php");
        $this->user = new user_manager();
    }

    /**
     * Show the content for the warehouse management page.
     * This method handles warehouse operations like viewing products, deleting products, and updating product details.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data, products, and categories
        global $data, $product, $categories;
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout if requested
        if (isset($_POST['logout']) && $_POST['logout'] === "logout") {
            $this->user->logout();
        }

        // Check if the user is logged in
        $data['userLogged'] = $this->user->is_logged();

        // If the user is logged in, fetch their data and set role ID
        if ($data['userLogged']) {
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
        } else {
            // If not logged in, set role ID to null
            $data['role_id'] = null;
        }

        // Handle product deletion
        if (isset($_POST['delete'])) {
            // Delete product from the database based on product_id
            $res = $this->db->delete_from_db(TABLE_PRODUCT, "product_id='$_POST[product_id]'");
            if ($res) {
                echo "<script>alert('Produkt byl úspěšně smazán')</script>";
            } else {
                echo "<script>alert('ERROR: Něco se nepovedlo')</script>";
            }
        }

        // Handle product update (price, stock, category)
        if (isset($_POST['update'])) {
            // Update product details in the database based on product_id
            $res = $this->db->product_update($_POST['product_id'], $_POST['price'], $_POST['stock'], $_POST['category_id']);
            if ($res) {
                echo "<script>alert('UPRAVENO')</script>";
            } else {
                echo "<script>alert('ERROR: Něco se nepovedlo')</script>";
            }
        }

        // Retrieve all products' data from the database
        $product = $this->db->get_products();

        // Retrieve all product categories
        $categories = $this->db->get_categories();

        // Render the warehouse management view
        ob_start();
        require(DIRECTORY_VIEWS ."/warehouse.php");
        $page_content = ob_get_clean(); // Capture the output of the view

        return $page_content; // Return the page content
    }
}
?>
