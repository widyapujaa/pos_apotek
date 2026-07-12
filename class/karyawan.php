<?php
require_once '../config/Database.php';
class Karyawan {
    private $table = "karyawan";
    private $conn;
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllKaryawan() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data Karyawan
    public function searchKaryawan($keyword)
    {

        // Sanitasi Input
        $keyword = trim($keyword);

        $query = "SELECT *
              FROM $this->table
              WHERE nama_karyawan LIKE ?";

        $stmt = $this->conn->prepare($query);

        // Menggunakan wildcard agar pencarian bersifat fleksibel
        $search = "%" . $keyword . "%";

        // Prepared Statement agar aman dari SQL Injection
        $stmt->bind_param("s", $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createKaryawan($nama_karyawan, $email, $no_telepon, $alamat) {
        $id_karyawan = $this->db->generateId($this->table, 'id_karyawan', 'KR');
        $query = "INSERT INTO $this->table (id_karyawan, nama_karyawan, email, no_telepon, alamat) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $id_karyawan, $nama_karyawan, $email, $no_telepon, $alamat);
        return $stmt->execute();
    }
    public function updateKaryawan($id_karyawan, $nama_karyawan, $email, $no_telepon, $alamat) {
        $query = "UPDATE $this->table SET nama_karyawan = ?, email = ?, no_telepon = ?, alamat = ? WHERE id_karyawan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $nama_karyawan, $email, $no_telepon, $alamat, $id_karyawan);
        return $stmt->execute();
    }
    public function deleteKaryawan($id_karyawan) {
        $query = "DELETE FROM $this->table WHERE id_karyawan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_karyawan);
        return $stmt->execute();
    }
    public function getKaryawanById($id_karyawan) {
        $query = "SELECT * FROM $this->table WHERE id_karyawan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_karyawan);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function cekRelasiTransaksi($id_karyawan) {
        $query = "SELECT id_karyawan FROM transaksi WHERE id_karyawan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_karyawan);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }
    
}