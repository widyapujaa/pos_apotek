<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin', 'Kasir']);
require_once '../class/pelanggan.php';
$pelanggan = new Pelanggan();
$id_pelanggan = $_GET['id_pelanggan'];
$data_pelanggan = $pelanggan->getPelangganById($id_pelanggan);
if (isset($_POST['edit_pelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $eksekusi = $pelanggan->updatePelanggan($id_pelanggan, $nama_pelanggan, $email, $no_telepon);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Mengupdate Pelanggan', 'dashboard.php?page=pelanggan')};</script>";
    } else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Mengupdate Pelanggan', 'dashboard.php?page=pelanggan')};</script>";
    }
    
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit Pelanggan</h4>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=edit_pelanggan&id_pelanggan=<?= $data_pelanggan['id_pelanggan'] ?>"
                method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan Nama Pelanggan"
                        required value="<?= $data_pelanggan['nama_pelanggan'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required
                        value="<?= $data_pelanggan['email'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" placeholder="Masukkan No Telepon" required
                        value="<?= $data_pelanggan['no_telepon'] ?>">
                </div>


                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=pelanggan" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" name="edit_pelanggan" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>