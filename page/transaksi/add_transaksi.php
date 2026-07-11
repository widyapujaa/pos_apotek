<?php
require_once '../class/obat.php';
require_once '../class/pelanggan.php';
require_once '../class/transaksi.php';

$obatModel      = new Obat();
$pelangganModel = new Pelanggan();
$transaksiModel = new Transaksi();

$daftarObat      = $obatModel->getAllObat();
$daftarPelanggan = $pelangganModel->getAllPelanggan();

if (isset($_POST['add_transaksi'])) {
    $id_karyawan_login  = $_SESSION['id_karyawan'];

    $kategori_pelanggan = $_POST['kategori_pelanggan'];
    $id_pelanggan       = $_POST['id_pelanggan'] ?? '';
    $bayar              = (float) $_POST['bayar'];
    $id_obat_arr        = $_POST['id_obat'] ?? [];
    $jumlah_arr         = $_POST['jumlah'] ?? [];

    if ($kategori_pelanggan === 'Member' && empty($id_pelanggan)) {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Kategori Member wajib memilih nama pelanggan', 'dashboard.php?page=add_transaksi')};</script>";

    } elseif (empty($id_obat_arr)) {
        echo "<script>window.onload = function() {showAlert('error','Gagal', 'Keranjang belanja masih kosong', 'dashboard.php?page=add_transaksi')};</script>";

    } else {
        $items = [];
        foreach ($id_obat_arr as $i => $idObat) {
            $items[] = [
                'id_obat' => $idObat,
                'jumlah'  => (int) $jumlah_arr[$i]
            ];
        }

        $foto_resep = null;
        $uploadGagal = false;

        if (isset($_FILES['foto_resep']) && $_FILES['foto_resep']['error'] === UPLOAD_ERR_OK) {
            $ekstensi = pathinfo($_FILES['foto_resep']['name'], PATHINFO_EXTENSION);
            $namaFile = "resep_" . time() . "." . $ekstensi;
            $tujuan   = "../uploads/resep/" . $namaFile;

            if (move_uploaded_file($_FILES['foto_resep']['tmp_name'], $tujuan)) {
                $foto_resep = $namaFile;
            } else {
                $uploadGagal = true;
            }
        }

        if ($uploadGagal) {
            echo "<script>window.onload = function() {showAlert('error','Gagal', 'Gagal upload foto resep', 'dashboard.php?page=add_transaksi')};</script>";

        } else {
            $eksekusi = $transaksiModel->createTransaksi(
                $id_pelanggan,
                $kategori_pelanggan,
                $foto_resep,
                $id_karyawan_login,
                $bayar,
                $items
            );

            if ($eksekusi) {
                echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Transaksi berhasil disimpan', 'dashboard.php?page=transaksi')};</script>";
            } else {
                $pesan = addslashes($transaksiModel->getError());
                echo "<script>window.onload = function() {showAlert('error','Gagal', '$pesan', 'dashboard.php?page=add_transaksi')};</script>";
            }
        }
    }
}
?>

