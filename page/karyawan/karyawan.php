<?php
require_once '../class/karyawan.php';
$karyawan = new Karyawan();
$data = $karyawan->getAllKaryawan();
$no = 1;
if(isset($_GET['delete_karyawan'])) {
    $id_karyawan = $_GET['id_karyawan'];
    $eksekusi = $karyawan->deleteKaryawan($id_karyawan);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menghapus Karyawan', 'dashboard.php?page=karyawan')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menghapus Karyawan', 'dashboard.php?page=karyawan')};</script>";
    }
}
?>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Karyawan</h3>
            <small class="text-muted">Kelola data karyawan</small>
        </div>

        <a href="?page=add_karyawan" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Karyawan
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Karyawan</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($data as $row){ ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_karyawan']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td class="text-center">
                            <a href="?page=edit_karyawan&id_karyawan=<?= $row['id_karyawan']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php
                            if ($karyawan->cekRelasiTransaksi($row['id_karyawan']) > 0) {
                            ?>
                            <a class="btn btn-danger btn-sm disabled" href="#"><i class="bi bi-trash"></i></a>
                            <?php
                            } else {
                            ?>
                            <a onclick="showConfirm('warning','Peringatan!','Apakah kamu yakin ingin menghapus karyawan ini?','?page=karyawan&delete_karyawan&id_karyawan=<?= $row['id_karyawan']; ?>')"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>
    </div>

</div>