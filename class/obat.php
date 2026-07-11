<?php
require_once '../config/Database.php';

class Obat
{

    private $table = "obat";
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Menampilkan Semua Data Obat
    public function getAllObat()
    {
        // Menggabungkan data obat dengan supplier
        // menggunakan INNER JOIN agar nama supplier ikut tampil
        $query = "SELECT * FROM $this->table
                  INNER JOIN supplier USING (id_supplier)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data Obat
    public function searchObat($keyword)
    {

        // Sanitasi input
        $keyword = trim($keyword);

        $query = "
        SELECT *
        FROM obat
        INNER JOIN supplier USING(id_supplier)
        WHERE
            nama_obat LIKE ?
            OR kategori_obat LIKE ?
            OR nama_perusahaan LIKE ?
        ";

        $stmt = $this->conn->prepare($query);
        $search = "%" . $keyword . "%";

        // Prepared Statement untuk mencegah SQL Injection
        $stmt->bind_param(
            "sss",
            $search,
            $search,
            $search
        );

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil Data Berdasarkan ID
    public function getObatById($id_obat)
    {
        $query = "SELECT * FROM $this->table
                  WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);

        // Prepared statement
        $stmt->bind_param("s", $id_obat);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    // Menambahkan Data Obat
    public function createObat($id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat)
    {

        // Sanitasi Input
        $nama_obat = trim($nama_obat);
        $kategori_obat = trim($kategori_obat);

        // VALIDASI INPUT
        if (
            empty($id_supplier) ||
            empty($nama_obat) ||
            empty($kategori_obat)
        ) {
            return false;
        }

        // Nama obat maksimal 100 karakter
        if (strlen($nama_obat) > 100) {
            return false;
        }

        // Stok tidak boleh negatif
        if ($stok_obat < 0) {
            return false;
        }

        // Harga tidak boleh negatif
        if ($harga_obat < 0) {
            return false;
        }

        // Generate ID otomatis
        $id_obat = $this->db->generateId(
            $this->table,
            'id_obat',
            'OB'
        );

        $query = "INSERT INTO $this->table
                (
                    id_obat,
                    id_supplier,
                    nama_obat,
                    kategori_obat,
                    stok_obat,
                    harga_obat
                )
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        // Prepared Statement untuk mencegah SQL Injection
        $stmt->bind_param(
            "ssssis",
            $id_obat,
            $id_supplier,
            $nama_obat,
            $kategori_obat,
            $stok_obat,
            $harga_obat
        );

        return $stmt->execute();
    }

    // Update Data Obat
    public function updateObat($id_obat, $id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat)
    {

        // SANITASI INPUT
        $nama_obat = trim($nama_obat);
        $kategori_obat = trim($kategori_obat);

        // VALIDASI INPUT
        if (
            empty($id_supplier) ||
            empty($nama_obat) ||
            empty($kategori_obat)
        ) {
            return false;
        }

        if (strlen($nama_obat) > 100) {
            return false;
        }

        if ($stok_obat < 0) {
            return false;
        }

        if ($harga_obat < 0) {
            return false;
        }

        $query = "UPDATE $this->table
                SET
                    id_supplier = ?,
                    nama_obat = ?,
                    kategori_obat = ?,
                    stok_obat = ?,
                    harga_obat = ?
                WHERE id_obat = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssis", $id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat, $id_obat);
        return $stmt->execute();
    }

    // Hapus Data Obat
    public function deleteObat($id_obat)
    {
        $query = "DELETE FROM $this->table WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_obat);
        return $stmt->execute();
    }
}
