<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class games_controller
 * Controller responsible for handling the games page, including displaying games by category and handling game orders.
 */
class games_controller implements IController {

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
     * Show the content for the games page.
     * This method handles displaying games based on the category, adding games to the order, and updating stock.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data and products (games)
        global $data, $product;

        // Initialize the template data array
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout if requested
        if (isset($_POST['logout']) && $_POST['logout'] === "logout") {
            $this->user->logout();
        }

        // Check if the user is logged in
        $data['userLogged'] = $this->user->is_logged();

        // If the user is logged in, fetch their data and set role and customer ID in template data
        if ($data['userLogged']) {
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
            $data['customer_id'] = $user['customer_id'];
        } else {
            // If not logged in, set role ID and customer ID to null
            $data['role_id'] = null;
            $data['customer_id'] = null;
        }

        // Set the category ID for the games page from the GET parameter, default to 0 if not set
        $data['category_id'] = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

        // Fetch games based on the selected category
        $product = $this->db->get_game_by_category_id($data['category_id']);

        // Handle adding an order to the cart when the user clicks the "buy" button
        if (isset($_POST['buy']) && isset($_POST['id']) && $data['customer_id']) {
            $product_id = intval($_POST['id']);
            $quantity = 1; // Default quantity to 1 for each order
            $orderStatusId = 1; // Status ID for new orders (e.g., "in cart")
            $totalPrice = floatval($_POST['price']); // Price of the product

            // Add the order to the database
            $res = $this->db->add_order(
                $data['customer_id'],
                $orderStatusId,
                $totalPrice,
                $product_id
            );

            // If the order was added successfully, decrease the stock and update the quantity
            if ($res) {
                // Decrease stock by the ordered quantity
                $qa = $this->db->decrease(intval($_POST['stock']), $quantity);

                // Update the product's stock quantity in the database
                $res2 = $this->db->update_quantity($product_id, $qa);
                if ($res2) {
                    header("Refresh:0"); // Refresh to reflect the changes
                } else {
                    echo "<script>alert('Nepodařilo se upravit množství')</script>";
                }
            } else {
                // If there was an error adding the order, show an alert
                echo "<script>alert('Nepodařilo se přidat objednávku')</script>";
            }
        }

        // Capture the output of the games page and return it
        ob_start();
        require(DIRECTORY_VIEWS . "/games.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>
