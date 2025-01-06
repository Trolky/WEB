<head>
<?php

require("head.php");
$createHead = new \components\head();
$createHead->createHead();

global $data;

?>
</head>
<html>
<body class="bg-dark">
<section class="screen d-flex flex-column">


    <header class="" id="header">
        <?php
        require("header.php");
        $createHeader = new \components\header();
        $createHeader->getHeader();
        ?>
    </header>
    <div class="d-flex flex-column flex-grow-1 justify-content-center align-items-center main-center other">
        <h1 class="title text-white">Přinášíme vám hry snů.</h1>
    </div>
</body>

</html>
