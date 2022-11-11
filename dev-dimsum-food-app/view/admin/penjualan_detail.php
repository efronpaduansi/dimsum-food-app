<?php

    session_start();

    include "../../conn/koneksi.php";

    $id = $_GET['id'];
    
  $getData = $conn->query("SELECT menu.makanan, menu.varian_rasa, penjualan.hrg_jual, penjualan.id, penjualan.tgl, penjualan.jumlah, penjualan.administrator FROM (menu INNER JOIN penjualan ON menu.id = penjualan.id_menu) WHERE penjualan.id = '$id'");
  $detailPenjualan = array();
  while($data = $getData->fetch_array()){
    $detailPenjualan[] = $data;
  }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include "../master/header.php";
  ?>
  <title>Penjualan - Dimsum Pawonkulo</title>
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
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['fname']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="account_info.php" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="account_setting.php" class="dropdown-item has-icon">
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
            <li class="active"><a class="nav-link" href="penjualan.php"><i class="fas fa-shopping-bag"></i><span>Penjualan</span></a></li>
              <li class=""><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
              <li class=""><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
              <li class=""><a class="nav-link" href="setting.php"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
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
            <h1>Detail Penjualan</h1>
          </div>
          <div class="section-body">
              <div class="container d-flex justify-content-center">
                <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 text-left">
                          <h5 class="text-primary">
                            <?php foreach($detailPenjualan as $data) : ?>
                                <?=$data['makanan'] . "-[" . $data['id'] . "]"; ?>
                            <?php endforeach ?>
                          </h5>
                        </div>
                      </div>
                    </div> 
                    <hr>
                    <div class="card-body">
                        <h5>Detail Makanan</h5> <hr>
                      <div class="row">
                        <div class="col-lg-4 text-left">
                          <p class="font-weight-bold">ID</p>
                          <p class="font-weight-bold">Makanan</p>
                          <p class="font-weight-bold">Varian Rasa</p>
                          <p class="font-weight-bold">Harga Jual</p>
                          <p class="font-weight-bold">Jumlah</p>
                          <p class="font-weight-bold">Tanggal</p>
                          <p class="font-weight-bold">Administrator</p>
                        </div>
                        <div class="col-lg-8">
                            <?php foreach($detailPenjualan as $data) : ?>
                              <p class="font-weight-bold ml-5"><?=$data['id']; ?></p>
                              <p class="ml-5"><?=$data['makanan']; ?></p>
                              <p class="ml-5"><?=$data['varian_rasa']; ?></p>
                              <p class="ml-5"><?="Rp." . $data['hrg_jual']; ?></p>
                              <p class="ml-5"><?=$data['jumlah'] . " Pcs"; ?></p>
                              <p class="ml-5"><?=$data['tgl']; ?></p>
                              <p class="ml-5"><?=$data['administrator']; ?></p>
                            <?php endforeach ?>
                        </div>
                      </div>
                      <a href="penjualan.php" class="btn btn-block btn-danger mt-3">Kembali</a>
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
