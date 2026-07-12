<?php
if (!defined('AKSES_DASHBOARD')) {
    header("Location: /pos_apotek/page/login.php");
}
include_once '../class/control.php';
$control = new Control();
$control->aksesHalaman(['Admin','Stocker']);
require_once '../class/obat.php';
require_once '../class/supplier.php';

// Membuat object Obat dan Supplier
$obat = new Obat();
$supplier = new Supplier();

// Mengambil ID obat yang akan diedit
$id_obat = $_GET['id_obat'];

// Mengambil data obat berdasarkan ID
$data_obat = $obat->getObatById($id_obat);

// Mengambil seluruh data supplier
// untuk ditampilkan pada dropdown
$dataSupplier = $supplier->getAllSupplier();

// Proses Edit Data Obat
if (isset($_POST['edit_obat'])) {

    // Mengambil data dari form
    $id_supplier   = $_POST['id_supplier'];
    $nama_obat     = $_POST['nama_obat'];
    $kategori_obat = $_POST['kategori_obat'];
    $stok_obat     = $_POST['stok_obat'];
    $harga_obat    = $_POST['harga_obat'];

    // Menjalankan proses update data
    $eksekusi = $obat->updateObat(
        $id_obat,
        $id_supplier,
        $nama_obat,
        $kategori_obat,
        $stok_obat,
        $harga_obat
    );

    // Menampilkan notifikasi hasil update
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Memperbarui Obat', 'dashboard.php?page=obat')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Memperbarui Obat', 'dashboard.php?page=obat')};</script>";
    }

}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h4 class="mb-0">
                Edit Obat
            </h4>
        </div>

        <div class="card-body">

            <!-- Form Edit Obat -->
            <form action="dashboard.php?page=edit_obat&id_obat=<?= $id_obat ?>" method="POST">

                <!-- Pilih Supplier -->
                <div class="mb-3">

                    <label class="form-label">
                        Nama Supplier
                    </label>

                    <select name="id_supplier" class="form-select" required>

                        <option value="">
                            -- Pilih Supplier --
                        </option>

                        <?php foreach($dataSupplier as $row){ ?>

                        <!-- Menampilkan seluruh supplier -->
                        <option value="<?= $row['id_supplier']; ?>"
                            <?php if($row['id_supplier'] == $data_obat['id_supplier']) { echo 'selected'; } ?>>

                            <?= htmlspecialchars($row['nama_perusahaan']); ?>
                        </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Input Nama Obat -->
                <div class="mb-3">
                    <label class="form-label">
                        Nama Obat
                    </label>

                    <input type="text" name="nama_obat" class="form-control" placeholder="Masukkan Nama Obat" required
                        value="<?= htmlspecialchars($data_obat['nama_obat']) ?>">
                </div>

                <!-- Pilih Kategori Obat -->
                <div class="mb-3">

                    <label class="form-label">
                        Kategori Obat
                    </label>

                    <select name="kategori_obat" class="form-select" required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <option value="Obat Bebas"
                            <?php if($data_obat['kategori_obat'] == 'Obat Bebas') echo 'selected'; ?>>
                            Obat Bebas
                        </option>

                        <option value="Obat Keras"
                            <?php if($data_obat['kategori_obat'] == 'Obat Keras') echo 'selected'; ?>>
                            Obat Keras
                        </option>

                        <option value="Obat Bebas Terbatas"
                            <?php if($data_obat['kategori_obat'] == 'Obat Bebas Terbatas') echo 'selected'; ?>>
                            Obat Bebas Terbatas
                        </option>

                    </select>

                </div>

                <!-- Input Jumlah Stok -->
                <div class="mb-3">
                    <label class="form-label">
                        Stok Obat
                    </label>

                    <input type="number" name="stok_obat" class="form-control" placeholder="Masukkan Stok Obat" required
                        value="<?= $data_obat['stok_obat'] ?>">
                </div>

                <!-- Input Harga Obat -->
                <div class="mb-3">
                    <label class="form-label">
                        Harga Obat
                    </label>

                    <input type="number" name="harga_obat" class="form-control" placeholder="Masukkan Harga Obat"
                        required value="<?= $data_obat['harga_obat'] ?>">
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">

                    <!-- Kembali ke halaman Obat -->
                    <a href="?page=obat" class="btn btn-secondary">
                        Kembali
                    </a>

                    <!-- Menyimpan perubahan data -->
                    <button type="submit" name="edit_obat" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>