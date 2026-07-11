<?php
require_once '../class/obat.php';
require_once '../class/supplier.php';

// Membuat object Obat dan Supplier
$obat = new Obat();
$supplier = new Supplier();

// Mengambil seluruh data supplier
// untuk ditampilkan pada dropdown
$dataSupplier = $supplier->getAllSupplier();

// Proses Tambah Data Obat
if (isset($_POST['add_obat'])) {

    // Mengambil data dari form
    $id_supplier   = $_POST['id_supplier'];
    $nama_obat     = $_POST['nama_obat'];
    $kategori_obat = $_POST['kategori_obat'];
    $stok_obat     = $_POST['stok_obat'];
    $harga_obat    = $_POST['harga_obat'];

    // Menjalankan proses penyimpanan data
    $eksekusi = $obat->createObat(
        $id_supplier,
        $nama_obat,
        $kategori_obat,
        $stok_obat,
        $harga_obat
    );

    // Menampilkan notifikasi hasil penyimpanan
    if ($eksekusi) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menambahkan Obat', 'dashboard.php?page=obat')};</script>";
    } else {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menambahkan Obat', 'dashboard.php?page=obat')};</script>";
    }

}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h4 class="mb-0">
                Tambah Obat
            </h4>
        </div>

        <div class="card-body">

            <!-- Form Tambah Obat -->
            <form action="dashboard.php?page=add_obat" method="POST">

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

                        <!-- Menampilkan seluruh data supplier -->
                        <option value="<?= $row['id_supplier']; ?>">
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

                    <input type="text" name="nama_obat" class="form-control" placeholder="Masukkan Nama Obat" required>
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

                        <option value="Obat Bebas">
                            Obat Bebas
                        </option>

                        <option value="Obat Keras">
                            Obat Keras
                        </option>

                        <option value="Obat Bebas Terbatas">
                            Obat Bebas Terbatas
                        </option>

                    </select>
                </div>

                <!-- Input Jumlah Stok -->
                <div class="mb-3">
                    <label class="form-label">
                        Stok Obat
                    </label>

                    <input
                        type="number"
                        name="stok_obat"
                        class="form-control"
                        placeholder="Masukkan Stok Obat"
                        required>
                </div>

                <!-- Input Harga Obat -->
                <div class="mb-3">
                    <label class="form-label">
                        Harga Obat
                    </label>

                    <input
                        type="number"
                        name="harga_obat"
                        class="form-control"
                        placeholder="Masukkan Harga Obat"
                        required>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2">

                    <!-- Kembali ke halaman Obat -->
                    <a href="?page=obat" class="btn btn-secondary">
                        Kembali
                    </a>

                    <!-- Menyimpan data obat -->
                    <button type="submit" name="add_obat" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Simpan
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>