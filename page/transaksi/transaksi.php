<?php
require_once '../class/transaksi.php';
$transaksi = new Transaksi();
$data = $transaksi->getAllTransaksi();
$no = 1;

// Keyword pencarian
$keyword = "";

// Proses Pencarian Pelanggan
if (isset($_GET['keyword'])) {

    $keyword = trim($_GET['keyword']);

    // Jika textbox tidak kosong lakukan pencarian
    if ($keyword != "") {

        $data = $transaksi->searchTransaksi($keyword);
    } else {

        // Jika textbox kosong tampilkan seluruh data
        $data = $transaksi->getAllTransaksi();
    }
}
?>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Transaksi</h3>
            <small class="text-muted">Kelola data transaksi</small>
        </div>

        <div class="d-flex align-items-center">

            <!-- Tombol Tambah Transaksi -->
            <a href="?page=add_transaksi"
                class="btn btn-success me-3">

                <i class="bi bi-plus-circle"></i>
                Tambah Transaksi

            </a>

            <!-- Tombol Export PDF -->
            <a href="../export/export_transaksi.php"
                target="_blank"
                class="btn btn-danger me-3">

                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF

            </a>

            <!-- Search Transaksi -->
            <form method="GET" class="position-relative">

                <input
                    type="hidden"
                    name="page"
                    value="transaksi">

                <input
                    type="text"
                    id="searchInput"
                    name="keyword"
                    class="form-control ps-5 pe-5"
                    placeholder="Cari transaksi..."
                    value="<?= htmlspecialchars($keyword); ?>"
                    style="width:240px;border-radius:20px;">

                <!-- Icon Search -->
                <i class="bi bi-search position-absolute"
                    style="left:18px; top:50%;transform:translateY(-50%);color:#6c757d;">
                </i>

                <?php if ($keyword != "") { ?>

                    <!-- Tombol Reset -->
                    <a href="?page=transaksi"
                        class="position-absolute text-decoration-none"
                        style="right:16px;top:50%;transform:translateY(-50%);color:#999;font-size:18px;line-height:1;"
                        title="Reset Pencarian">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>

                <?php } ?>

            </form>

        </div>
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

<script>
    const searchInput = document.getElementById("searchInput");

    // Auto search setelah user berhenti mengetik 500ms
    searchInput.addEventListener("keyup", function() {

        clearTimeout(this.delay);
        this.delay = setTimeout(() => {

            this.form.submit();

        }, 500);
    });

    // Jika tombol X bawaan browser ditekan
    searchInput.addEventListener("search", function() {
        this.form.submit();
    });
</script>