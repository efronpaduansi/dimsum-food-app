<?php

  include "../conn/koneksi.php";

  $id_user  = $_POST['id_user'];
  $username = $_POST['username'];
  $fname     = $_POST['fname'];
  $level    = $_POST['level'];
  $password = $_POST['password'];

  //enkripsi password
  $newPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO user(id, username, fname,level, password) VALUES
        ('$id_user', '$username', '$fname', '$level', '$newPassword')";
  $simpan = mysqli_query($conn, $sql);

  if($simpan){
    header("location:../view/superadmin/users.php?simpan=sukses");
  }else{
    header("location:../view/superadmin/users.php?simpan=gagal");
  }






?>