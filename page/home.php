<?php
session_start();
echo"selamat datang ".$_SESSION['username']."<br>";
echo"Role: ".$_SESSION['role'];
?>