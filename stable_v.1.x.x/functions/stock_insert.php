<?php

    include "../conn/koneksi.php";

       $id              = $_POST['id'];
       $nama_makanan    = $_POST['nama_makanan'];
       $varian_rasa     = $_POST['varian_rasa'];
       $hrg_beli        = $_POST['hrg_beli'];
       $jumlah          = $_POST['jumlah'];
       $tgl_order       = $_POST['tgl_order'];
       $admin           = $_POST['administrator'];

       //ambil kode makanan pada tb_makanan sesuai dengan varian rasa yg dipilih
       $getKode = $conn->query("SELECT kode AS kode_menu FROM menu WHERE varian_rasa = '$varian_rasa'");
       $fetch_kode = mysqli_fetch_array($getKode);
       $kode_menu = $fetch_kode['kode_menu'];
       echo $kode_makanan;

       $query = $conn->query("INSERT INTO stock(id, kode_menu, hrg_beli, jumlah, tgl_order, administrator) VALUES ('$id', '$kode_menu', '$hrg_beli', '$jumlah', '$tgl_order', '$admin')");
       if($query){
           header("location:../view/superadmin/stock.php?pesan=sukses");
       }else{
        header("location:../view/superadmin/stock.php?pesan=gagal");
       }

    


?>