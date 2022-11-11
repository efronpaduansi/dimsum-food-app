<?php

    include "../conn/koneksi.php";

    $id    = $_GET['id'];

    $query = $conn->query("DELETE FROM user WHERE id = '$id'");

    if($query){
        header("location:../view/superadmin/users.php?hapus=sukses");
    }else{
        header("location:../view/superadmin/users.php?hapus=gagal");
        
    }




?>