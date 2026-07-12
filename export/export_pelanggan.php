<?php

require_once '../vendor/autoload.php';
require_once '../class/pelanggan.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Membuat object pelanggan
$pelanggan = new Pelanggan();

// Mengambil seluruh data pelanggan
$data = $pelanggan->getAllPelanggan();

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

        <h2>LAPORAN DATA PELANGGAN</h2>

        <p>
        POS APOTEK
        <br>
        Tanggal : ' . date('d-m-Y') . '
        </p>

        <table>

        <tr>

            <th>No</th>
            <th>ID Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>Nomor Telepon</th>

        </tr>

';

    $no = 1;

        foreach ($data as $row) {

            $html .= '

        <tr>
            <td>' . $no++ . '</td>
            <td>' . $row['id_pelanggan'] . '</td>
            <td>' . $row['nama_pelanggan'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['no_telepon'] . '</td>
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
            "Laporan Pelanggan.pdf",
            ["Attachment" => false]
        );
