<?php
require_once '../config/Database.php';
class User {
    private $table = "user";
    private $conn;
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function login($username, $password) {
       $query = "SELECT * FROM $this->table WHERE username = ?";
       $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;

            }
        }
        return false;
    }
    public function getAllUsers() {
        $query = "SELECT * FROM $this->table INNER JOIN karyawan USING (id_karyawan)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function getKaryawan(){
    $query = "SELECT *FROM $this->table RIGHT JOIN karyawan USING(id_karyawan) WHERE user.id_karyawan IS NULL ORDER BY nama_karyawan ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function addUser($username,$password,$role,$id_karyawan){
        $query="INSERT INTO $this->table (username, password, role, id_karyawan) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $username, $password, $role, $id_karyawan);
        return $stmt->execute();
    }
    public function logout() {
        session_unset();
        session_destroy();
    }
}

?>