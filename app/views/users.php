<head>
<link rel="stylesheet" href="styles/users.css">
<?php
require("head.php");
$createHead = new \components\head();
$createHead->createHead();

global $data, $users, $roles;

?>
</head>
<!DOCTYPE html>
<html lang="cz">
<body class="bg-dark h-full">
<section class=" d-flex flex-column  h-full">
    <header class="" id="header">
        <?php
        require("header.php");
        $createHeader = new \components\header();
        $createHeader->getHeader();
        ?>
    </header>
    <h1 class="title text-white">Správa uživatelů</h1>
    <div class="container-custom">
        <div class="table-responsive-custom">
            <table class="custom-table">
                <thead>
                <tr>
                    <th>Login</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <form method="POST" id="myForm">
                        <tr class="table-row">
                            <td><?php echo $u['login']; ?></td>
                            <td><?php echo $u['name']; ?></td>
                            <td><?php echo $u['surname']; ?></td>
                            <td><?php echo $u['email']; ?></td>
                            <td><?php echo $u['phone_number']; ?></td>
                            <td><?php echo $u['address']; ?></td>
                            <td>
                                <?php
                                // Admin or Superadmin can change roles, but Admin cannot assign Superadmin role
                                $is_admin_or_superadmin = in_array($data["role_id"], [3, 4]);
                                $is_super_admin = $u['ROLES_role_id'] == 4;

                                // Disable role selection for users with lower roles (Customer/Seller), and ensure Admin cannot assign Superadmin
                                if (($is_admin_or_superadmin && $data["role_id"] < $u['ROLES_role_id']) ||
                                    ($data["role_id"] == 3 && $u['ROLES_role_id'] == 4)) {
                                    echo "<select name='role' disabled>";
                                } else {
                                    echo "<select name='role'>";
                                }
                                ?>

                                <!-- Allow role changes, but Admin cannot assign Superadmin role -->
                                <option value="1" <?php echo ($u['ROLES_role_id'] == 1 ? "selected" : ""); ?>>Customer</option>
                                <option value="2" <?php echo ($u['ROLES_role_id'] == 2 ? "selected" : ""); ?>>Seller</option>

                                <!-- Admin can only assign Admin, Seller, or Customer roles to others -->
                                <?php if ($data["role_id"] != 3 || $u['ROLES_role_id'] != 4): ?>
                                    <option value="3" <?php echo ($u['ROLES_role_id'] == 3 ? "selected" : ""); ?>>Admin</option>
                                <?php endif; ?>

                                <!-- Only Superadmin can assign Superadmin role -->
                                <?php if ($data["role_id"] == 4): ?>
                                    <option value="4" <?php echo ($u['ROLES_role_id'] == 4 ? "selected" : ""); ?>>Superadmin</option>
                                <?php endif; ?>

                                </select>
                            </td>
                            <td class="actions">
                                <div>
                                    <div>
                                        <input type="hidden" name="customer_id" value="<?php echo $u['customer_id']; ?>">
                                        <input type="hidden" name="role_id" value="<?php echo $u['ROLES_role_id']; ?>">

                                        <!-- Show delete button only if the logged-in user has the same or lower role -->
                                        <?php if ($data["role_id"] >= $u['ROLES_role_id']): ?>
                                            <input class="btn-delete" type="submit" name="delete" value="Odstranit">
                                        <?php endif; ?>

                                        <!-- The edit button is always visible -->
                                        <input class="btn-edit" type="submit" name="update" value="Upravit">
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
</section>
</body>
</html>