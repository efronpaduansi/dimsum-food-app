<?php

      include "../conn/koneksi.php";

      $id               = $_POST['id'];
      $makanan          = $_POST['makanan'];
      $varian_rasa      = $_POST['varian_rasa'];
      $harga            = $_POST['harga'];

        $sql = "INSERT INTO menu(id, makanan, varian_rasa, harga) VALUES
              ('$id', '$makanan', '$varian_rasa', '$harga')";
        $query = mysqli_query($conn, $sql);
        if($query){
                header("location:../view/superadmin/menu.php?pesan=sukses");
        }else{
                header("location:../view/superadmin/menu.php?pesan=gagal");
        }


?>