<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class users_controller
 * Controller responsible for managing users, such as viewing users, deleting users, and updating user roles.
 */
class users_controller implements IController {

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
     * Show the content for the user management page.
     * This method handles user management operations like deleting users, updating roles, and displaying user data.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data and user management
        global $data;
        global $users;
        global $roles;

        // Initialize template data array
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout if requested
        if (isset($_POST['logout']) && $_POST['logout'] === "logout") {
            $this->user->logout();
        }
        $data['userLogged'] = $this->user->is_logged();

        // If the user is logged in, fetch their data and set role ID
        if ($data['userLogged'] ) {
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
        } else {
            // If not logged in, set role ID to null
            $data['role_id'] = null;
        }

        // Handle user deletion
        if (isset($_POST['delete'])) {
            // Delete user from the database based on customer_id
            $res = $this->db->delete_from_db(TABLE_CUSTOMER, "customer_id='$_POST[customer_id]'");
            if ($res) {
                echo "<script>alert('Uživatel byl úspěšně smazán')</script>";
            } else {
                echo "<script>alert('Uživatele se nepovedlo odstranit')</script>";
            }
        }

        // Handle role update for a user
        if (isset($_POST['update'])) {
            // Update user role in the database based on customer_id and selected role
            $res = $this->db->update_roles($_POST['customer_id'], $_POST['role']);
            if ($res) {
                echo "<script>alert('Role uživatele byla upravena')</script>";
            } else {
                echo "<script>alert('Role uživatele se nepodařilo upravit')</script>";
            }
        }

        // Retrieve all users' data
        $users = $this->db->get_users();

        // Retrieve all available rights (roles or permissions)
        $roles = $this->db->get_rights();

        // Render the user management view
        ob_start();
        require(DIRECTORY_VIEWS ."/users.php");
        $page_content = ob_get_clean(); // Capture the output of the view

        return $page_content; // Return the page content
    }
}
?>
