<?php
session_start();
require_once '../class/user.php';

    $user=new User();
    $user->logout();
    if ($user) {
        echo "<script>window.onload = function() {showAlert('success','Berhasil', 'Berhasil Logout', 'login.php')};</script>";
    }
    else {
        echo"<script>window.onload = function() {showAlert('error','Gagal', 'Gagal Logout', 'page/dashboard.php?page=home')};</script>";
    }    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>

<body>

</body>

</html>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/js.js"></script>