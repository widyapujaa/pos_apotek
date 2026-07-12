<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin','Stocker']);
require_once '../class/obat.php';

// Membuat object Obat
$obat = new Obat();

// Mengambil seluruh data obat
$data = $obat->getAllObat();

// Keyword pencarian
$keyword = "";

// Proses Pencarian Obat
if (isset($_GET['keyword'])) {

    $keyword = trim($_GET['keyword']);

    // Jika textbox tidak kosong lakukan pencarian
    if ($keyword != "") {

        $data = $obat->searchObat($keyword);
    } else {

        // Jika textbox kosong tampilkan seluruh data
        $data = $obat->getAllObat();
    }
}

// Nomor urut tabel
$no = 1;

// Proses Hapus Data Obat
if (isset($_GET['delete_obat'])) {

    $id_obat = $_GET['id_obat'];
    $eksekusi = $obat->deleteObat($id_obat);

    if ($eksekusi) {

        echo "<script>
                window.onload = function(){
                    showAlert(
                        'success',
                        'Berhasil',
                        'Berhasil Menghapus Obat',
                        'dashboard.php?page=obat'
                    )
                };
              </script>";
    } else {

        echo "<script>
                window.onload = function(){
                    showAlert(
                        'error',
                        'Gagal',
                        'Gagal Menghapus Obat',
                        'dashboard.php?page=obat'
                    )
                };
              </script>";
    }
}
?>

<div class="container-fluid p-4">

    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">
                Obat
            </h3>

            <small class="text-muted">
                Kelola data obat
            </small>
        </div>

        <div class="d-flex align-items-center">
            <!-- Tombol Tambah Obat -->
            <a href="?page=add_obat" class="btn btn-success me-3">

                <i class="bi bi-plus-circle"></i>

                Tambah Obat

            </a>

            <!-- Tombol Export PDF -->
            <a href="../export/export_obat.php" target="_blank" class="btn btn-danger me-3">

                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF

            </a>

            <!-- Form Search -->
            <form method="GET" class="position-relative">

                <input type="hidden" name="page" value="obat">

                <input type="text" name="keyword" id="searchInput" class="form-control ps-5 pe-5"
                    placeholder="Cari obat..." autocomplete="off" value="<?= htmlspecialchars($keyword); ?>"
                    style="width:240px;border-radius:20px;">

                <!-- Icon Search -->
                <i class="bi bi-search position-absolute" style="
                        left:18px;
                        top:50%;
                        transform:translateY(-50%);
                        color:#6c757d;
                    ">
                </i>

                <?php if ($keyword != "") { ?>

                <!-- Tombol Reset -->
                <a href="?page=obat" class="position-absolute text-decoration-none" style="
                            right:15px;
                            top:50%;
                            transform:translateY(-50%);
                            color:#999;
                            font-size:18px;
                        ">

                    &times;

                </a>

                <?php } ?>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <!-- Tabel Daftar Obat -->
            <table class="table table-hover align-middle">
                <thead class="table-light">

                    <tr>
                        <th width="60">No</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Supplier</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (count($data) > 0) { ?>
                    <!-- Menampilkan seluruh data obat -->
                    <?php foreach ($data as $row) { ?>

                    <tr>

                        <td><?= $no++; ?></td>
                        <!-- Menggunakan htmlspecialchars() untuk mencegah XSS -->
                        <td><?= htmlspecialchars($row['nama_obat']); ?></td>
                        <td><?= htmlspecialchars($row['kategori_obat']); ?></td>

                        <td>

                            <?php
                                    // Memberikan badge merah apabila stok menipis
                                    if ($row['stok_obat'] < 5) {
                                    ?>

                            <span class="badge bg-danger">

                                <?= $row['stok_obat']; ?>

                            </span>

                            <?php } else { ?>

                            <span class="badge bg-success">

                                <?= $row['stok_obat']; ?>

                            </span>

                            <?php } ?>

                        </td>

                        <!-- Format Rupiah -->
                        <td>
                            Rp <?= number_format($row['harga_obat'], 0, '.', '.'); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama_perusahaan']); ?>
                        </td>

                        <td class="text-center">

                            <!-- Tombol Edit -->
                            <a href="?page=edit_obat&id_obat=<?= $row['id_obat']; ?>" class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <!-- Konfirmasi sebelum menghapus data -->
                            <a onclick="showConfirm(
                                'warning',
                                'Peringatan!',
                                'Apakah kamu yakin ingin menghapus data ini?',
                                '?page=obat&delete_obat&id_obat=<?= $row['id_obat']; ?>'
                            )" class="btn btn-danger btn-sm">

                                <i class="bi bi-trash"></i>

                            </a>
                        </td>
                    </tr>

                    <?php } ?>

                    <?php } else { ?>

                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data obat tidak ditemukan.
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {

    clearTimeout(this.delay);

    this.delay = setTimeout(() => {

        this.form.submit();

    }, 500);

});
</script>