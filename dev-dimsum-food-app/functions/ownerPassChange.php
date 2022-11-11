<?php

if(isset($_POST['passChange'])){

    //koneksi ke database
    require "../conn/koneksi.php";

    //tangkap data yang dikirim dari form
    $user_id = $_POST['user_id'];
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
    $passConf = $_POST['passConf'];

    //cek apakah password lama sama dengan password yang ada di database
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE id = '$user_id'");
    $cekRow = mysqli_num_rows($cek);

    if($cekRow === 1){
       //verifikasi password lama
         $getData = mysqli_fetch_assoc($cek);
        if(password_verify($oldPass, $getData['password'])){
            //cek apakah password baru dan konfirmasi password sama
            if($newPass === $passConf){
                //enkripsi password baru
                $newPass = password_hash($newPass, PASSWORD_DEFAULT);
                //update password baru
                $update = mysqli_query($conn, "UPDATE user SET password = '$newPass' WHERE id = '$user_id'");
                if($update){
                    header("location:http://localhost/dimsum-pawonkulo/view/superadmin/account_setting.php?pesan=passChangeSuccess");
                }else{
                    header("location:http://localhost/dimsum-pawonkulo/view/superadmin/account_setting.php?pesan=passChangeFailed");
                }
            }else{
                header("location:http://localhost/dimsum-pawonkulo/view/superadmin/account_setting.php?pesan=passNotMatch");
            }

        }else{
            header("location:http://localhost/dimsum-pawonkulo/view/superadmin/account_setting.php?pesan=passChangeFailed");
        }

    }
}