<?php

    include "../conn/koneksi.php";

    //membuat id order otomatis 
    $query = "SELECT max(id) as orderId FROM orders";
    $hasil = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($hasil);

    $maxkode = $data['orderId'];

    $noUrut = (int) substr($maxkode, 9, 3);

    $noUrut++;
    $char ="ID-" . date('dmy');
    $Id = $char . sprintf("%03s", $noUrut);


?>