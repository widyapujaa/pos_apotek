<?php
session_start();
define('AKSES_DASHBOARD', true);
require_once '../class/page.php';
require_once '../class/user.php';
require_once '../class/control.php';
$control = new Control();
$control->cekLogin();
$page = "home";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$pageView = new Page();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>POS APOTEK</title>
</head>

<body>

    <div class="sidebar">
        <div class="logo">
            <div class="logo-text">
                <h4>POS APOTEK</h4>
            </div>
        </div>

        <ul class="nav flex-column mt-4">

            <li class="nav-item">
                <a href="?page=home" class="nav-link <?= $pageView->activePage('home')?>">
                    <i class="bi bi-house"></i>
                    Dashboard
                </a>
            </li>

            <?php if($control->isAllowed(['Admin'])) { ?>
            <li class="nav-item">
                <a href="?page=karyawan" class="nav-link <?= $pageView->activePage('karyawan')?>">
                    <i class="bi bi-people"></i>
                    Karyawan
                </a>
            </li>
            <?php } ?>

            <?php if($control->isAllowed(['Admin','Kasir'])) { ?>
            <li class="nav-item">
                <a href="?page=pelanggan" class="nav-link">
                    <i class="bi bi-person"></i>
                    Pelanggan
                </a>
            </li>
            <?php } ?>


            <?php if($control->isAllowed(['Admin','Stocker'])) { ?>
            <li class="nav-item">
                <a href="?page=supplier" class="nav-link">
                    <i class="bi bi-truck"></i>
                    Supplier
                </a>
            </li>
            <?php } ?>

            <?php  if($control->isAllowed(['Admin','Stocker'])) { ?>
            <li class="nav-item">
                <a href="?page=obat" class="nav-link">
                    <i class="bi bi-capsule-pill"></i>
                    Obat
                </a>
            </li>
            <?php } ?>

            <?php if($control->isAllowed(['Admin','Kasir'])) { ?>
            <li class="nav-item">
                <a href="?page=transaksi" class="nav-link">
                    <i class="bi bi-cart-check"></i>
                    Transaksi
                </a>
            </li>
            <?php } ?>

            <?php if($control->isAllowed(['Admin'])) { ?>
            <li class="nav-item">
                <a href="?page=user" class="nav-link <?= $pageView->activePage('user')?>">
                    <i class="bi bi-person-circle"></i>
                    User
                </a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a href="?page=profil" class="nav-link <?= $pageView->activePage('profil')?>">
                    <i class="bi bi-person"></i>
                    Profil
                </a>
            </li>

        </ul>

        <div class="logout">
            <a href="../page/logout.php" class="nav-link">
                <i class="bi bi-box-arrow-left"></i>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <?php $pageView->loadPage($page); ?>
    </div>

</body>

</html>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/js.js"></script>