<head>
    <?php
    require("head.php");
    $createHead = new \components\head();
    $createHead->createHead();
    global $data, $product;
    ?>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<html>
<body class="bg-dark">
<section class="section-container bg-dark">
    <header id="header">
        <?php
        require("header.php");
        $createHeader = new \components\Header();
        $createHeader->getHeader();
        ?>
    </header>

    <h1 class="title text-light bg-dark">
        <?php
        switch ($data["category_id"]) {
            case 1: echo "FPS hry"; break;
            case 2: echo "Adventure hry"; break;
            case 3: echo "RPG hry"; break;
            case 4: echo "MMO hry"; break;
            case 5: echo "MMO RPG hry"; break;
            case 6: echo "Strategy hry"; break;
            case 7: echo "Survival hry"; break;
            default: echo "Žánr hry nenalezen";
        }
        ?>
    </h1>

    <div class="grid-container bg-dark">
        <?php
        $logged = isset($_SESSION['user_id']);
        foreach ($product as $p) {
            if ($p["stock"] > 0) {
                echo "
                <form method='POST'>
                    <div class='grid-item'>
                        <div class='card'>
                            <div class='card-header'>
                                <div class='price'>{$p['price']} Kč</div>
                            </div>
                            <div class='card-body'>
                                <h1 class='product-name'><a href='#'>{$p['name']}</a></h1>
                                <p class='text-black'>{$p['description']}</p>
                                <input type='hidden' name='id' value='{$p["product_id"]}'/>
                                <input type='hidden' name='stock' value='{$p["stock"]}'/>
                                <input type='hidden' name='price' value='{$p["price"]}'/>";

                if ($data["userLogged"]) {
                    echo "<input type='submit' name='buy' value='Koupit' class='buy-btn'>";
                }
                            echo "
                        </div>
                    </div>
                </div>
            </form>";
            }
        }
        ?>
    </div>
</section>

<?php
require("footer.php");
$getFooter = new \components\footer();
$getFooter->getFooter();
?>

</body>
</html>
