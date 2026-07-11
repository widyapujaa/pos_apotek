<?php
require_once '../config/Database.php';

class Supplier
{

    private $table = "supplier";
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    //Menampilkan Semua Data Supplier
    public function getAllSupplier()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data Supplier Berdasarkan Nama Perusahaan
    public function searchSupplier($keyword)
    {

        // Sanitasi Input
        $keyword = trim($keyword);

        $query = "SELECT *
              FROM $this->table
              WHERE nama_perusahaan LIKE ?";

        $stmt = $this->conn->prepare($query);

        // Menggunakan wildcard agar pencarian bersifat fleksibel
        $search = "%" . $keyword . "%";

        // Prepared Statement agar aman dari SQL Injection
        $stmt->bind_param("s", $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil Data Berdasarkan ID
    public function getSupplierById($id_supplier)
    {
        $query = "SELECT * FROM $this->table WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);

        // Menggunakan prepared statement
        // agar lebih aman dari SQL Injection
        $stmt->bind_param("s", $id_supplier);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function createSupplier($nama_perusahaan, $no_telepon, $alamat)
    {

        //Sanitasi Input
        $nama_perusahaan = trim($nama_perusahaan);
        $alamat = trim($alamat);

        //Validasi Input

        // Tidak boleh kosong
        if (
            empty($nama_perusahaan) ||
            empty($no_telepon) ||
            empty($alamat)
        ) {
            return false;
        }

        //Nama perusahaan Maksimal 100 Karakter
        if (strlen($nama_perusahaan) > 100) {
            return false;
        }

        // Generate ID otomatis
        $id_supplier = $this->db->generateId(
            $this->table,
            'id_supplier',
            'SP'
        );

        $query = "INSERT INTO $this->table 
                (
                    id_supplier, 
                    nama_perusahaan, 
                    no_telepon, 
                    alamat
                ) 
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        // Prepared Statement
        $stmt->bind_param("ssss", $id_supplier, $nama_perusahaan, $no_telepon, $alamat);
        return $stmt->execute();
    }

    //Update Data Supplier
    public function updateSupplier($id_supplier, $nama_perusahaan, $no_telepon, $alamat)
    {

        //Sanitasi Input
        $nama_perusahaan = trim($nama_perusahaan);
        $alamat = trim($alamat);

        //Validasi Input

        if (
            empty($nama_perusahaan) ||
            empty($no_telepon) ||
            empty($alamat)
        ) {
            return false;
        }

        //Nama perusahaan Maksimal 100 Karakter
        if (strlen($nama_perusahaan) > 100) {
            return false;
        }

        $query = "UPDATE $this->table 
        SET 
            nama_perusahaan = ?, 
            no_telepon = ?, 
            alamat = ? 
            WHERE id_supplier = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nama_perusahaan, $no_telepon, $alamat, $id_supplier);
        return $stmt->execute();
    }

    //Hapus Data Supplier
    public function deleteSupplier($id_supplier)
    {
        $query = "DELETE FROM $this->table WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_supplier);
        return $stmt->execute();
    }

    // Mengecek apakah supplier masih digunakan oleh data obat
    public function cekRelasiObat($id_supplier)
    {
        $query = "SELECT id_supplier FROM obat WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_supplier);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }
}
