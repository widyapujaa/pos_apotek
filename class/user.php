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
}
?>