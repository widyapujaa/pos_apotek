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
        $result = $stmt->get_result() ->fetch_assoc();
        return $result;
    }
    public function createKaryawan($id_karyawan, $nama_karyawan, $email, $no_telepon, $alamat) {
        $query = "INSERT INTO $this->table (id_karyawan, nama_karyawan, email, no_telepon, alamat) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $id_karyawan, $nama_karyawan, $email, $no_telepon, $alamat);
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
    


}