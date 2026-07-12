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

// Mengambil ID supplier yang dipilih dari URL
$id_supplier = $_GET['id_supplier'];

// Mengambil data supplier berdasarkan ID
$data_supplier = $supplier->getSupplierById($id_supplier);

// Proses Update Data Supplier
if (isset($_POST['edit_supplier'])) {

    // Mengambil data dari form
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $no_telepon      = $_POST['no_telepon'];
    $alamat          = $_POST['alamat'];

    // Menjalankan proses update ke database
    $eksekusi = $supplier->updateSupplier($id_supplier,$nama_perusahaan,$no_telepon,$alamat);

    // Menampilkan notifikasi hasil proses update
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Mengupdate Supplier', 'dashboard.php?page=supplier')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Mengupdate Supplier', 'dashboard.php?page=supplier')};</script>";
    }

}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h4 class="mb-0">
                Edit Supplier
            </h4>
        </div>

        <div class="card-body">

            <!-- Form Edit Supplier -->
            <form action="dashboard.php?page=edit_supplier&id_supplier=<?= $data_supplier['id_supplier'] ?>"
                method="POST">

                <!-- Input Nama Perusahaan -->
                <div class="mb-3">

                    <label class="form-label">
                        Nama Perusahaan
                    </label>

                    <input type="text" name="nama_perusahaan" class="form-control"
                        placeholder="Masukkan Nama Perusahaan" required
                        value="<?= $data_supplier['nama_perusahaan'] ?>">

                </div>

                <!-- Input Nomor Telepon -->
                <div class="mb-3">

                    <label class="form-label">
                        No Telepon
                    </label>

                    <input type="text" name="no_telepon" class="form-control" placeholder="Masukkan No Telepon" required
                        value="<?= $data_supplier['no_telepon'] ?>">

                </div>

                <!-- Input Alamat -->
                <div class="mb-3">

                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat"
                        required><?= $data_supplier['alamat'] ?></textarea>

                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">

                    <!-- Kembali ke halaman Supplier -->
                    <a href="?page=supplier" class="btn btn-secondary">
                        Kembali
                    </a>

                    <!-- Menyimpan perubahan data -->
                    <button type="submit" name="edit_supplier" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>