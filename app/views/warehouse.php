<head>
<link rel="stylesheet" href="styles/warehouse.css">
<?php
require("head.php");
$createHead = new \components\head();
$createHead->createHead();

global $data, $categories, $product;

?>
</head>
<html>
<body class="bg-dark">
<section class="h-full bg-dark">
    <header class="" id="header">
        <?php
        require("header.php");
        $createHeader = new \components\header();
        $createHeader->getHeader();
        ?>
    </header>
    <div class="container-custom">
        <h1 class="title text-white">Sklad</h1>
        <a class="add-btn" href="index.php?page=new_product">Přidat produkt</a>

        <div class="table-responsive-custom">
            <table class="custom-table">
                <thead>
                <tr>
                    <th>Jméno</th>
                    <th>Cena</th>
                    <th>Množství</th>
                    <th>Kategorie</th>
                    <th>Akce</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($product as $u): ?>
                    <form method="POST" id="myForm">
                        <tr class="table-row">
                            <td>
                                <a href="#" class="product-link">
                                    <input type="hidden" name="product_id" value="<?php echo $u['product_id']; ?>">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="product-name"><?php echo $u['name']; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td><input type="number" name="price" value="<?php echo $u['price']; ?>" class="input-field"></td>
                            <td><input type="number" name="stock" value="<?php echo $u['stock']; ?>" class="input-field"></td>
                            <td>
                                <select name="category_id" class="select-field">
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?php echo $c['category_id']; ?>" <?php echo ($u['CATEGORY_category_id'] == $c['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo $c['genre_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="actions">
                                <div class="dropdown-custom">
                                    <div class="dropdown-menu-custom">
                                        <input type="hidden" name="product_id" value="<?php echo $u['product_id']; ?>">
                                        <input class="btn-edit" type="submit" name="update" value="Upravit">
                                        <input class="btn-delete" type="submit" name="delete" value="Odstranit">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>