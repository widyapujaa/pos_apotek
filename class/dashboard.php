<?php
require_once '../config/Database.php';

class Dashboard
{

    private $conn;

    public function __construct()
    {

        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Menghitung Total Data Obat
    public function totalObat()
    {
        $query = "SELECT COUNT(*) AS total FROM obat";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menghitung Total Data Supplier
    public function totalSupplier()
    {
        $query = "SELECT COUNT(*) AS total FROM supplier";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menghitung Total User
    public function totalUser()
    {
        $query = "SELECT COUNT(*) AS total FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menghitung Total Data Karyawan
    public function totalKaryawan()
    {
        $query = "SELECT COUNT(*) AS total FROM karyawan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menghitung Total Data Pelanggan
    public function totalPelanggan()
    {
        $query = "SELECT COUNT(*) AS total FROM pelanggan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function totalTransaksi()
    {
        $query = "SELECT COUNT(*) AS total FROM transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menghitung Jumlah Obat dengan Stok Menipis
    // (stok kurang dari 5)
    public function totalStokMenipis()
    {

        $query = "
            SELECT COUNT(*) AS total
            FROM obat
            WHERE stok_obat < 5
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Menampilkan Daftar Obat dengan Stok Menipis
    public function getStokMenipis()
    {

        $query = "
            SELECT
                obat.nama_obat,
                obat.kategori_obat,
                obat.stok_obat,
                supplier.nama_perusahaan
            FROM obat
            INNER JOIN supplier
                ON obat.id_supplier = supplier.id_supplier
            WHERE stok_obat < 5
            ORDER BY stok_obat ASC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil 5 transaksi terbaru
    public function aktivitasTerbaru()
    {
        $query = "
        SELECT
            t.id_transaksi,
            t.tgl_transaksi,
            p.nama_pelanggan,
            o.nama_obat,
            dt.jumlah
        FROM transaksi t
        INNER JOIN pelanggan p
            ON t.id_pelanggan = p.id_pelanggan
        INNER JOIN detail_transaksi dt
            ON t.id_transaksi = dt.id_transaksi
        INNER JOIN obat o
            ON dt.id_obat = o.id_obat
        ORDER BY t.tgl_transaksi DESC
        LIMIT 5
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function transaksiTerbaru()
    {
        $query = "SELECT * FROM transaksi
              LEFT JOIN pelanggan USING (id_pelanggan)
              LEFT JOIN karyawan USING (id_karyawan)
              ORDER BY tgl_transaksi DESC
              LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}
