<?php
require_once '../config/Database.php';
class Supplier {
    private $table = "supplier";
    private $conn;
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllSupplier() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result() ->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getSupplierById($id_supplier) {
        $query = "SELECT * FROM $this->table WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_supplier);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }
    public function createSupplier($nama_perusahaan, $no_telepon, $alamat) {
        $id_supplier = $this->db->generateId($this->table, 'id_supplier', 'SP');
        $query = "INSERT INTO $this->table (id_supplier, nama_perusahaan, no_telepon, alamat) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $id_supplier, $nama_perusahaan, $no_telepon, $alamat);
        return $stmt->execute();
    }
    public function updateSupplier($id_supplier, $nama_perusahaan, $no_telepon, $alamat) {
        $query = "UPDATE $this->table SET nama_perusahaan = ?, no_telepon = ?, alamat = ? WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nama_perusahaan, $no_telepon, $alamat, $id_supplier);
        return $stmt->execute();
    }
    public function deleteSupplier($id_supplier) {
        $query = "DELETE FROM $this->table WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_supplier);
        return $stmt->execute();
    }
    public function cekRelasiObat($id_supplier){
    $query = "SELECT id_supplier FROM obat WHERE id_supplier = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $id_supplier);
    $stmt->execute();
    return $stmt->get_result()->num_rows;
}
}