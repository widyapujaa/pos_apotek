<?php
require_once '../class/supplier.php';

// Membuat object Supplier
$supplier = new Supplier();

// Mengambil seluruh data supplier
$data = $supplier->getAllSupplier();

// Keyword pencarian
$keyword = "";

// Proses Pencarian Supplier
if (isset($_GET['keyword'])) {

    $keyword = trim($_GET['keyword']);

    // Jika textbox tidak kosong lakukan pencarian
    if ($keyword != "") {

        $data = $supplier->searchSupplier($keyword);
    } else {

        // Jika textbox kosong tampilkan seluruh data
        $data = $supplier->getAllSupplier();
    }
}

// Nomor urut tabel
$no = 1;

// Proses Hapus Data Supplier
if (isset($_GET['delete_supplier'])) {

    $id_supplier = $_GET['id_supplier'];
    $eksekusi = $supplier->deleteSupplier($id_supplier);

    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menghapus Supplier', 'dashboard.php?page=supplier')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menghapus Supplier', 'dashboard.php?page=supplier')};</script>";
    }
}
?>

<div class="container-fluid p-4">

    <!-- Judul Halaman -->
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-0">Supplier</h3>
            <small class="text-muted">Kelola data supplier</small>

        </div>

        <div class="d-flex align-items-center">

            <!-- Tombol Tambah Supplier -->
            <a href="?page=add_supplier"
                class="btn btn-success me-3">

                <i class="bi bi-plus-circle"></i>
                Tambah Supplier

            </a>

            <!-- Tombol Export PDF -->
            <a href="../export/export_supplier.php"
                target="_blank"
                class="btn btn-danger me-3">

                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF

            </a>

            <!-- Search Supplier -->
            <form method="GET" class="position-relative">

                <input
                    type="hidden"
                    name="page"
                    value="supplier">

                <input
                    type="text"
                    id="searchInput"
                    name="keyword"
                    class="form-control ps-5 pe-5"
                    placeholder="Cari supplier..."
                    value="<?= htmlspecialchars($keyword); ?>"
                    style="width:240px;border-radius:20px;">

                <!-- Icon Search -->
                <i class="bi bi-search position-absolute"
                    style="left:18px; top:50%;transform:translateY(-50%);color:#6c757d;">
                </i>

                <?php if ($keyword != "") { ?>

                    <!-- Tombol Reset -->
                    <a href="?page=supplier"
                        class="position-absolute text-decoration-none"
                        style="right:16px;top:50%;transform:translateY(-50%);color:#999;font-size:18px;line-height:1;"
                        title="Reset Pencarian">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>

                <?php } ?>

            </form>

        </div>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <!-- Tabel Daftar Supplier -->
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Perusahaan</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- Menampilkan seluruh data supplier -->
                    <?php if (count($data) > 0) { ?>

                        <?php foreach ($data as $row) { ?>

                            <tr>
                                <td><?= $no++; ?></td>
                                <!-- Menggunakan htmlspecialchars() untuk mencegah XSS -->
                                <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                                <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                                <td><?= htmlspecialchars($row['alamat']); ?></td>

                                <td class="text-center">

                                    <!-- Tombol Edit -->
                                    <a href="?page=edit_supplier&id_supplier=<?= $row['id_supplier']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <?php
                                    // Mengecek apakah supplier masih digunakan oleh data obat
                                    // Jika masih digunakan maka tombol hapus dinonaktifkan
                                    if ($supplier->cekRelasiObat($row['id_supplier']) > 0) {
                                    ?>

                                        <a class="btn btn-danger btn-sm disabled" href="#">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    <?php

                                    } else {

                                    ?>

                                        <!-- Konfirmasi sebelum menghapus supplier -->
                                        <a onclick="showConfirm(
                                'warning',
                                'Peringatan!',
                                'Apakah kamu yakin ingin menghapus supplier ini?',
                                '?page=supplier&delete_supplier&id_supplier=<?= $row['id_supplier']; ?>'
                            )"
                                            class="btn btn-danger btn-sm">

                                            <i class="bi bi-trash"></i>
                                        </a>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted">

                                Data supplier tidak ditemukan.

                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById("searchInput");

    // Auto search setelah user berhenti mengetik 500ms
    searchInput.addEventListener("keyup", function() {

        clearTimeout(this.delay);
        this.delay = setTimeout(() => {

            this.form.submit();

        }, 500);
    });

    // Jika tombol X bawaan browser ditekan
    searchInput.addEventListener("search", function() {
        this.form.submit();
    });
</script>