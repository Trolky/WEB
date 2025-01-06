<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class cart_controller
 * Controller responsible for handling cart operations, including viewing the cart, removing items, and completing orders.
 */
class cart_controller implements IController {
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
     * Show the content for the shopping cart page.
     * This method handles displaying the cart, removing items from the cart, and completing orders.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data and cart items
        global $data, $items;

        // Initialize the template data array
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout if requested
        if (isset($_POST['logout']) && $_POST['logout'] == "logout") {
            $this->user->logout();
        }

        // Check if the user is logged in
        $data['userLogged'] = $this->user->is_logged();

        // If the user is logged in, fetch their role and set it in template data
        if ($data['userLogged']) {
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
        } else {
            // If not logged in, set role ID to null
            $data['role_id'] = null;
        }

        // Fetch the items in the user's cart from the database
        $items = $this->db->get_items_in_cart($user["customer_id"]);

        // Handle item removal from the cart
        if (isset($_POST['delete'])) {
            // Delete the item from the database
            $res = $this->db->delete_from_db(TABLE_ORDER, "order_id='$_POST[cart_id]'");

            // Increase the stock of the deleted item
            $qa = $this->db->increase(intval($_POST['product_quantity']), intval($_POST['product_stock']));

            // Update the quantity of the product in the database
            $res2 = $this->db->update_quantity($_POST['product_id'], $qa);

            // Refresh the page to reflect changes
            header("Location: " . $_SERVER['REQUEST_URI']);
        }

        // Handle order completion (purchase) from the cart
        if (isset($_POST['buy'])) {
            $cart_order_status = 1; // Status for cart orders
            $finished_order_status = 2; // Status for completed orders

            // Update the order status to 'finished' for the logged-in user
            $update = "ORDER_STATUS_order_status_id = '$finished_order_status'";
            $where = "CUSTOMER_customer_id = '$user[customer_id]' AND ORDER_STATUS_order_status_id = '$cart_order_status'";

            // Update the order status in the database
            $res = $this->db->update_in_specific_table(TABLE_ORDER, $update, $where);

            // Provide feedback on whether the order was successfully completed
            if ($res) {
                echo "<script>alert('Úspěšně nakoupeno.')</script>";
            }

            // Redirect to the homepage after the purchase
            header("Location: index.php?page=index.php");
            exit;
        }

        // Capture the output of the cart page and return it
        ob_start();
        require(DIRECTORY_VIEWS ."/cart.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>