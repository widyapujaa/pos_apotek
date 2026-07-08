<?php
    require_once '../class/obat.php';
    require_once '../class/supplier.php';

    // Constructor
    $obat = new Obat();
    $supplier = new Supplier();
    $dataSupplier = $supplier->getAllSupplier();
    if (isset($_POST['add_obat'])) {
        $id_supplier = $_POST['id_supplier'];
        $nama_obat = $_POST['nama_obat'];
        $kategori_obat = $_POST['kategori_obat'];
        $stok_obat = $_POST['stok_obat'];
        $harga_obat = $_POST['harga_obat'];
        $eksekusi = $obat->createObat($id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat);
        if ($eksekusi) {
            echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Menambahkan Obat', 'dashboard.php?page=obat')};</script>";
        } else {
            echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Menambahkan Obat', 'dashboard.php?page=obat')};</script>";
        }
        
    }
    ?>

    <div class="container-fluid p-4">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Tambah Obat</h4>
            </div>

            <div class="card-body">

                <form action="dashboard.php?page=add_obat" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <select name="id_supplier" class="form-select" required>
                            <option value="">-- Pilih Supplier --</option>

                            <?php foreach($dataSupplier as $row){ ?>
                            <option value="<?= $row['id_supplier']; ?>">
                                <?= $row['nama_perusahaan']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" name="nama_obat" class="form-control" placeholder="Masukkan Nama Obat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Obat</label>
                        <select name="kategori_obat" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Obat Bebas">Obat Bebas</option>
                            <option value="Obat Keras">Obat Keras</option>
                            <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Obat</label>
                        <input type="number" name="stok_obat" class="form-control" placeholder="Masukkan Stok Obat"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Obat</label>
                        <input type="number" name="harga_obat" class="form-control" placeholder="Masukkan Harga Obat"
                            required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="?page=obat" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" name="add_obat" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>