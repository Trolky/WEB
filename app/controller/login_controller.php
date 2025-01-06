<?php

// Required interface for controllers
require_once(DIRECTORY_CONTROLLERS."/IController.php");

/**
 * Class login_controller
 * Controller responsible for handling user login and registration on the login page.
 */
class login_controller implements IController {

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
     * Show the content for the login page.
     * This method handles user login, registration, and logout.
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

        // Process the form submissions (login or registration)
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                // If the action is 'login', attempt to log the user in
                case 'login':
                    if (isset($_POST['login']) && isset($_POST['password'])) {
                        // Try logging the user in
                        $res = $this->user->login($_POST['login'], $_POST['password']);
                        if ($res) {
                            // If login is successful, log a message and redirect to the main page
                            echo "<script>
                            console.log('User was logged! Good job');</script>";
                            header("Location: index.php?page=main");
                            exit;
                        } else {
                            // If login fails, show an error message
                            echo "<script>alert('Špatné jméno nebo heslo');</script>";
                        }
                    }
                    break;

                // If the action is 'register', attempt to register the user
                case 'register':
                    // Register the user in the database with the provided details
                    $res = $this->db->add_user(
                        $_POST['login'],
                        $_POST['name'],
                        $_POST['surname'],
                        $_POST['email'],
                        intval($_POST['phone']),
                        password_hash($_POST['password'], PASSWORD_BCRYPT),
                        $_POST['address'],
                        1
                    );

                    // If registration is successful, log a message and redirect to the main page
                    if ($res) {
                        echo "<script>console.log('User was logged! Good job');</script>";
                        header("Location: index.php?page=main");
                        exit;
                    } else {
                        // If registration fails, log an error message
                        echo "<script>console.log('ERROR: User was not logged');</script>";
                    }
                    break;
            }
        }

        // Capture the output of the login page and return it
        ob_start();
        require(DIRECTORY_VIEWS ."/login.php");
        $page_content = ob_get_clean(); // Store the captured HTML content

        return $page_content; // Return the page content
    }
}
?>
