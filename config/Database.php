<?php
class Database {
    private $conn;
    

    public function __construct() {
        $this->connect();
    }
    private function connect() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "pos_apotek";
        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }
    public function getConnection() {
        return $this->conn;
    }
    
    public function generateId($table,$field,$id_dpn){
        $query = "SELECT $field FROM $table ORDER BY $field DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if(!$result)
        {
            return $id_dpn."001";
        }
        $idTerakhir = $result[$field];
        $angka = (int) substr($idTerakhir, strlen($id_dpn));
        $angka++;
        return $id_dpn.str_pad($angka,3,"0",STR_PAD_LEFT);

    }
}
?>