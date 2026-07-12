<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
require_once '../class/control.php';
$control = new Control();
$control->cekLogin();
require_once '../class/user.php';
$userModel = new User();

$id_karyawan = $_SESSION['id_karyawan'];
$profil = $userModel->getProfilById($id_karyawan);

// UPDATE DATA DIRI
if (isset($_POST['update_profil'])) {
    $email = trim($_POST['email']);
    $no_telepon = trim($_POST['no_telepon']);
    $alamat = trim($_POST['alamat']);

    if ($email === '' || $no_telepon === '' || $alamat === '') {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Semua field wajib diisi', 'dashboard.php?page=edit_profil')};</script>";
    } else {
        $berhasil = $userModel->updateProfil($id_karyawan, $email, $no_telepon, $alamat);
        if ($berhasil) {
            echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Profil berhasil diperbarui', 'dashboard.php?page=profil')};</script>";
        } else {
            echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal memperbarui profil', 'dashboard.php?page=edit_profil')};</script>";
        }
    }
}

//  UBAH PASSWORD
if (isset($_POST['update_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password_lama === '' || $password_baru === '' || $konfirmasi_password === '') {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Semua field password wajib diisi', 'dashboard.php?page=edit_profil')};</script>";

    } elseif ($password_baru !== $konfirmasi_password) {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Konfirmasi password tidak cocok', 'dashboard.php?page=edit_profil')};</script>";

    } else {
        $berhasil = $userModel->updatePassword($id_karyawan, $password_lama, $password_baru);
        if ($berhasil) {
            $userModel->logout();
            echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Password berhasil diperbarui Silahkan Login Ulang', 'login.php')};</script>";
        } else {
            $pesan = addslashes($userModel->getError());
            echo "<script>window.onload = function() {showAlert('error','Gagal', '$pesan', 'dashboard.php?page=edit_profil')};</script>";
        }
    }
}
?>

<div class="container-fluid p-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-0">Edit Profil</h3>
        <small class="text-muted">Kelola data akun Anda</small>
    </div>

    <div class="row">
        <!--  Card Data Diri  -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Data Diri</h5>
                </div>
                <div class="card-body">

                    <form action="dashboard.php?page=edit_profil" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($profil['username']); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($profil['nama_karyawan']); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($profil['role']); ?>"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($profil['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control"
                                value="<?= htmlspecialchars($profil['no_telepon']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"
                                required><?= htmlspecialchars($profil['alamat']); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="?page=profil" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" name="update_profil" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                        </div>


                    </form>

                </div>
            </div>
        </div>

        <!--  Card Ganti Password  -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ganti Password</h5>
                </div>
                <div class="card-body">

                    <form action="dashboard.php?page=edit_profil" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" minlength="8" required>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" class="form-control" minlength="8"
                                required>
                        </div>

                        <button type="submit" name="update_password" class="btn btn-warning">
                            <i class="bi bi-key"></i> Ubah Password
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>