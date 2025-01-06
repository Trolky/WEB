<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class main_controller
 * Controller responsible for displaying the main page.
 */
class main_controller implements IController {

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
     * Show the content for the main page.
     * This method handles user login state and displays the main page.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variable for template data
        global $data;

        // Initialize template data array
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

        // Capture the output of the main page and return it
        ob_start();
        require(DIRECTORY_VIEWS ."/main.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>
