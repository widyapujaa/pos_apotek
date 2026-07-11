<?php
require_once '../class/transaksi.php';
$transaksi = new Transaksi();
$data = $transaksi->getAllTransaksi();
$no = 1;
?>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Transaksi</h3>
            <small class="text-muted">Kelola data transaksi</small>
        </div>

        <a href="?page=add_transaksi" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Karyawan</th>
                        <th>Tgl Transaksi</th>
                        <th>Kategori Pelanggan</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($data as $row){ ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['nama_karyawan']; ?></td>
                        <td><?= $row['tgl_transaksi']; ?></td>
                        <td><?= $row['kategori_pelanggan']; ?></td>
                        <td class="text-center">
                            <a href="?page=detail_transaksi&id_transaksi=<?= $row['id_transaksi']; ?>"
                                class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>
    </div>

</div>