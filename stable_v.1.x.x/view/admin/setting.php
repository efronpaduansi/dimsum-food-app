<?php

session_start();

if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }

 //mengatur hak akses user
 $level = $_SESSION['level'];
 if($level == "Owner"){
   header("location:../superadmin/406_error.php");
   die();
 }
 
if(isset($_GET['pesan'])){
  if($_GET['pesan']=="passChangeFailed"){
    $alert = "
    <div class='alert alert-warning alert-dismissible fade show' role='alert' data-aos='fade-up' data-aos-duration='3000'>
        <strong>Gagal mengubah password!</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    ";
  }else if($_GET['pesan']=="passNotMatch"){
    $alert = "
    <div class='alert alert-warning alert-dismissible fade show' role='alert' data-aos='fade-up' data-aos-duration='3000'>
        <strong>Konfirmasi password salah!</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    ";
  }else{
    $alert = "
    <div class='alert alert-success alert-dismissible fade show' role='alert' data-aos='fade-up' data-aos-duration='3000'>
        <strong>Password berhasil diubah!</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    ";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "../master/header.php"; ?>
  <title>Pengaturan | Dimsum Pawonkulo</title>
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?=$_SESSION['fname']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="account_info.php" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="setting.php" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="../../logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Dimsum Pawon Kulo</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">DPK</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header"><?=$_SESSION['level']; ?></li>
              <li class="nav-item">
                <a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
              </li>
            <li class=""><a class="nav-link" href="penjualan.php"><i class="fas fa-shopping-bag"></i><span>Penjualan</span></a></li>
              <li class=""><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
              <li class=""><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
              <li class="active"><a class="nav-link" href="setting.php"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
            </ul>
            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="../../logout.php" class="btn btn-danger btn-lg btn-block btn-icon-split">
              <i class="fas fa-sign-out"></i> Keluar
              </a>
            </div>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
             <h1>Pengaturan</h1>
          </div>

          <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                   <div class="card" data-aos="fade-up" data-aos-duration="1000">
                       <div class="card-header bg-dark text-light">
                        <i class="fas fa-user mr-2"></i> <span>Pengaturan Akun</span> 
                       </div>
                       <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="account_info.php"><span>Informasi Akun Anda</span></a></li>
                                <li class="list-group-item"><a href="" data-toggle="modal" data-target="#passModal"><span>Ganti Password</span></a></li>
                            </ul>
                       </div>
                   </div> <br> <br>
                   <?=@$alert; ?>
                </div>
          </div>
        </section>
      </div>
     <?php include "../master/footer.php" ?>

     <!-- Modal -->
    <div class="modal fade" id="passModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../../functions/passChange.php" method="post" class="needs-validation" novalidate>
              <input type="hidden" name="user_id" value="<?=$_SESSION['id']; ?>">
              <div class="form-group">
                <label for="oldPass">Password Lama <small class="text-danger">*</small></label>
                <input type="password" name="oldPass" id="oldPass" class="form-control" required>
                <div class="invalid-feedback">
                  Bidang ini wajib di isi!
                </div>
              </div>
              <div class="form-group">
                <label for="newPass">Password Baru <small class="text-danger">*</small></label>
                <input type="password" name="newPass" id="newPass" class="form-control" required>
                <div class="invalid-feedback">
                  Bidang ini wajib di isi!
                </div>
              </div>
              <div class="form-group">
                <label for="passConf">Konfirmasi Password<small class="text-danger">*</small></label>
                <input type="password" name="passConf" id="passConf" class="form-control" required>
                <div class="invalid-feedback">
                  Bidang ini wajib di isi!
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="passChange">Simpan perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <!-- Script form validation -->
  <script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>
</body>
</html>
