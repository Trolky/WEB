<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class account_controller
 * Controller responsible for handling account.css-related actions, including user profile management and login/logout.
 */
class account_controller implements IController {

    /**
     * @var database $db Instance of the database class for database operations.
     */
    private $db;

    /**
     * @var user_manager $user Instance of the user_manager class for user authentication and profile management.
     */
    private $user;

    /**
     * Constructor to initialize the database and user manager.
     * Includes the necessary files and creates instances for handling database and user management.
     */
    public function __construct() {
        // Include the database class and create an instance
        require_once (DIRECTORY_MODELS ."/database.php");
        $this->db = new database();

        // Include the user manager class and create an instance
        require_once (DIRECTORY_MODELS ."/user_manager.php");
        $this->user = new user_manager();
    }

    /**
     * Show the content for a specific page (e.g., 'Account settings' or 'Profile').
     * This method handles displaying the page and updating user data if applicable.
     *
     * @param string $page_name The name of the page to be displayed.
     * @return string Returns the page content (HTML).
     */
    public function show(string $page_name): string {
        // Global variables for template data, user data, and access rights
        global $data;
        global $users;
        global $roles;

        // Initialize the template data array
        $data = [];

        // Set the page title to the provided page name
        $data['title'] = $page_name;

        // Handle user logout action if the form has been submitted
        if(isset($_POST['logout']) && $_POST['logout'] == "logout"){
            $this->user->logout();
        }

        $data['userLogged'] = $this->user->is_logged();

        // If user is logged in, fetch their role and user data
        if( $data['userLogged']){
            $user = $this->user->get_data();
            $data['role_id'] = $user['ROLES_role_id'];
        } else {
            $data['role_id'] = null;
        }

        // Fetch user data if logged in
        if ($this->user->is_logged()) {
            $users = $this->user->get_data();
        }
        // Fetch user rights based on the role ID
        $roles = $this->db->get_role_by_id($users['ROLES_role_id']);

        // Handle form submission for updating user data (including password update)
        if (isset($_POST['potvrzeni'])) {
            // Check if email is provided
            if (isset($_POST['email']) && $_POST['email'] != "") {
                // Check if password and confirmation are set and match
                if (isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2'] && $_POST['password'] != "") {

                    // Verify if the last password matches the current password
                    if (password_verify($_POST['last_password'], $user['password']) || $_POST['last_password'] == $user['password']) {
                        // Password verification successful, update the user data
                        $res = $this->db->update_user(
                            $users['customer_id'],
                            $users['login'],
                            password_hash($_POST['password'], PASSWORD_BCRYPT), // Encrypt new password
                            $_POST['name'],
                            $_POST["phone"],
                            $_POST["surname"],
                            $_POST['email'],
                            $users['ROLES_role_id']
                        );

                        // Check if the update was successful and provide feedback
                        if ($res) {
                            echo "<script>alert('Uživatel byl úspěšně upraven')</script>";
                            $users = $this->user->get_data(); // Refresh user data
                        } else {
                            echo "<script>alert('Nepodařilo se upravitz uživatele')</script>"; // Error message
                        }
                    } else {
                        echo "<script>alert('Údaje se neshodují')</script>"; // Error in password verification
                    }
                } else {
                    // Update user data without changing the password if passwords are not provided
                    $res = $this->db->update_user(
                        $users['customer_id'],
                        $users['login'],
                        $user['password'], // Keep the current password
                        $_POST['name'],
                        $_POST["phone"],
                        $_POST["surname"],
                        $_POST['email'],
                        $users['ROLES_role_id']
                    );

                    // Check if the update was successful and provide feedback
                    if ($res) {
                        echo "<script>alert('Uživatel byl úspěšně upraven')</script>";
                        $users = $this->user->get_data(); // Refresh user data
                    } else {
                        echo "<script>alert('Nepodařilo se upravitz uživatele')</script>"; // Error message
                    }
                }
            } else {
                // Email not provided, show error message
                echo "<script>alert('Nebyl vyplněn email')</script>";
            }
        }

        // Capture the output of the account.css page and return it
        ob_start();
        require(DIRECTORY_VIEWS ."/account.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>