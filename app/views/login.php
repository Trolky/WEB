<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/forms.css">
    <title>Space Games</title>
</head>
<body class="bg-dark text-light">
<?php
require("head.php");
$createHead = new \components\head();
$createHead->createHead();

global $data;
?>

<header class="mb-4">
    <?php
    require("header.php");
    $createHeader = new \components\header();
    $createHeader->getHeader();
    ?>
</header>

<div class="container">
    <section id="formHolder" class="py-5">

        <div class="row justify-content-center">
            <!-- Form Box -->
            <div class="col-md-6 form bg-dark text-light p-4 rounded shadow-lg">

                <!-- Login Form -->
                <div class="login form-piece switched">
                    <form class="login-form" action="" method="post">
                        <div class="form-group mb-3">
                            <label for="login">Login jméno</label>
                            <input type="text" name="login" id="login" class="form-control login" required>
                            <span class="error text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="loginPassword">Heslo</label>
                            <input type="password" name="password" id="loginPassword" class="form-control pass" required>
                            <span class="error text-danger"></span>
                        </div>

                        <div class="CTA">
                            <input type="hidden" name="action" value="login">
                            <input type="submit" name="submit" value="Přihlásit se" id="submit" class="btn btn-primary w-100">
                        </div>
                    </form>
                </div>

                <!-- Signup Form -->
                <div class="signup form-piece">
                    <form class="signup-form" action="#" method="post">
                        <div id="first-forms">
                            <div class="form-group mb-3">
                                <label for="name">Login jméno</label>
                                <input type="text" name="login" id="login" class="form-control login" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">Jméno</label>
                                <input type="text" name="name" id="name" class="form-control name" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="surname">Přijmení</label>
                                <input type="text" name="surname" id="surname" class="form-control surname" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control email" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">Telefoní číslo</label>
                                <input type="number" name="phone" id="phone" class="form-control number" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Heslo</label>
                                <input type="password" name="password" id="password" class="form-control pass" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="passwordCon">Potvrzení Hesla</label>
                                <input type="password" name="password2" id="passwordCon" class="form-control passConfirm" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="address">Celá adresa</label>
                                <input type="text" name="address" id="address" class="form-control adress" required>
                                <span class="error text-danger"></span>
                            </div>

                            <div class="CTA d-flex justify-content-between">
                                <input type="hidden" name="action" value="register">
                                <input type="submit" value="Registrovat se" id="submit" class="btn btn-success w-100">
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
