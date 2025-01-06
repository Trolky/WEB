<html>
<head>
    <?php
    require("head.php");
    $createHead = new \components\head();
    $createHead->createHead();

    require_once(DIRECTORY_MODELS . "/database.php");
    $this->db = new database();

    global $items, $data;
    $total = 0;
    ?>
    <link rel="stylesheet" href="styles/cart.css">
</head>

<body class="bg-dark">
<header>
    <?php
    require("header.php");
    $createHeader = new \components\header();
    $createHeader->getHeader();
    ?>
</header>

<div class="container mt-5 bg-dark">
    <h1 class="title text-center mb-5 text-white">Košík</h1>
    <div class="shopping-cart">
        <table class="table">
            <thead class="column-labels">
            <tr>
                <th class="product-details">Produkt</th>
                <th class="product-price">Cena</th>
                <th class="product-quantity">Množství</th>
                <th class="product-removal">Odstranit</th>
                <th class="product-line-price">Celkem</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($items as $i) {
                if ($i["ORDER_STATUS_order_status_id"] == 1) {
                    $total += $i["total_price"];
                    $quantity = $i["quantity"] == 0 ? 1 : $i["quantity"];
                    echo "
                    <form method='POST'>
                        <tr class='product'>
                            <td class='product-details'>
                                <div class='product-title'>{$i["product_name"]}</div>
                                <p class='product-description'>{$i["product_description"]}</p>
                            </td>
                            <td class='product-price'>{$i["total_price"]}</td>
                            <td class='product-quantity'>
                                <input type='number' value='{$i["quantity"]}' min='1' max='{$quantity}'>
                            </td>
                            <td class='product-removal'>
                                <input type='hidden' name='cart_id' value='{$i["order_id"]}'>
                                <input type='hidden' name='product_id' value='{$i["product_id"]}'>
                                <input type='submit' name='delete' value='Odstranit' class='remove-product'>
                            </td>
                            <td class='product-line-price'>{$i["total_price"]}</td>
                        </tr>
                    </form>
                    ";
                }
            }
            ?>
            </tbody>
        </table>

        <form method="POST">
            <div class="totals">
                <div class="totals-item">
                    <label>Cena bez DPH</label>
                    <div class="totals-value" id="cart-subtotal"><?= number_format($total, 2) ?> Kč</div>
                </div>
                <div class="totals-item">
                    <label>DPH (21%)</label>
                    <div class="totals-value" id="cart-tax"><?= number_format($total * 0.21, 2) ?> Kč</div>
                </div>
                <div class="totals-item totals-item-total">
                    <label>Celková cena</label>
                    <div class="totals-value" id="cart-total"><?= number_format($total * 1.21, 2) ?> Kč</div>
                    <input type="hidden" name="total" value="<?= $total * 1.21 ?>">
                </div>
            </div>

            <input class="checkout" type="submit" name="buy" value="Zaplatit">
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="views/js/cart.js"></script>
</body>
</html>