<?php
    session_start();

    if(isset($_POST['login'])){
        include "../conn/koneksi.php";

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $conn->query("SELECT * FROM user WHERE username = '$username'");

        if(mysqli_num_rows($query)=== 1)
        {
          //cek password
          $getData = $query->fetch_assoc();
          $getLevel = $getData['level'];

          if(password_verify($password, $getData['password'])){
              $_SESSION['login'] = true;
              //cek login berdasarkan level admin dan superadmin
              if($getLevel == "Admin")
              {
                $_SESSION['id'] = $getData['id'];
                $_SESSION['username'] = $username;
                $_SESSION['fname'] = $getData['fname'];
                $_SESSION['level'] = "Admin";
                header("location:../view/admin/dashboard.php?login=success");
                

              }else if($getLevel == "Owner")
              {
                $_SESSION['id'] = $getData['id'];
                $_SESSION['username'] = $username;
                $_SESSION['fname'] = $getData['fname'];
                $_SESSION['level'] = "Owner";
                header("location:../view/superadmin/dashboard.php?login=success");
              }else
              {
                $error = true;
                die();
              }
          }else{
            header("location:../index.php?pesan=gagallogin");
            die();
          }
        }else{
         
          header("location:../index.php?pesan=gagallogin");
          
        }

      }
      



?>