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
}
?>