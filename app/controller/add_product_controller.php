<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class add_product_controller
 * Controller responsible for adding new products to the system.
 */
class add_product_controller implements IController {

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
     * Show the page for adding a new product.
     * This method handles displaying the form, processing the form submission, and adding the product to the database.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data and categories
        global $data, $categories;

        // Initialize the template data array
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout if requested
        if (isset($_POST['logout']) && $_POST['logout'] == "logout") {
            $this->user->logout();
        }
        $data['userLogged'] = $this->user->is_logged();

        // If the user is logged in, fetch their role and set it in template data
        if ($data['userLogged']) {
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
        } else {
            // If not logged in, set role ID to null
            $data['role_id'] = null;
        }

        // Process the form submission for adding a new product
        if (isset($_POST['add'])) {
            var_dump($_POST); // Debugging output of POST data

            // Check if all necessary form fields are set
            if (isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['quantity'])
                && isset($_POST['category_id']) && isset($_POST['text'])) {

                // Call the database method to add the product
                $res = $this->db->add_product(
                    $_POST['product_name'],
                    intval($_POST['price']),    // Convert price to integer
                    intval($_POST['quantity']), // Convert quantity to integer
                    intval($_POST['category_id']), // Convert category ID to integer
                    $_POST['text'] // Product description text
                );

                // Check if the product was successfully added
                if ($res) {
                    header("Location: index.php?page=warehouse");
                    exit;
                } else {
                    echo "<script>
                        alert('Produkt se nepodařilo přidat.');
                    </script>";
                }
            }
        }

        // Fetch available categories from the database
        $categories = $this->db->get_categories();

        // Capture the output of the new product form page and return it
        ob_start();
        require(DIRECTORY_VIEWS ."/add_product.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>