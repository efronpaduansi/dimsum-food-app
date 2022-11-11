<?php

    include "../conn/koneksi.php";

    $id = $_GET['id'];

    //mengambil id_menu dari data yang akan dihapus
    $getIdMenu = $conn->query("SELECT id_menu AS idMenu FROM orders WHERE id = '$id'");
    $fetchIdMenu = $getIdMenu->fetch_assoc();
    $id_menu = $fetchIdMenu['idMenu'];
    
    $getJml = $conn->query("SELECT jumlah FROM orders WHERE id='$id'");
    $fetchJml = $getJml->fetch_assoc();
    $jml = $fetchJml['jumlah'];
   

    $hapus = $conn->query("DELETE FROM orders WHERE id = '$id'");
    if($hapus){
         //menghitung total stock
         $total = $conn->query("SELECT total FROM stock WHERE id_menu = '$id_menu'");
         $row = $total->fetch_assoc();
         $total = $row['total'];

         $sisa = $total - $jml;
      
         //update table stock
         $updateStok = $conn->query("UPDATE stock SET
                        total           = '$sisa'
                        WHERE id_menu   = '$id_menu'
                        ");
         header("location:../view/superadmin/orders.php?hapus=sukses");
    }else{
        header("location:../view/superadmin/orders.php?hapus=gagal");
    }




?>