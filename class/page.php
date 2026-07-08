<?php
class Page{
    public function loadPage($page){
        switch($page){

            case "home":
                include "../page/home.php";
                break;

            case "karyawan":
                include "../page/karyawan/karyawan.php";
                break;
            case "add_karyawan":
                include "../page/karyawan/add_karyawan.php";
                break;
            case "edit_karyawan":
                include "../page/karyawan/edit_karyawan.php";
                break;

            case "user":
                include "../page/user/user.php";
                break;
            case "add_user":
                include "../page/user/add_user.php";
                break;
            case "edit_user":
                include "../page/user/edit_user.php";
                break;

            case "supplier":
                include "../page/supplier/supplier.php";
                break;
            case "add_supplier":
                include "../page/supplier/add_supplier.php";
                break;
            case "edit_supplier":
                include "../page/supplier/edit_supplier.php";
                break;

            case "pelanggan":
                include "../page/pelanggan/pelanggan.php";
                break;
            case "add_pelanggan":
                include "../page/pelanggan/add_pelanggan.php";
                break;
            case "edit_pelanggan":
                include "../page/pelanggan/edit_pelanggan.php";
                break;

            case "obat":
                include "../page/obat/obat.php";
                break;
            case "add_obat":
                include "../page/obat/add_obat.php";
                break;
            case "edit_obat":
                include "../page/obat/edit_obat.php";
                break;
                
            case "transaksi":
                include "../page/transaksi/transaksi.php";
                break;
            case "add_transaksi":
                include "../page/transaksi/add_transaksi.php";
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