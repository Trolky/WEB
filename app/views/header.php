<?php

namespace components;

class Header {
    public static function getHeader() {
        global $data;
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="index.php?page=main" class="navbar-brand">Domů</a>

                <!-- Toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <!-- Category Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategorie
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=1">FPS hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=2">Adventure hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=3">RPG hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=4">MMO hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=5">MMO RPG hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=6">Strategy hry</a></li>
                                <li><a class="dropdown-item" href="index.php?page=games&category_id=7">Survival hry</a></li>
                            </ul>
                        </li>

                        <!-- User Management (admin role) -->
                        <?php if ($data["userLogged"] && in_array($data["role_id"], [3, 4])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=users">Správa uživatelů</a>
                            </li>
                        <?php } ?>

                        <!-- Warehouse (user roles) -->
                        <?php if ($data["userLogged"] && in_array($data["role_id"], [2, 3, 4])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=warehouse">Sklad</a>
                            </li>
                        <?php } ?>
                    </ul>

                    <!-- Cart and User Profile -->
                    <div class="d-flex align-items-center">
                         <?php if ($data["userLogged"]) {?>
                        <a href="index.php?page=cart" class="text-white me-3">
                            <i class="fa-solid fa-basket-shopping nav-icons text-white"></i>
                        </a>
                         <?php } ?>
                        <?php if ($data["userLogged"]) { ?>
                            <a href="index.php?page=account" class="text-white me-3">
                                <i class="fa-solid fa-user nav-icons text-white"></i>
                            </a>

                            <form action="index.php?page=main" method="POST" class="mb-0">
                                <input type="hidden" name="logout" value="logout">
                                <input type="submit" name="potvrzeni" value="Odhlásit" class="btn btn-outline-light">
                            </form>
                        <?php } else { ?>
                            <a href="index.php?page=login" class="nav-link text-white">Registrace/Login</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php
    }
}

?>