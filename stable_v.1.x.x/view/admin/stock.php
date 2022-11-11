<?php
  session_start();
    include "../../conn/koneksi.php";

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }


    //Ambil jumlah persediaan dimsum rasa ayam
    $getDataAyam = $conn->query("SELECT total AS total_rasa_ayam FROM stock WHERE id_menu = 'DPK001'");
    $resultDataAyam = $getDataAyam->fetch_array();
    $jmlRasaAyam = $resultDataAyam['total_rasa_ayam'];

    //Ambil jumlah persediaan dimsum rasa beef
    $getDataBeef = $conn->query("SELECT total AS total_rasa_beef FROM stock WHERE id_menu = 'DPK002'");
    $resultDataBeef = $getDataBeef->fetch_array();
    $jmlRasaBeef = $resultDataBeef['total_rasa_beef'];

    //Ambil jumlah persediaan dimsum rasa cumi
    $getDataCumi = $conn->query("SELECT total AS total_rasa_cumi FROM stock WHERE id_menu = 'DPK003'");
    $resultDataCumi = $getDataCumi->fetch_array();
    $jmlRasaCumi = $resultDataCumi['total_rasa_cumi'];

    //Ambil jumlah persediaan dimsum rasa udang
    $getDataUdang = $conn->query("SELECT total AS total_rasa_udang FROM stock WHERE id_menu = 'DPK004'");
    $resultDataUdang = $getDataUdang->fetch_array();
    $jmlRasaUdang = $resultDataUdang['total_rasa_udang'];

    //Menghitung total persediaan makanan
    $getDataMakanan = $conn->query("SELECT SUM(total) AS jmlPersediaan FROM stock");
    $resultDataMakanan = $getDataMakanan->fetch_array();
    $jmlPersediaan = $resultDataMakanan['jmlPersediaan'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "../master/header.php"; ?>
  <title>Stok Barang - Dimsum Pawonkulo</title>
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
              <li class="active"><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
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
            <h1>Stok Makanan</h1>
          </div>
          <div class="section-body">
              <div class="container">
                <!-- Table stock makanan -->
                  <div class="row">
                      <div class="col-lg-9" data-aos="fade-up" data-aos-duration="2000">
                          <table class="table table-bordered table-secondary">
                              <thead class="thead-dark">
                                  <tr>
                                  <th scope="col">NO</th>
                                  <th scope="col">NAMA MAKANAN</th>
                                  <th scope="col">VARIAN RASA</th>
                                  <th scope="col">JML PERSEDIAAN</th>
                                  <th scope="col">KETERANGAN</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                  <td scope="row">1</td>
                                  <td>Dimsum</td>
                                  <td>Ayam</td>
                                  <?php
                                      if($jmlRasaAyam == 0){
                                          echo "<td>0</td>";
                                      }else{
                                          echo "<td>" . $jmlRasaAyam . "</td>";
                                      }
                                      if($jmlRasaAyam == 0){
                                          echo "<td class='text-danger'><strong>Habis</strong></td>";
                                      }else{
                                          echo "<td class='text-success'><strong>Tersedia</strong></td>";
                                      }
                                  ?>
                                  </tr>
                              </tbody>
                              <tbody>
                                  <tr>
                                  <td scope="row">2</td>
                                  <td>Dimsum</td>
                                  <td>Beef</td>
                                  <?php 
                                      if($jmlRasaBeef == 0){
                                          echo "<td>0</td>";
                                      }else{
                                          echo "<td>" . $jmlRasaBeef . "</td>";
                                      }
                                      if($jmlRasaBeef == 0){
                                          echo "<td class='text-danger'><strong>Habis</strong></td>";
                                      }else{
                                          echo "<td class='text-success'><strong>Tersedia</strong></td>";
                                      }
                                  ?>
                                  </tr>
                              </tbody>
                              <tbody>
                                  <tr>
                                  <td scope="row">3</td>
                                  <td>Dimsum</td>
                                  <td>Cumi</td>
                                  <?php 
                                      if($jmlRasaCumi == 0){
                                          echo "<td>0</td>";
                                      }else{
                                          echo "<td>" . $jmlRasaCumi . "</td>";
                                      }
                                      if($jmlRasaCumi == 0){
                                          echo "<td class='text-danger'><strong>Habis</strong></td>";
                                      }else{
                                          echo "<td class='text-success'><strong>Tersedia</strong></td>";
                                      }
                                  ?>
                                  </tr>
                              </tbody>
                              <tbody>
                                  <tr>
                                  <td scope="row">4</td>
                                  <td>Dimsum</td>
                                  <td>Udang</td>
                                  <?php 
                                      if($jmlRasaUdang == 0){
                                          echo "<td>0</td>";
                                      }else{
                                          echo "<td>" . $jmlRasaUdang . "</td>";
                                      }
                                      if($jmlRasaUdang == 0){
                                          echo "<td class='text-danger'><strong>Habis</strong></td>";
                                      }else{
                                          echo "<td class='text-success'><strong>Tersedia</strong></td>";
                                      }
                                  ?>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="total ml-3">
                          <div class="card bg-primary shadow-lg rounded" data-aos="fade-left" data-aos-duration="3000">
                            <div class="card-header">Total Persediaan</div>
                            <div class="card-body text-center">
                              <h1><?=$jmlPersediaan; ?> <sub>Pcs</sub></h1>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
           </div>
        </section>
      </div>
      <?php include "../master/footer.php"; ?>
</body>
</html>
