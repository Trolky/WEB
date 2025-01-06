<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/account.css">
    <link rel="stylesheet" href="styles/forms.css">

    <title>Space Games</title>
</head>
<body class="bg-dark">
<?php
global $data, $roles, $users;
?>

<header class="bg-dark" id="header">
    <?php
    require("header.php");
    $createHeader = new \components\header();
    $createHeader->getHeader();
    ?>
</header>

<section class="screen d-flex align-content-center flex-column container body-white signup form-peice">
    <h1 class="title">Osobní údaje</h1>
    <div class="d-flex justify-content-center">
        <form action="" method="POST" enctype="multipart/form-data" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'"
              autocomplete="off" class="signup-form">
            <input type="hidden" name="user_id" value="">
            <table class="">
                <tr>
                    <td>Login:</td>
                    <td><?php echo $users['login']; ?></td>
                </tr>
                <tr>
                    <td>Současné heslo:</td>
                    <td><input type="password" name="last_password" required></td>
                </tr>
                <tr>
                    <td>Nové heslo:</td>
                    <td><input type="password" name="password" id="pas1"></td>
                </tr>
                <tr>
                    <td>Ověření hesla:</td>
                    <td><input type="password" name="password2" id="pas2"></td>
                </tr>
                <tr>
                    <td>Je v pořádku:</td>
                    <td>
                        <output name="x" for="pas1 pas2"></output>
                    </td>
                </tr>
                <tr>
                    <td>Jméno:</td>
                    <td><input type="text" name="name" value="<?php echo $users['name']; ?>" required></td>
                </tr>
                <tr>
                    <td>Přijmění:</td>
                    <td><input type="text" name="surname" value="<?php echo $users['surname']; ?>" required></td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="email" name="email" value="<?php echo $users['email']; ?>" required></td>
                </tr>
                <tr>
                    <td>Telefonní číslo:</td>
                    <td><input type="number" name="phone" value="<?php echo $users['phone_number']; ?>" required></td>
                </tr>
                <tr>
                    <td>Právo:</td>
                    <td><?php echo $roles[0]['role_name']; ?></td>
                </tr>
                <!-- Avatar Upload Section -->
                <tr>
                    <td>Avatar:</td>
                    <td>
                        <input type="file" name="avatar" id="avatar" accept="image/*">
                        <!-- Avatar Image Preview -->
                        <div id="avatar-preview">
                            <img src="avatar.jpg" alt="Avatar" id="avatar-image" class="img-fluid" style="max-width: 100px;">
                        </div>
                    </td>
                </tr>
            </table>

            <input type="submit" name="potvrzeni" value="Upravit osobní údaje">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        // Show image preview on file selection
        $(document).ready(function() {
            $('#avatar').change(function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-image').attr('src', e.target.result);
                    $('#avatar-preview').show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>

</section>
</body>
</html>
