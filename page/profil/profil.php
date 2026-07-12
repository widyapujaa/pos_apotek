<?php
require_once '../class/user.php';
$userModel = new User();
$username= $_SESSION['username'];
$data = $userModel->getUserByUsername($username);
?>

<div class="container-fluid p-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-0">Profil</h3>
        <small class="text-muted">Informasi akun kamu</small>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <small class="text-muted d-block">Username</small>
                    <div class="fw-semibold"><?= htmlspecialchars($data['username']); ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Role</small>
                    <div class="fw-semibold"><?= htmlspecialchars($data['role']); ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Nama</small>
                    <div class="fw-semibold"><?= htmlspecialchars($data['nama_karyawan']); ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">No Telepon</small>
                    <div class="fw-semibold"><?= htmlspecialchars($data['no_telepon']); ?></div>
                </div>
                <div class="col-md-12">
                    <small class="text-muted d-block">Alamat</small>
                    <div class="fw-semibold"><?= htmlspecialchars($data['alamat']); ?></div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="?page=edit_profil" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </a>

            </div>
        </div>

    </div>