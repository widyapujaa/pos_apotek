<?php
require_once '../class/supplier.php';

// Constructor
$supplier = new Supplier();
$data = $supplier->getAllSupplier();
$no = 1;
if(isset($_GET['delete_supplier'])) {
    $id_supplier = $_GET['id_supplier'];
    $eksekusi = $supplier->deleteSupplier($id_supplier);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menghapus Supplier', 'dashboard.php?page=supplier')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menghapus Supplier', 'dashboard.php?page=supplier')};</script>";
    }
}
?>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Supplier</h3>
            <small class="text-muted">Kelola data supplier</small>
        </div>

        <a href="?page=add_supplier" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Supplier
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Perusahaan</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($data as $row){ ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_perusahaan']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td class="text-center">
                            <a href="?page=edit_supplier&id_supplier=<?= $row['id_supplier']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php
                            if ($supplier->cekRelasiObat($row['id_supplier']) > 0) {
                            ?>
                            <a class="btn btn-danger btn-sm disabled" href="#"><i class="bi bi-trash"></i></a>
                            <?php
                            } else {
                            ?>
                            <a onclick="showConfirm('warning','Peringatan!','Apakah kamu yakin ingin menghapus supplier ini?','?page=supplier&delete_supplier&id_supplier=<?= $row['id_supplier']; ?>')"
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