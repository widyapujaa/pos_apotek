<?php
require_once '../class/transaksi.php';
$transaksi = new Transaksi();
$id_transaksi = $_GET['id_transaksi'];
$data = $transaksi->getTransaksiById($id_transaksi);
$detail = $transaksi->getDetailByTransaksi($id_transaksi);
$no = 1;
?>
<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Detail Transaksi</h3>
            <small class="text-muted">Rincian data transaksi</small>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <small class="text-muted d-block">Tanggal Transaksi</small>
                    <div class="fw-semibold"><?= $data['tgl_transaksi']; ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Kategori Pelanggan</small>
                    <div class="fw-semibold"><?= $data['kategori_pelanggan']; ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Nama Kasir</small>
                    <div class="fw-semibold"><?= $data['nama_karyawan']; ?></div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Nama Pelanggan</small>
                    <div class="fw-semibold"><?= $data['nama_pelanggan']; ?></div>
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($detail as $row){ ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_obat']; ?></td>
                        <td><?= $row['jumlah']; ?></td>
                        <td><?= number_format($row['harga_obat'],0,',','.'); ?></td>
                        <td><?= number_format($row['sub_total'],0,',','.'); ?></td>
                    </tr>

                    <?php } ?>

                    <tr class="table-light">
                        <th colspan="4">Total Bayar</th>
                        <th><?= number_format($data['total'],0,',','.'); ?></th>
                    </tr>
                    <tr class="table-light">
                        <th colspan="4">Bayar</th>
                        <th><?= number_format($data['bayar'],0,',','.'); ?></th>
                    </tr>
                    <tr class="table-light">
                        <th colspan="4">Kembalian</th>
                        <th><?= number_format($data['kembalian'],0,',','.'); ?></th>
                    </tr>

                </tbody>

            </table>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="?page=transaksi" class="btn btn-secondary">
                    Kembali
                </a>

                <a href="../export/cetak_struk.php?id_transaksi=<?= $id_transaksi ?>" target="_blank"
                    class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak
                </a>
            </div>

        </div>

    </div>

</div>