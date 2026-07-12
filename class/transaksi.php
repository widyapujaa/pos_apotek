<?php
require_once '../config/Database.php';

class Transaksi {
    private $table = "transaksi";
    private $tableDetail = "detail_transaksi";
    private $conn;
    private $error = "";
    private $id_transaksi = "";

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getError() {
        return $this->error;
    }

    public function getIdTransaksi() {
        return $this->id_transaksi;
    }

    public function getAllTransaksi() {
        $query = "SELECT * FROM $this->table LEFT JOIN pelanggan USING (id_pelanggan) LEFT JOIN karyawan USING (id_karyawan) ORDER BY tgl_transaksi DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data Transaksi
public function searchTransaksi($keyword){

    $query = "
    SELECT
        transaksi.*,
        pelanggan.nama_pelanggan,
        karyawan.nama_karyawan
    FROM transaksi
    INNER JOIN pelanggan
        ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    INNER JOIN karyawan
        ON transaksi.id_karyawan = karyawan.id_karyawan
    WHERE
        pelanggan.nama_pelanggan LIKE ?
        OR transaksi.kategori_pelanggan LIKE ?
    ORDER BY transaksi.id_transaksi DESC
";

    $stmt = $this->conn->prepare($query);
    $search = "%".$keyword."%";
    $stmt->bind_param(
        "ss",
        $search,
        $search
    );

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

    public function getTransaksiById($id_transaksi) {
        $query = "SELECT * FROM $this->table LEFT JOIN pelanggan USING (id_pelanggan) LEFT JOIN karyawan USING (id_karyawan) WHERE id_transaksi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_transaksi);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function getDetailByTransaksi($id_transaksi) {
    $query = "SELECT * FROM $this->tableDetail INNER JOIN obat USING (id_obat) WHERE id_transaksi = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $id_transaksi);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $result;
}

    public function cekStokObat($id_obat) {
        $query = "SELECT nama_obat, harga_obat, stok_obat FROM obat WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_obat);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function createTransaksi($id_pelanggan, $kategori_pelanggan, $foto_resep, $id_karyawan, $bayar, $items) {
        if (empty($items)) {
            $this->error = "Item transaksi tidak boleh kosong";
            return false;
        }
        $total = 0;
        $detailSiap = [];

        foreach ($items as $item) {
            $obat = $this->cekStokObat($item['id_obat']);

            if ($obat['stok_obat'] < $item['jumlah']) {
                $this->error = "Stok {$obat['nama_obat']} tidak cukup (sisa {$obat['stok_obat']})";
                return false;
            }
            $sub_total = $obat['harga_obat'] * $item['jumlah'];
            $total = $total + $sub_total;

            $detailSiap[] = [
                'id_obat' => $item['id_obat'],
                'jumlah' => $item['jumlah'],
                'harga_obat' => $obat['harga_obat'],
                'sub_total' => $sub_total,
            ];
        }
        if ($bayar < $total) {
            $this->error = "Uang bayar kurang dari total belanja";
            return false;
        }
        $kembalian = $bayar - $total;
        $id_transaksi = $this->db->generateId($this->table, 'id_transaksi', 'TR');
        $query = "INSERT INTO $this->table (id_transaksi, id_pelanggan, tgl_transaksi, kategori_pelanggan, foto_resep, total, bayar, kembalian, id_karyawan) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssddds", $id_transaksi, $id_pelanggan, $kategori_pelanggan, $foto_resep, $total, $bayar, $kembalian, $id_karyawan);
        $stmt->execute();
        foreach ($detailSiap as $d) {
            $this->simpanDetail($id_transaksi, $d['id_obat'], $d['harga_obat'], $d['jumlah'], $d['sub_total']);
            $this->kurangiStok($d['id_obat'], $d['jumlah']);
        }
        $this->id_transaksi = $id_transaksi;
        return true;
    }

    public function simpanDetail($id_transaksi, $id_obat, $harga_obat, $jumlah, $sub_total) {
        $id_detail = $this->db->generateId($this->tableDetail, 'id_detail_transaksi', 'DT');
        $query = "INSERT INTO $this->tableDetail (id_detail_transaksi, id_transaksi, id_obat, harga_obat, jumlah, sub_total) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssdid", $id_detail, $id_transaksi, $id_obat, $harga_obat, $jumlah, $sub_total);
        return $stmt->execute();
    }

    public function kurangiStok($id_obat, $jumlah) {
        $query = "UPDATE obat SET stok_obat = stok_obat - ? WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $jumlah, $id_obat);
        return $stmt->execute();
    }

    public function deleteTransaksi($id_transaksi) {
        $queryDetail = "DELETE FROM $this->tableDetail WHERE id_transaksi = ?";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bind_param("s", $id_transaksi);
        $stmtDetail->execute();

        $query = "DELETE FROM $this->table WHERE id_transaksi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_transaksi);
        return $stmt->execute();
    }
}