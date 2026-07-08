<?php
    require_once '../class/obat.php';
    $obat = new Obat();
    $data = $obat->getAllObat();
    $no = 1;
    if(isset($_GET['delete_obat'])) {
        $id_obat = $_GET['id_obat'];
        $eksekusi = $obat->deleteObat($id_obat);
        if ($eksekusi) {
            echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menghapus Obat', 'dashboard.php?page=obat')};</script>";
        } else {
            echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menghapus Obat', 'dashboard.php?page=obat')};</script>";
        }
    }
    ?>

    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Obat</h3>
                <small class="text-muted">Kelola data obat</small>
            </div>

            <a href="?page=add_obat" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Obat
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Stok Obat</th>
                            <th>Harga Obat</th>
                            <th>Supplier</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($data as $row){ ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_obat']; ?></td>
                            <td><?= $row['kategori_obat']; ?></td>
                            <td><?= $row['stok_obat']; ?></td>
                            <td><?= $row['harga_obat']; ?></td>
                            <td><?= $row['nama_perusahaan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_obat&id_obat=<?= $row['id_obat']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a onclick="showConfirm('warning','Peringatan!','Apakah kamu yakin ingin menghapus data ini?','?page=obat&delete_obat&id_obat=<?= $row['id_obat']; ?>')"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>
        </div>

    </div>