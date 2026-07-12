<?php

require_once '../vendor/autoload.php';
require_once '../class/transaksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Membuat object user
$transaksi = new Transaksi();

// Mengambil seluruh data user
$data = $transaksi->getAllTransaksi();

// Konfigurasi Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// HTML PDF
$html = '

    <style>

    body{
        font-family:Arial;
        font-size:12px;
    }

    h2{
        text-align:center;
        margin-bottom:5px;
    }

    p{
        text-align:center;
        color:#666;
        margin-top:0;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:20px;
    }

    th{
        background:#198754;
        color:white;
    }

    th,td{
        border:1px solid #000;
        padding:8px;
        text-align:left;
    }

    </style>

        <h2>LAPORAN DATA TRANSAKSI</h2>

        <p>
        POS APOTEK
        <br>
        Tanggal : ' . date('d-m-Y') . '
        </p>

        <table>

        <tr>

            <th>No</th>
            <th>ID Transaksi</th>
            <th>ID Pelanggan</th>
            <th>Tanggal Transaksi</th>
            <th>Kategori Pelanggan</th>
            <th>Foto Resep</th>
            <th>Total</th>
            <th>Bayar</th>
            <th>Kembalian</th>
            <th>Nama Karyawan</th>

        </tr>

';

    $no = 1;

        foreach ($data as $row) {

            $html .= '

        <tr>
            <td>' . $no++ . '</td>
            <td>' . $row['id_transaksi'] . '</td>
            <td>' . $row['id_pelanggan'] . '</td>
            <td>' . $row['tgl_transaksi'] . '</td>
            <td>' . $row['kategori_pelanggan'] . '</td>
            <td>' . $row['foto_resep'] . '</td>
            <td>' . $row['total'] . '</td>
            <td>' . $row['bayar'] . '</td>
            <td>' . $row['kembalian'] . '</td>
            <td>' . $row['nama_karyawan'] . '</td>


        </tr>

        ';
        }

        $html .= '

        </table>

        <br><br>
        <p style="text-align:right">
        Dicetak pada :
        ' . date('d-m-Y H:i:s') . '
        </p>

        ';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream(
            "Laporan Transaksi.pdf",
            ["Attachment" => false]
        );
