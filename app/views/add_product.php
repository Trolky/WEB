<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/add_product.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php
    require("head.php");
    $createHead = new \components\head();
    $createHead->createHead();

    global $data, $categories, $product;

    ?>

</head>

<?php
global $data, $categories;
?>
<body class="bg-dark">
<header class="" id="header">
    <?php
    require("header.php");
    $createHeader = new \components\header();
    $createHeader->getHeader();
    ?>
</header>
<div class="container-custom">
    <section id="formHolder">
        <div class="row">
            <!-- Form Box -->
            <div class="col-sm-12 form-custom">
                <!-- Signup Form -->
                <div class="signup form-piece">
                    <form class="signup" action="#" method="post">
                        <div id="first-forms">
                            <div class="form-group">
                                <label for="name" class="label-custom">Název hry</label>
                                <input type="text" name="product_name" id="name" class="input-custom">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="passwordCon" class="label-custom">Popisek</label>
                                <textarea name="text" id="description" placeholder="Zadejte Váš text" class="input-custom"></textarea>
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="price" class="label-custom">Cena</label>
                                <input type="number" name="price" id="price" class="input-custom">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="label-custom">Množství</label>
                                <input type="number" name="quantity" id="quantity" class="input-custom">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="label-custom">Kategorie</label>
                                <select name="category_id" class="select-custom">
                                    <?php
                                    foreach ($categories as $c) {
                                        echo "<option value='{$c['category_id']}'>{$c['genre_name']}</option>";
                                    }
                                    ?>
                                </select>
                                <span class="error"></span>
                            </div>
                            <div class="form-group-submit">
                                <input type="hidden" name="add" value="register">
                                <input type="submit" value="Přidat" id="submit" name="add" class="btn-submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="views/js/form.js"></script>
</body>
</html>
