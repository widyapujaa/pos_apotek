<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
require_once '../class/dashboard.php';
require_once '../class/control.php';

//Membuat object Control
$control = new Control();

// Membuat object Dashboard
$dashboard = new Dashboard();

// Mengambil seluruh data statistik dashboard
$totalObat       = $dashboard->totalObat();
$totalSupplier   = $dashboard->totalSupplier();
$totalUser       = $dashboard->totalUser();
$totalKaryawan   = $dashboard->totalKaryawan();
$totalPelanggan  = $dashboard->totalPelanggan();
$totalTransaksi  = $dashboard->totalTransaksi();
$stokMenipis     = $dashboard->totalStokMenipis();

// Mengambil daftar obat dengan stok menipis
$dataStok = $dashboard->getStokMenipis();

// Mengambil aktivitas transaksi terbaru (Admin & Stocker)
$aktivitas = $dashboard->aktivitasTerbaru();

// Mengambil transaksi terbaru (khusus Kasir)
$transaksiTerbaru = $dashboard->transaksiTerbaru();
?>

<div class="container-fluid p-4">

    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Dashboard
            </h3>

            <!-- Menampilkan username dan role user yang sedang login -->
            <small class="text-muted">

                Selamat datang,

                <b><?= htmlspecialchars($_SESSION['username']) ?></b>

                <span class="badge bg-primary">
                    <?= ucfirst($_SESSION['role']) ?>
                </span>

            </small>

        </div>

        <div class="text-end">

            <h6 class="mb-0">
                <?= date("d F Y"); ?>
            </h6>

            <small class="text-muted">
                <?= date("H:i"); ?>
            </small>

        </div>

    </div>

    <!-- CARD DASHBOARD ADMIN -->
    <?php if ($control->isAllowed(['Admin'])) { ?>

        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <a href="?page=obat">
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon bg-obat">
                                <i class="bi bi-capsule-pill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="card-title-dashboard">Total Obat</div>
                                <h2 class="card-value-dashboard text-primary"><?= $totalObat ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <a href="?page=supplier">
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon bg-supplier">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="ms-3">
                                <div class="card-title-dashboard">Total Supplier</div>
                                <h2 class="card-value-dashboard text-success"><?= $totalSupplier ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <a href="?page=karyawan">
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon bg-karyawan">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ms-3">
                                <div class="card-title-dashboard">Total Karyawan</div>
                                <h2 class="card-value-dashboard text-info"><?= $totalKaryawan ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <a href="?page=pelanggan">
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon bg-pelanggan">
                                <i class="bi bi-person-heart"></i>
                            </div>
                            <div class="ms-3">
                                <div class="card-title-dashboard">Total Pelanggan</div>
                                <h2 class="card-value-dashboard text-purple"><?= $totalPelanggan ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <a href="?page=user">
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon bg-user">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="ms-3">
                                <div class="card-title-dashboard">Total User</div>
                                <h2 class="card-value-dashboard text-warning"><?= $totalUser ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card dashboard-card h-100 border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-warning-card">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Stok Menipis</div>
                            <h2 class="card-value-dashboard text-danger"><?= $stokMenipis ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

    <!-- CARD DASHBOARD STOCKER -->
    <?php if ($control->isAllowed(['Stocker'])) { ?>

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-obat">
                            <i class="bi bi-capsule-pill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Total Obat</div>
                            <h2 class="card-value-dashboard text-primary"><?= $totalObat ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-supplier">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Total Supplier</div>
                            <h2 class="card-value-dashboard text-success"><?= $totalSupplier ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-warning-card">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Stok Menipis</div>
                            <h2 class="card-value-dashboard text-danger"><?= $stokMenipis ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

    <!-- CARD DASHBOARD KASIR -->
    <?php if ($control->isAllowed(['Kasir'])) { ?>

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-obat">
                            <i class="bi bi-capsule-pill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Total Obat</div>
                            <h2 class="card-value-dashboard text-primary"><?= $totalObat ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-pelanggan">
                            <i class="bi bi-person-heart"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Total Transaksi</div>
                            <h2 class="card-value-dashboard text-purple"><?= $totalTransaksi ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-pelanggan">
                            <i class="bi bi-person-heart"></i>
                        </div>
                        <div class="ms-3">
                            <div class="card-title-dashboard">Total Pelanggan</div>
                            <h2 class="card-value-dashboard text-purple"><?= $totalPelanggan ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

    <!-- Tabel Dashboard Admin & Stocker -->
    <?php if ($control->isAllowed(['Admin', 'Stocker'])) { ?>

        <!-- Informasi Dashboard -->
        <div class="row">

            <!-- Daftar Obat Stok Menipis -->
            <div class="col-lg-8 mb-4">

                <div class="card dashboard-card dashboard-table h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            Daftar obat dengan stok menipis
                        </span>

                        <?php if ($control->isAllowed(['Stocker'])) { ?>
                            <a href="?page=add_obat" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Obat
                            </a>
                        <?php } ?>


                    </div>

                    <div class="card-body">

                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>

                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th width="90">Stok</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (count($dataStok) > 0) { ?>
                                    <?php foreach ($dataStok as $row) { ?>

                                        <tr>
                                            <!-- Menggunakan htmlspecialchars() untuk mencegah XSS -->
                                            <td><?= htmlspecialchars($row['nama_obat']) ?></td>
                                            <td><?= htmlspecialchars($row['kategori_obat']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                                            <td>
                                                <span class="badge bg-danger badge-stok">

                                                    <?= $row['stok_obat'] ?>
                                                </span>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>
                                        <td colspan="4" class="text-center text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Semua stok masih aman
                                        </td>

                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <i class="bi bi-clock-history text-primary"></i>
                        Transaksi Terbaru

                    </div>

                    <div class="card-body p-0">

                        <table class="table table-hover mb-0">

                            <tbody>

                                <?php if (count($aktivitas) > 0) { ?>
                                    <?php foreach ($aktivitas as $row) { ?>

                                        <tr>
                                            <td>
                                                <strong>

                                                    <?= htmlspecialchars($row['nama_pelanggan']) ?>

                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    Membeli
                                                    <span class="text-primary">
                                                        <?= htmlspecialchars($row['nama_obat']) ?>
                                                    </span>

                                                    sebanyak

                                                    <b><?= $row['jumlah'] ?></b>

                                                </small>

                                            </td>

                                            <td class="text-end">

                                                <small class="text-muted">
                                                    <?= date("d/m/Y", strtotime($row['tgl_transaksi'])) ?>
                                                </small>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>

                                        <td class="text-center text-muted p-4">
                                            Belum ada transaksi.
                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Tabel Dashboard Kasir -->
    <?php if ($control->isAllowed(['Kasir'])) { ?>

        <!-- Informasi Dashboard -->
        <div class="row">

            <!-- Transaksi Terbaru (Kasir) -->
            <div class="col-lg-8 mb-4">
                <div class="card dashboard-card dashboard-table h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-clock-history text-primary"></i>
                            Transaksi Terbaru
                        </span>

                        <a href="?page=add_transaksi" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Transaksi
                        </a>
                    </div>

                    <div class="card-body">

                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Kategori Pelanggan</th>
                                    <th>Nama Kasir</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (count($transaksiTerbaru) > 0) { ?>
                                    <?php foreach ($transaksiTerbaru as $row) { ?>

                                        <tr>
                                            <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                            <td><?= date("d/m/Y H:i", strtotime($row['tgl_transaksi'])) ?></td>
                                            <td><?= htmlspecialchars($row['kategori_pelanggan']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_karyawan']) ?></td>
                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>
                                        <td colspan="4" class="text-center text-muted p-4">
                                            Belum ada transaksi.
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Daftar Obat Stok Menipis -->
            <div class="col-lg-4 mb-4">
                <div class="card dashboard-card dashboard-table h-100">
                    <div class="card-header">
                        <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                        Daftar Obat dengan Stok Menipis
                    </div>

                    <div class="card-body">

                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th width="90">Stok</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (count($dataStok) > 0) { ?>
                                    <?php foreach ($dataStok as $row) { ?>

                                        <tr>
                                            <!-- Menggunakan htmlspecialchars() untuk mencegah XSS -->
                                            <td><?= htmlspecialchars($row['nama_obat']) ?></td>
                                            <td><?= htmlspecialchars($row['kategori_obat']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                                            <td>
                                                <span class="badge bg-danger badge-stok">

                                                    <?= $row['stok_obat'] ?>
                                                </span>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>
                                        <td colspan="4" class="text-center text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Semua stok masih aman
                                        </td>

                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
</div>