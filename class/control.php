<?php
class Control {
    public function cekLogin() {
        if (!isset($_SESSION['username'])) {
           header("Location: ../page/login.php");
            exit();
        }
    }

    public function isAllowed($allowedRoles) {
        return in_array($_SESSION['role'], $allowedRoles);
    }
    public function aksesHalaman($allowedRoles) {
        $this->cekLogin();
        if (!$this->isAllowed($allowedRoles)) {
            echo "<script>window.onload = function() {showAlert('error','Akses Ditolak', 'Anda tidak memiliki izin untuk mengakses halaman ini', '../page/dashboard.php?page=home')};</script>";
        }
    }

}