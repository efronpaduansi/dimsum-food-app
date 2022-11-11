<?php
    session_start();
    include "../conn/koneksi.php";

    $id             = $_POST['id'];
    $id_user        = $_SESSION['id'];
    $varian_rasa    = $_POST['varian_rasa'];
    $hrg_beli       = $_POST['hrg_beli'];
    $jumlah         = $_POST['jumlah'];
    $tgl_order      = $_POST['tgl_order'];
    $admin          = $_POST['admin'];

    //select id_menu from table menu
    $getIdMenu = $conn->query("SELECT id AS idMenu FROM menu WHERE varian_rasa = '$varian_rasa'");
    $fetchIdMenu = $getIdMenu->fetch_assoc();
    $id_menu = $fetchIdMenu['idMenu'];

    //insert data
    $query = $conn->query("INSERT INTO orders(id, id_menu, id_user, hrg_beli, jumlah, tgl_order, administrator) VALUES ('$id', '$id_menu', '$id_user', '$hrg_beli', '$jumlah', '$tgl_order', '$admin')");
    if($query){
        //menghitung total stock
        $total = $conn->query("SELECT SUM(jumlah) AS total FROM orders WHERE id_menu = '$id_menu'");
        $row = $total->fetch_assoc();
        $total = $row['total'];
        
        $updateStok = $conn->query("UPDATE stock SET
                        id_menu     = '$id_menu',
                        total       = '$total'
                        WHERE id_menu = '$id_menu'
                        ");

        header("location:../view/superadmin/orders.php?simpan=sukses");
    }else{
        header("location:../view/superadmin/orders.php?simpan=gagal");
    }




?>