<?php
require_once '../config/Database.php';
class Pelanggan {
    private $table = "pelanggan";
    private $conn;
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllPelanggan() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result() ->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data Pelanggan
    public function searchPelanggan($keyword)
    {

        // Sanitasi Input
        $keyword = trim($keyword);

        $query = "SELECT *
              FROM $this->table
              WHERE nama_pelanggan LIKE ?";

        $stmt = $this->conn->prepare($query);

        // Menggunakan wildcard agar pencarian bersifat fleksibel
        $search = "%" . $keyword . "%";

        // Prepared Statement agar aman dari SQL Injection
        $stmt->bind_param("s", $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getPelangganById($id_pelanggan) {
        $query = "SELECT * FROM $this->table WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_pelanggan);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }
    public function createPelanggan($nama_pelanggan, $email, $no_telepon) {
        $id_pelanggan = $this->db->generateId($this->table, 'id_pelanggan', 'PL');
        $query = "INSERT INTO $this->table (id_pelanggan, nama_pelanggan, email, no_telepon) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $id_pelanggan, $nama_pelanggan, $email, $no_telepon);
        return $stmt->execute();
    }
    public function updatePelanggan($id_pelanggan, $nama_pelanggan, $email, $no_telepon) {
        $query = "UPDATE $this->table SET nama_pelanggan = ?, email = ?, no_telepon = ? WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nama_pelanggan, $email, $no_telepon, $id_pelanggan);
        return $stmt->execute();
    }
    public function deletePelanggan($id_pelanggan) {
        $query = "DELETE FROM $this->table WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_pelanggan);
        return $stmt->execute();
    }
    public function cekRelasiObat($id_supplier){
    $query = "SELECT id_supplier FROM obat WHERE id_supplier = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $id_supplier);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}
    public function cekRelasiTransaksi($id_pelanggan) {
        $query = "SELECT id_pelanggan FROM transaksi WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_pelanggan);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }

}