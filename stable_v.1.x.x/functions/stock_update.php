<?php
    session_start();
    include "../conn/koneksi.php";

    $id             = $_POST['id'];
    $nama_menu      = $_POST['nama_makanan'];
    $varian_rasa    = $_POST['varian_rasa'];
    $kode_makanan   = $_POST['kode_menu'];
    $hrg_beli       = $_POST['hrg_beli'];
    $jumlah         = $_POST['jumlah'];
    $tgl_order      = $_POST['tgl_order'];
    $administrator  = $_POST['administrator'];

    //select kode from tb_makanan where $varian_rasa
       $getKode = $conn->query("SELECT kode AS kode_menu FROM menu WHERE varian_rasa = '$varian_rasa'");
       $fetch_kode = mysqli_fetch_array($getKode);
       $kode_menu2 = $fetch_kode['kode_menu'];
       echo $kode_menu2;

    $query = $conn->query("UPDATE stock SET 
            kode_menu = '$kode_menu2',
            hrg_beli = '$hrg_beli',
            jumlah     = '$jumlah',
            tgl_order  = '$tgl_order',
            administrator = '$administrator' 
            WHERE id = '$id'");
    if($query){
        header("location:../view/superadmin/stock.php?update=sukses");
    }else{
        header("location:../view/superadmin/stock.php?update=gagal");
    }


?>