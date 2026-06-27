<?php
session_start();
require_once '../class/user.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $user = new User();
    $user= $user->login($username, $password);
    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Login', 'home.php')};</script>";
    }
    else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Login', 'login.php')};</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h2 class="text-center fw-bold mb-4">Login</h2>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/js.js"></script>