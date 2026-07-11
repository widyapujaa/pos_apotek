<?php
require_once '../class/karyawan.php';
$karyawan = new Karyawan();

// Logic
if (isset($_POST['add_karyawan'])) {
    $nama_karyawan = $_POST['nama_karyawan'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $eksekusi = $karyawan->createKaryawan($nama_karyawan, $email, $no_telepon, $alamat);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menambahkan Karyawan', 'dashboard.php?page=karyawan')};</script>";
    } else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menambahkan Karyawan', 'dashboard.php?page=karyawan')};</script>";
    }
    
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0">Tambah Karyawan</h4>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=add_karyawan" method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" placeholder="Masukkan Nama Karyawan"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" placeholder="Masukkan No Telepon"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat" required></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=karyawan" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" name="add_karyawan" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>