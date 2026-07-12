<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin']);
require_once '../class/user.php';
require_once '../config/Mailer.php';
require_once '../class/karyawan.php';
$user = new User();
$dataKaryawan = $user->getKaryawan();
$dataUser = $user->getUserByUsername($_GET['username']);

if (isset($_POST['edit_user'])) {
    $username = $_GET['username'];
    $role = $_POST['role'];
    $eksekusi = $user->updateUser($username, $role);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Mengupdate User', 'dashboard.php?page=user')};</script>";
    }
    else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Mengupdate User', 'dashboard.php?page=user')};</script>";
    }
    
}
if (isset($_GET['reset_password'])) {
    $username = $_GET['username'];
    $password_default = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789"), 0, 8);
    $password = password_hash($password_default, PASSWORD_DEFAULT);
    $eksekusi = $user->ResetPassword($username, $password);
    if ($eksekusi) {
        $mailer = new Mailer();
        $karyawan = new Karyawan();
        $karyawan = $karyawan->getKaryawanById($dataUser['id_karyawan']);
        $mailer->SendResetInfo($karyawan['email'], $karyawan['nama_karyawan'], $username, $password_default);

        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Mereset Password', 'dashboard.php?page=edit_user&username=" . $dataUser['username'] . "')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Mereset Password', 'dashboard.php?page=edit_user&username=" . $dataUser['username'] . "')};</script>";
    }
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit User</h4>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=edit_user&username=<?= $dataUser['username'] ?>" method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" placeholder="Masukkan Nama Karyawan"
                        required disabled value="<?php echo $dataUser['nama_karyawan']; ?>">
                    <input type="hidden" name="id_karyawan" value="<?php echo $dataUser['id_karyawan']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required
                        disabled value="<?php echo $dataUser['username']; ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" <?php if ($dataUser['role'] == 'Admin') { echo 'selected'; } ?>>Admin
                        </option>
                        <option value="Kasir" <?php if ($dataUser['role'] == 'Kasir') { echo 'selected'; } ?>>Kasir
                        </option>
                        <option value="Stocker" <?php if ($dataUser['role'] == 'Stocker') { echo 'selected'; } ?>>
                            Stocker</option>
                    </select>
                </div>
                <div class='mb-4'>
                    <a onclick="showConfirm('warning','Peringatan!','Apakah kamu yakin ingin mereset password?','?page=edit_user&reset_password&username=<?= $dataUser['username']; ?>')"
                        class="btn btn-danger btn-sm"> Reset Password
                    </a>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=user" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" name="edit_user" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>