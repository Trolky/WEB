<?php
/** Adresa serveru. */
define("DB_SERVER","localhost");
/** Nazev databaze. */
define("DB_NAME","mydb");
/** Uzivatel databaze. */
define("DB_USER","root");
/** Heslo uzivatele databaze */
define("DB_PASS","");

/** Tabulka s categoriemi. */
define("TABLE_CATEGORY", "category");
/** Tabulka s uzivateli. */
define("TABLE_CUSTOMER", "customer");
/** Tabulka s objednávkami. */
define("TABLE_ORDER", "order");
/** Tabulka se statusem objednavky. */
define("TABLE_ORDER_STATUS", "order_status");
/** Tabulka s produktami. */
define("TABLE_PRODUCT", "product");
/** Tabulka s rolemi. */
define("TABLE_ROLES", "roles");



/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "controller";
/** Adresar modelu. */
const DIRECTORY_MODELS = "model";
/** Adresar pohledů */
const DIRECTORY_VIEWS = "views";

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "main";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    "main" => array(
        "title" => "Space Games",

        "file_name" => "main_controller.php",
        "class_name" => "main_controller",
    ),

    "login" => array(
        "title" => "Registrace",

        "file_name" => "login_controller.php",
        "class_name" => "login_controller"
    ),
    "cart" => array(
        "title" => "Nákupní košík",

        "file_name" => "cart_controller.php",
        "class_name" => "cart_controller",
    ),

    "games" => array(
        "title" => "hry",

        "file_name" => "games_controller.php",
        "class_name" => "games_controller",
    ),

    "account" => array(
        "title" => "Profil",

        "file_name" => "account_controller.php",
        "class_name" => "account_controller",
    ),

    "users" => array(
        "title" => "Správa uživatelů",

        "file_name" => "users_controller.php",
        "class_name" => "users_controller",
    ),

    "warehouse" => array(
        "title" => "Sklad",

        "file_name" => "warehouse_controller.php",
        "class_name" => "warehouse_controller",
    ),

    "new_product" => array(
        "title" => "Přidání produktu",

        "file_name" => "add_product_controller.php",
        "class_name" => "add_product_controller",
    ),
);
?>
