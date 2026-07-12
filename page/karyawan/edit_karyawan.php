<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin']);
require_once '../class/karyawan.php';
$karyawan = new Karyawan();
$id_karyawan = $_GET['id_karyawan'];
$data_karyawan = $karyawan->getKaryawanById($id_karyawan);
if (isset($_POST['edit_karyawan'])) {
    $nama_karyawan = $_POST['nama_karyawan'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $eksekusi = $karyawan->updateKaryawan($id_karyawan, $nama_karyawan, $email, $no_telepon, $alamat);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Mengupdate Karyawan', 'dashboard.php?page=karyawan')};</script>";
    } else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Mengupdate Karyawan', 'dashboard.php?page=karyawan')};</script>";
    }
    
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit Karyawan</h4>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=edit_karyawan&id_karyawan=<?= $data_karyawan['id_karyawan'] ?>"
                method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" placeholder="Masukkan Nama Karyawan"
                        required value="<?= $data_karyawan['nama_karyawan'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required
                        value="<?= $data_karyawan['email'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" placeholder="Masukkan No Telepon" required
                        value="<?= $data_karyawan['no_telepon'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat"
                        required><?= $data_karyawan['alamat'] ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=karyawan" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" name="edit_karyawan" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>