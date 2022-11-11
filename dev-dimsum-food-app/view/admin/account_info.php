<?php
  session_start();
  include "../../conn/koneksi.php";

  if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }
 

  


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "../master/header.php"; ?>
  <title><?= $_SESSION['fname']; ?> | Dimsum Pawonkulo</title>
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
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['fname'];?></div></a>
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
            <h1>Informasi Akun</h1>
          </div>
          <div class="section-body">
               <div class="row">
                     <!-- Profile informasi -->
                    
                    <div class="col-lg-6">
                        <div class="card shadow-lg" data-aos="fade-up" data-aos-duration="1000">
                            <div class="card-header bg-dark text-light">
                                Anda login sebagai : @<?=$_SESSION['username'] ." " . "[" . $_SESSION['id'] . "]";?> 
                            </div>
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                  <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1" height=75>
                                </div>
                                <div class="row d-flex justify-content-center mt-5">
                                <div class="title text-left">
                                    <h5>ID</h5>
                                    <h5>USERNAME</h5>
                                    <h5>FULLNAME</h5>
                                    <h5>LEVEL</h5>
                                  </div>
                                  <div class="titik text-center ml-5">
                                    <h5>:</h5>
                                    <h5>:</h5>
                                    <h5>:</h5>
                                    <h5>:</h5>
                                  </div>
                                  <div class="identitas text-left ml-3">
                                    <h5><strong><?=$_SESSION['id']; ?></strong></h5>
                                    <h5><strong><?=$_SESSION['username']; ?></strong></h5>
                                    <h5><strong><?=$_SESSION['fname']; ?></strong></h5>
                                    <h5><strong><?=$_SESSION['level']; ?></strong></h5>
                                  </div>
                                </div>
                                <div class="form-inline d-flex justify-content-center mt-5">
                                    <a href="setting.php" class="btn btn-block btn-danger">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
          </div>
        </section>
      </div>
     <?php include "../master/footer.php" ?>
</body>
</html>