<div class="container-fluid p-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Transaksi Baru</h4>
            <span class="badge bg-light text-dark border">
                <i class="bi bi-calendar3"></i> <?= date('d M Y, H:i') ?>
            </span>
        </div>

        <div class="card-body">

            <form action="dashboard.php?page=add_transaksi" method="POST" enctype="multipart/form-data"
                id="formTransaksi">

                <div class="row">
                    <div class="col-md-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori Pelanggan</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="kategori_pelanggan" id="kategoriUmum"
                                    value="Umum" checked onclick="toggleDropdownPelanggan()">
                                <label class="btn btn-outline-primary" for="kategoriUmum">
                                    <i class="bi bi-person"></i> Umum
                                </label>

                                <input type="radio" class="btn-check" name="kategori_pelanggan" id="kategoriMember"
                                    value="Member" onclick="toggleDropdownPelanggan()">
                                <label class="btn btn-outline-primary" for="kategoriMember">
                                    <i class="bi bi-person-badge"></i> Member
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="wrapperPelanggan" style="display:none;">
                            <label class="form-label">Nama Pelanggan</label>
                            <select name="id_pelanggan" id="id_pelanggan" class="form-select" disabled>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($daftarPelanggan as $p): ?>
                                <option value="<?= $p['id_pelanggan'] ?>">
                                    <?= htmlspecialchars($p['nama_pelanggan']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <input type="hidden" name="id_pelanggan" id="id_pelanggan_umum" value="PL002">

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-file-earmark-medical"></i> Foto Resep
                                <small class="text-muted">(wajib jika ada Obat Keras)</small>
                            </label>
                            <input type="file" name="foto_resep" id="foto_resep" class="form-control" accept="image/*">
                        </div>

                    </div>

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tambah Obat</label>
                            <div class="input-group">
                                <select id="pilihObat" class="form-select">
                                    <option value="">-- Pilih Obat --</option>
                                    <?php foreach ($daftarObat as $data_obat): ?>
                                    <option value="<?= $data_obat['id_obat'] ?>"
                                        data-nama="<?= htmlspecialchars($data_obat['nama_obat']) ?>"
                                        data-harga="<?= $data_obat['harga_obat'] ?>"
                                        data-stok="<?= $data_obat['stok_obat'] ?>"
                                        data-kategori="<?= $data_obat['kategori_obat'] ?>">
                                        <?= htmlspecialchars($data_obat['nama_obat']) ?> (Stok:
                                        <?= $data_obat['stok_obat'] ?>) -
                                        Rp<?= number_format($data_obat['harga_obat'],0,',','.') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" id="jumlahInput" class="form-control" min="1" value="1"
                                    style="max-width:90px;">
                                <button type="button" class="btn btn-primary" onclick="tambahKeKeranjang()">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center" style="width:90px;">Jumlah</th>
                                        <th class="text-end">Sub Total</th>
                                        <th class="text-center" style="width:60px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="isiKeranjang">
                                    <tr id="rowKosong">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-cart-x fs-3 d-block mb-1"></i>
                                            Keranjang masih kosong
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card bg-light border-0 mt-3">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold">Total Belanja</span>
                                    <span class="fw-bold fs-5 text-primary">Rp <span id="totalHarga">0</span></span>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-sm-6">
                                        <label class="form-label mb-1 small">Bayar</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="bayar" id="bayar" class="form-control"
                                                step="0.01" required oninput="hitungKembalian()">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mb-1 small">Kembalian</label>
                                        <div class="form-control bg-white fw-semibold text-success" id="kembalianText">
                                            Rp 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="?page=transaksi" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" name="add_transaksi" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan Transaksi
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
let keranjang = [];

function toggleDropdownPelanggan() {
    const kategori = document.querySelector('input[name="kategori_pelanggan"]:checked').value;
    const wrapper = document.getElementById('wrapperPelanggan');
    const select = document.getElementById('id_pelanggan');
    const hiddenUmum = document.getElementById('id_pelanggan_umum');

    if (kategori === 'Member') {
        wrapper.style.display = 'block';
        select.disabled = false;
        select.required = true;

        hiddenUmum.disabled = true;
    } else {
        wrapper.style.display = 'none';
        select.disabled = true;
        select.required = false;
        select.value = '';
        hiddenUmum.disabled = false;
    }
}

function tambahKeKeranjang() {
    const select = document.getElementById('pilihObat');
    const opt = select.options[select.selectedIndex];
    if (!opt.value) {
        showAlert('error', 'Oops', 'Pilih obat terlebih dahulu', 'dashboard.php?page=add_transaksi');
        return;
    }
    const id_obat = opt.value;
    const nama = opt.dataset.nama;
    const harga = parseFloat(opt.dataset.harga);
    const stok = parseInt(opt.dataset.stok);
    const kategori = opt.dataset.kategori;
    const jumlah = parseInt(document.getElementById('jumlahInput').value);

    if (jumlah < 1) {
        showAlert('error', 'Oops', 'Jumlah minimal 1', 'dashboard.php?page=add_transaksi');
        return;
    }

    const existing = keranjang.find(item => item.id_obat === id_obat);
    const totalDiKeranjang = (existing ? existing.jumlah : 0) + jumlah;

    if (totalDiKeranjang > stok) {
        showAlert('error', 'Stok Tidak Cukup', `Sisa stok ${nama}: ${stok}`, 'dashboard.php?page=add_transaksi');
        return;
    }

    if (existing) {
        existing.jumlah = totalDiKeranjang;
    } else {
        keranjang.push({
            id_obat,
            nama,
            harga,
            jumlah,
            stok,
            kategori
        });
    }
    renderKeranjang();
}

function hapusItem(id_obat) {
    keranjang = keranjang.filter(item => item.id_obat !== id_obat);
    renderKeranjang();
}

function renderKeranjang() {
    const tbody = document.getElementById('isiKeranjang');

    if (keranjang.length === 0) {
        tbody.innerHTML = `
            <tr id="rowKosong">
                <td colspan="5" class="text-center text-muted py-4">
                    <i class="bi bi-cart-x fs-3 d-block mb-1"></i>
                    Keranjang masih kosong
                </td>
            </tr>`;
        document.getElementById('totalHarga').innerText = '0';
        hitungKembalian();
        return;
    }

    let total = 0;
    let html = '';

    keranjang.forEach(item => {
        const subTotal = item.harga * item.jumlah;
        total += subTotal;

        const badgeKeras = item.kategori === 'Obat Keras' ?
            '<span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-1"><i class="bi bi-exclamation-triangle"></i> Keras</span>' :
            '';

        html += `
            <tr>
                <td>${item.nama} ${badgeKeras}
                    <input type="hidden" name="id_obat[]" value="${item.id_obat}">
                    <input type="hidden" name="jumlah[]" value="${item.jumlah}">
                </td>
                <td class="text-end">Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td class="text-center">${item.jumlah}</td>
                <td class="text-end fw-semibold">Rp ${subTotal.toLocaleString('id-ID')}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem('${item.id_obat}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
    });

    tbody.innerHTML = html;
    document.getElementById('totalHarga').innerText = total.toLocaleString('id-ID');

    hitungKembalian();
}

function hitungKembalian() {
    const total = keranjang.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    const bayar = parseFloat(document.getElementById('bayar').value) || 0;
    const kembalian = bayar - total;
    const el = document.getElementById('kembalianText');

    el.innerText = 'Rp ' + (kembalian >= 0 ? kembalian.toLocaleString('id-ID') : '0');
    el.classList.toggle('text-success', kembalian >= 0);
    el.classList.toggle('text-danger', kembalian < 0);
}

document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    if (keranjang.length === 0) {
        e.preventDefault();
        showAlert('error', 'Oops', 'Keranjang masih kosong', 'dashboard.php?page=add_transaksi');
        return;
    }

    const adaObatKeras = keranjang.some(item => item.kategori === 'Obat Keras');
    const fotoResep = document.getElementById('foto_resep').value;

    if (adaObatKeras && !fotoResep) {
        e.preventDefault();
        showAlert('error', 'Oops', 'Ada Obat Keras di keranjang, foto resep wajib diupload!',
            'dashboard.php?page=add_transaksi');
    }
});

toggleDropdownPelanggan();
</script>