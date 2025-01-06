<?php

class user_manager{

    private $session_key = "current_key";
    private $db;
    private $sessions;

    public function __construct(){
        require_once("database.php");
        $this->db = new database();

        $this->sessions = session_start();;
    }

    public function login(string $login, string $password): bool{
        $hash = $this->password($login);

        if (!(password_verify($password, $hash) || $hash === $password)) {
            return false;
        }

        $user = $this->db->select_from_db(TABLE_CUSTOMER, "login = '$login' AND password = '$hash'");
        if (!empty($user)) {
            $_SESSION[$this->session_key] = $user[0]['login'];
            return true;
        }

        return false;
    }

    public function password(string $login): string{
        $user = $this->db->select_from_db(TABLE_CUSTOMER, "login = '$login'");
        return !empty($user) ? $user[0]['password'] : '';
    }

    public function logout(){
        unset($_SESSION[$this->session_key]);
    }

    public function is_logged(): bool{
        return isset($_SESSION[$this->session_key]);
    }

    public function get_data(){
        if (!$this->is_logged()) {
            return null;
        }

        $id = $_SESSION[$this->session_key] ?? null;
        if ($id === null) {
            echo "Žádna dáta o uživateli.";
            $this->logout();
            return null;
        }

        $data = $this->db->select_from_db(TABLE_CUSTOMER, "login = '$id'");
        if (empty($data)) {
            echo "Žádna dáta o uživateli.";
            $this->logout();
            return null;
        }

        return $data[0];
    }


}