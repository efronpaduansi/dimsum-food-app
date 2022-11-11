<?php

        include "../conn/koneksi.php";

        $id = $_GET['id'];

        $query = $conn->query("DELETE FROM menu WHERE id = '$id'");

        if($query){
                header("location:../view/superadmin/menu.php?hapus=sukses");
        }else{
                header("location:../view/superadmin/menu.php?hapus=gagal");
        }


?>