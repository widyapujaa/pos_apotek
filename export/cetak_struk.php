<?php
require '../vendor/autoload.php';
require_once '../class/transaksi.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$transaksi = new Transaksi();
$id_transaksi = $_GET['id_transaksi'];
$data = $transaksi->getTransaksiById($id_transaksi);
$detail = $transaksi->getDetailByTransaksi($id_transaksi);
$no = 1;

$html = '
<html>
<head>
<style>
    body {
        font-family: "Courier New", monospace;
        font-size: 11px;
        margin: 0;
        padding: 5px;
    }
    .center { text-align: center; }
    .garis { border-top: 1px dashed #000; margin: 5px 0; }
    table { width: 100%; border-collapse: collapse; }
    td { padding: 1px 0; vertical-align: top; }
    .kanan { text-align: right; }
</style>
</head>
<body>

<div class="center">
    <b>APOTEK POS</b><br>
    Jl. Stikom Bali no 20<br>
    Telp: 0812-3456-7890
</div>

<div class="garis"></div>

<table>
    <tr><td>Tanggal</td><td>: ' . $data['tgl_transaksi'] . '</td></tr>
    <tr><td>Kasir</td><td>: ' . $data['nama_karyawan'] . '</td></tr>
    <tr><td>Pelanggan</td><td>: ' . $data['nama_pelanggan'] . '</td></tr>
    <tr><td>Kategori</td><td>: ' . $data['kategori_pelanggan'] . '</td></tr>
</table>

<div class="garis"></div>

<table>';

foreach ($detail as $row) {
    $subtotal = number_format($row['sub_total'], 0, ',', '.');
    $harga = number_format($row['harga_obat'], 0, ',', '.');

    $html .= '
    <tr>
        <td colspan="2">' . $row['nama_obat'] . '</td>
    </tr>
    <tr>
        <td>' . $row['jumlah'] . ' x ' . $harga . '</td>
        <td class="kanan">' . $subtotal . '</td>
    </tr>';
}

$html .= '
</table>

<div class="garis"></div>

<table>
    <tr>
        <td><b>Total</b></td>
        <td class="kanan"><b>' . number_format($data['total'], 0, ',', '.') . '</b></td>
    </tr>
    <tr>
        <td>Bayar</td>
        <td class="kanan">' . number_format($data['bayar'], 0, ',', '.') . '</td>
    </tr>
    <tr>
        <td>Kembalian</td>
        <td class="kanan">' . number_format($data['kembalian'], 0, ',', '.') . '</td>
    </tr>
</table>

<div class="garis"></div>

<div class="center">
    Terima kasih<br>
    atas kunjungan Anda
</div>

</body>
</html>';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper([0, 0, 226.77, 1000], 'portrait');
$dompdf->render();
$dompdf->stream('struk_' . $id_transaksi . '.pdf', ['Attachment' => false]);