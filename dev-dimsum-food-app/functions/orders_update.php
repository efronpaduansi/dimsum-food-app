<?php

    session_start();
    include "../conn/koneksi.php";


    $id                     = $_POST['id'];
    $id_user                = $_SESSION['id'];
    $varian_rasa            = $_POST['varian_rasa'];
    $hrg_beli               = $_POST['hrg_beli'];
    $jumlah                 = $_POST['jumlah'];
    $tgl_order              = $_POST['tgl_order'];
    $administrator          = $_POST['administrator'];

    //select id_menu from table menu
    $getIdMenu = $conn->query("SELECT id AS idMenu FROM menu WHERE varian_rasa = '$varian_rasa'");
    $fetchIdMenu = $getIdMenu->fetch_assoc();
    $id_menu = $fetchIdMenu['idMenu'];
    
    
    // Update data orders
    $update = $conn->query("UPDATE orders SET
                id_menu         = '$id_menu',
                id_user         = '$id_user',
                id_menu         = '$id_menu',
                hrg_beli        = '$hrg_beli',
                jumlah          = '$jumlah',
                tgl_order       = '$tgl_order',
                administrator   = '$administrator'
                WHERE id = '$id'
             ");
        //Update tabel stock
        if($update)
        {
             //menghitung total stock
            $total = $conn->query("SELECT SUM(jumlah) AS total FROM orders WHERE id_menu = '$id_menu'");
            $row = $total->fetch_assoc();
            $total = $row['total'];

            $updateStok = $conn->query("UPDATE stock SET
                        id_menu     = '$id_menu',
                        total       = '$total'
                        WHERE id_menu = '$id_menu'
                        ");
            header("location:../view/superadmin/orders.php?update=sukses");
        }
        else
        {
            header("location:../view/superadmin/orders.php?update=sukses");
        }
    


?>