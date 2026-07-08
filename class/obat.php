<?php
require_once '../config/Database.php';
class Obat {
    private $table = "obat";
    private $conn;
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllObat() {
        $query = "SELECT * FROM $this->table INNER JOIN supplier USING (id_supplier)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result() ->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function getObatById($id_obat) {
        $query = "SELECT * FROM $this->table WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_obat);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }
    public function createObat($id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat) {
        $id_obat = $this->db->generateId($this->table, 'id_obat', 'OB');
        $query = "INSERT INTO $this->table (id_obat, id_supplier, nama_obat, kategori_obat, stok_obat, harga_obat) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssis", $id_obat, $id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat);
        return $stmt->execute();
    }
    public function updateObat($id_obat, $id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat) {
        $query = "UPDATE $this->table SET id_supplier = ?, nama_obat = ?, kategori_obat = ?, stok_obat = ?, harga_obat = ? WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssis", $id_supplier, $nama_obat, $kategori_obat, $stok_obat, $harga_obat, $id_obat);
        return $stmt->execute();
    }
    public function deleteObat($id_obat) {
        $query = "DELETE FROM $this->table WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_obat);
        return $stmt->execute();
    }
}