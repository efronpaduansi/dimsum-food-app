<?php

    include "../../conn/koneksi.php";

    $username = $_POST['username'];
    $sql = "select * from user where username = '$username'";
    $process = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($process);
    if($num == 0){
        echo " &#10004; Username masih tersedia";
    }else{
        echo " &#10060; Maaf ! Username tidak tersedia";
    }


?>