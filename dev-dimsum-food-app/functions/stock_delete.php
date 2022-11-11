<?php

    include "../conn/koneksi.php";

    $id = $_GET['id'];
    
    $sql = "DELETE FROM stock WHERE id = '$id' ";
    $hapus = mysqli_query($conn, $sql);
    if($hapus){
        header("location:../view/superadmin/stock.php?hapus=sukses");
    }else{
        header("location:../view/superadmin/stock.php?hapus=gagal");
    }

?>
