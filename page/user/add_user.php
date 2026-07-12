<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin']);
require_once '../class/user.php';
require_once '../class/karyawan.php';
require_once '../config/Mailer.php';
$user = new User();
$dataKaryawan = $user->getKaryawan();

if (isset($_POST['add_user'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password_default = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789"), 0, 8);
    $password = password_hash($password_default, PASSWORD_DEFAULT);
    $eksekusi = $user->addUser($username,$password,$role,$id_karyawan);
    if ($eksekusi) {
        $mailer = new Mailer();
        $karyawan = new Karyawan();
        $karyawan = $karyawan->getKaryawanById($id_karyawan);
        $mailer->SendAccountInfo($karyawan['email'], $karyawan['nama_karyawan'], $username, $password_default);
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menambahkan User', 'dashboard.php?page=user')};</script>";
    }
    else {
        $pesan = addslashes($user->getError());
        echo"<script>window.onload = function() {showAlert('error','Gagal', '$pesan', 'dashboard.php?page=add_user')};</script>";
    }
    
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0">Tambah User</h4>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=add_user" method="POST">

                <div class="mb-3">
                    <label class="form-label">Karyawan</label>
                    <select name="id_karyawan" class="form-select" required>
                        <option value="">-- Pilih Karyawan --</option>

                        <?php while($row = mysqli_fetch_assoc($dataKaryawan)){ ?>
                        <option value="<?= $row['id_karyawan']; ?>">
                            <?= $row['nama_karyawan']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username"
                        minlength="5" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Kasir">Kasir</option>
                        <option value="Stocker">Stocker</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=user" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" name="add_user" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>