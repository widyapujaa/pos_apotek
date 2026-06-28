<?php
class Page{
    public function loadPage($page){
        switch($page){

            case "home":
                include "../page/home.php";
                break;

            case "karyawan":
                include "../page/karyawan.php";
                break;

            case "user":
                include "../page/user/user.php";
                break;

            case "add_user":
                include "../page/user/add_user.php";
                break;

            case "supplier":
                include "page/supplier.php";
                break;

            case "pelanggan":
                include "page/pelanggan.php";
                break;

            case "obat":
                include "page/obat.php";
                break;

            case "transaksi":
                include "page/transaksi.php";
                break;

            default:
                include "../page/home.php";
                break;
        }
    }
    public function activePage($page){
    if (isset($_GET['page'])) {
        if ($_GET['page'] == $page) {
            return "active";
        } else {
            return "";
        }
    }
}
}