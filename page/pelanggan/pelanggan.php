<?php
require_once '../class/pelanggan.php';
$pelanggan = new Pelanggan();
$data = $pelanggan->getAllPelanggan();

// Keyword pencarian
$keyword = "";

// Proses Pencarian Pelanggan
if (isset($_GET['keyword'])) {

    $keyword = trim($_GET['keyword']);

    // Jika textbox tidak kosong lakukan pencarian
    if ($keyword != "") {

        $data = $pelanggan->searchPelanggan($keyword);
    } else {

        // Jika textbox kosong tampilkan seluruh data
        $data = $pelanggan->getAllPelanggan();
    }
}

$no = 1;
if(isset($_GET['delete_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    $eksekusi = $pelanggan->deletePelanggan($id_pelanggan);
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menghapus Pelanggan', 'dashboard.php?page=pelanggan')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menghapus Pelanggan', 'dashboard.php?page=pelanggan')};</script>";
    }
}
?>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Pelanggan</h3>
            <small class="text-muted">Kelola data pelanggan</small>
        </div>

        <div class="d-flex align-items-center">

            <!-- Tombol Tambah Pelanggan -->
            <a href="?page=add_pelanggan"
                class="btn btn-success me-3">

                <i class="bi bi-plus-circle"></i>
                Tambah Pelanggan

            </a>

            <!-- Tombol Export PDF -->
            <a href="../export/export_pelanggan.php"
                target="_blank"
                class="btn btn-danger me-3">

                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF

            </a>

            <!-- Search Pelanggan -->
            <form method="GET" class="position-relative">

                <input
                    type="hidden"
                    name="page"
                    value="pelanggan">

                <input
                    type="text"
                    id="searchInput"
                    name="keyword"
                    class="form-control ps-5 pe-5"
                    placeholder="Cari pelanggan..."
                    value="<?= htmlspecialchars($keyword); ?>"
                    style="width:240px;border-radius:20px;">

                <!-- Icon Search -->
                <i class="bi bi-search position-absolute"
                    style="left:18px; top:50%;transform:translateY(-50%);color:#6c757d;">
                </i>

                <?php if ($keyword != "") { ?>

                    <!-- Tombol Reset -->
                    <a href="?page=pelanggan"
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
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($data as $row){ ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td class="text-center">
                            <a href="?page=edit_pelanggan&id_pelanggan=<?= $row['id_pelanggan']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php
                            if ($pelanggan->cekRelasiTransaksi($row['id_pelanggan']) > 0) {
                            ?>
                            <a class="btn btn-danger btn-sm disabled" href="#"><i class="bi bi-trash"></i></a>
                            <?php
                            } else {
                            ?>
                            <a onclick="showConfirm('warning','Peringatan!','Apakah kamu yakin ingin menghapus pelanggan ini?','?page=pelanggan&delete_pelanggan&id_pelanggan=<?= $row['id_pelanggan']; ?>')"
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