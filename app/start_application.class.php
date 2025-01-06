<?php

class start_application {

    public function __construct(){
        require_once(DIRECTORY_CONTROLLERS."/IController.php");
    }

    public function start_app(){
        if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
            $page_key = $_GET["page"];
        } else {
            $page_key = DEFAULT_WEB_PAGE_KEY;
        }
        $page = WEB_PAGES[$page_key];
        require_once(DIRECTORY_CONTROLLERS ."/". $page["file_name"]);
        $controller = new $page["class_name"];
        echo $controller->show($page["title"]);

    }
}

?>

