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
       $query = "SELECT * FROM $this->table INNER JOIN karyawan USING (id_karyawan) WHERE username = ?";
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
        $result = $stmt->get_result() ->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Mencari Data User
    public function searchUsers($keyword){

    $query = "
        SELECT
            user.*,
            karyawan.nama_karyawan
        FROM user
        INNER JOIN karyawan
            ON user.id_karyawan = karyawan.id_karyawan
        WHERE
            karyawan.nama_karyawan LIKE ?
            OR user.username LIKE ?
            OR user.role LIKE ?
    ";

    $stmt = $this->conn->prepare($query);
    $search = "%".$keyword."%";
    $stmt->bind_param("sss",
        $search,
        $search,
        $search
    );

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

    public function getKaryawan(){
    $query = "SELECT *FROM $this->table RIGHT JOIN karyawan USING(id_karyawan) WHERE user.id_karyawan IS NULL ORDER BY nama_karyawan ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function getUserByUsername($username) {
        $query = "SELECT * FROM $this->table INNER JOIN karyawan USING (id_karyawan) WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function addUser($username,$password,$role,$id_karyawan){
        $query="INSERT INTO $this->table (username, password, role, id_karyawan) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $username, $password, $role, $id_karyawan);
        return $stmt->execute();
    }
    public function updateUser($username,$role) {
        $query = "UPDATE $this->table SET role = ? WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss",$role, $username);
        return $stmt->execute();
    }
    public function resetPassword($username, $Password) {
        $query = "UPDATE $this->table SET password = ? WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $Password, $username);
        return $stmt->execute();
    }
    public function logout() {
        session_unset();
        session_destroy();
    }
private $error = "";
public function getError() {
    return $this->error;
}
 public function getProfilById($id_karyawan) {
    $query = "SELECT * FROM $this->table
              INNER JOIN karyawan USING (id_karyawan)
              WHERE id_karyawan = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $id_karyawan);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result;
}

public function updateProfil($id_karyawan, $email, $no_telepon, $alamat) {
    $query = "UPDATE karyawan SET email = ?, no_telepon = ?, alamat = ? WHERE id_karyawan = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssss", $email, $no_telepon, $alamat, $id_karyawan);
    return $stmt->execute();
}

public function updatePassword($id_karyawan, $password_lama, $password_baru) {

    $query = "SELECT password FROM $this->table WHERE id_karyawan = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $id_karyawan);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if (!$data) {
        $this->error = "User tidak ditemukan";
        return false;
    }

    if (!password_verify($password_lama, $data['password'])) {
        $this->error = "Password lama tidak sesuai";
        return false;
    }

    if (strlen($password_baru) < 8) {
        $this->error = "Password baru minimal 8 karakter";
        return false;
    }

    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

    $query = "UPDATE $this->table SET password = ? WHERE id_karyawan = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ss", $password_hash, $id_karyawan);
    return $stmt->execute();
}

}
?>