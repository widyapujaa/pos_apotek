<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin','Stocker']);
require_once '../class/supplier.php';

// Membuat object Supplier
$supplier = new Supplier();

// Proses Tambah Data Supplier
if (isset($_POST['add_supplier'])) {

    // Mengambil data dari form
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $no_telepon      = $_POST['no_telepon'];
    $alamat          = $_POST['alamat'];

    // Menjalankan proses penyimpanan ke database
    $eksekusi = $supplier->createSupplier(
        $nama_perusahaan,
        $no_telepon,
        $alamat
    );

    // Menampilkan notifikasi hasil proses penyimpanan
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menambahkan Supplier', 'dashboard.php?page=supplier')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menambahkan Supplier', 'dashboard.php?page=supplier')};</script>";
    }

}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h4 class="mb-0">
                Tambah Supplier
            </h4>
        </div>

        <div class="card-body">

            <!-- Form Tambah Supplier -->
            <form action="dashboard.php?page=add_supplier" method="POST">

                <!-- Input Nama Perusahaan -->
                <div class="mb-3">
                    <label class="form-label">
                        Nama Perusahaan
                    </label>

                    <input type="text" name="nama_perusahaan" class="form-control"
                        placeholder="Masukkan Nama Perusahaan" required>
                </div>

                <!-- Input Nomor Telepon -->
                <div class="mb-3">
                    <label class="form-label">
                        No Telepon
                    </label>

                    <input type="text" name="no_telepon" class="form-control" placeholder="Masukkan No Telepon"
                        required>
                </div>

                <!-- Input Alamat -->
                <div class="mb-3">
                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat" required></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">

                    <!-- Kembali ke halaman Supplier -->
                    <a href="?page=supplier" class="btn btn-secondary">
                        Kembali
                    </a>

                    <!-- Menyimpan data supplier -->
                    <button type="submit" name="add_supplier" class="btn btn-success">

                        <i class="bi bi-check-circle"></i>
                        Simpan

                    </button>

                </div>

            </form>
        </div>
    </div>
</div>