<?php
    include "../conn/koneksi.php";

    $id             = $_POST['id'];
    $makanan        = $_POST['makanan'];
    $varian_rasa    = $_POST['varian_rasa'];
    $harga          = $_POST['harga'];

    $query = $conn->query("UPDATE menu SET
                makanan         = '$makanan',
                varian_rasa     = '$varian_rasa',
                harga           = '$harga'
                WHERE id        = '$id'");
    if($query){
        header("location:../view/superadmin/menu.php?update=sukses");
    }else{
        header("location:../view/superadmin/menu.php?update=gagal");
    }

?>