<?php

    include "../conn/koneksi.php";

    $id     = $_GET['id'];

    $hapus = $conn->query("DELETE FROM penjualan WHERE id = '$id'");

    if($hapus){
        header("location:../view/superadmin/data_penjualan.php?hapus=sukses");
    }else{
        header("location:../view/superadmin/data_penjualan.php?hapus=gagal");
        
    }



?>