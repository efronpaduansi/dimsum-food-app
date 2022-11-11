<?php
    
    include "../conn/koneksi.php";

    $id = $_POST['id'];
    $username = $_POST['username'];
    $fname  = $_POST['fname'];
    $password = $_POST['password'];
    $level   =$_POST['level'];
  

    //enkripsi password
    $enkPass = password_hash($password, PASSWORD_DEFAULT);

    $update = $conn->query("UPDATE user SET 
            username    = '$username',
            fname       = '$fname',
            password    = '$enkPass',
            level       = '$level'
            WHERE id = '$id'");
    if($update){
        header("location:../view/superadmin/users.php?edit=sukses");
      
    }else{
        header("location:../view/superadmin/users.php?edit=gagal");
    }

?>