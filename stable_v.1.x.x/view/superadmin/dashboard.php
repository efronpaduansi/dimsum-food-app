<?php
  session_start();

  if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }

  include "../../conn/koneksi.php";

  //mengatur hak akses user
  $level = $_SESSION['level'];
  if($level == "Admin"){
    header("location:../admin/406_error.php");
    die();
  }


  //Menghitung total stok makanan pada tabel stock
  $getDataStock = $conn->query("SELECT SUM(total) AS totalStockMakanan FROM stock");
  $fetchDataStock = $getDataStock->fetch_array();
  $totalStockMakanan = $fetchDataStock['totalStockMakanan'];

  //Menghitung jumlah penjualan makanan
  $getDataPenjualan = $conn->query("SELECT SUM(jumlah) AS totalPenjualan FROM penjualan");
  $fetchDataPenjualan = $getDataPenjualan->fetch_array();
  $dataPenjualan = $fetchDataPenjualan['totalPenjualan'];

  //Menghitung total orders dari table orders
  $getJmlOrders = $conn->query("SELECT SUM(jumlah) AS jmlOrders FROM orders");
  $fetchJmlOrders = $getJmlOrders->fetch_array();
  $jmlOrders = $fetchJmlOrders['jmlOrders'];

  //Menghitung total profit dari tabel penjualan
  $tgl = date('Y/m/d');
  $getTotalProfit = $conn->query("SELECT SUM(profit) AS totalProfit FROM penjualan WHERE tgl = '$tgl'");
  $fetchTotalProfit = $getTotalProfit->fetch_array();
  $totalProfit = $fetchTotalProfit['totalProfit'];
  
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include "../master/header.php";
  ?>
  <title>Dashboard - Dimsum Pawonkulo</title>
  <script src="../../assets/js/Chart.js"></script>
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
              <li class="menu-header"><?= $_SESSION['level']; ?></li>
              <li class="nav-item active">
                <a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
              </li>
              <li class=""><a class="nav-link" href="orders.php"><i class="fas fa-shopping-bag"></i><span>Orders</span></a></li>
              <li class=""><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
              <li class=""><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
              <li class=""><a class="nav-link" href="data_penjualan.php"><i class="fas fa-chart-line"></i><span>Penjualan</span></a></li>
              <li class=""><a class="nav-link" href="profit.php"><i class="fas fa-coins"></i><span>Profit</span></a></li>
              <li class=""><a class="nav-link" href="laporan.php"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-sliders-h"></i><span>Preferences</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="account_setting.php"><i class="fas fa-cog"></i>Pengaturan Akun</a></li>
                  <li><a class="nav-link" href="users.php"><i class="fas fa-user"></i>Tambah User</a></li>
                </ul>
              </li>
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
            <h1>Dashboard</h1>
          </div>
          <div class="section-body">
            <div class="welcome" data-aos="fade-left" data-aos-duration="3000"  data-aos-once="true">
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Hi, <?=$_SESSION['fname']; ?>!</strong> Welcome back.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            <div class="container">
                <!-- Card -->
                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-primary">
                      <i class="fas fa-layer-group"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Total Stok</h4>
                        </div>
                        <div class="card-body">
                          <?=$totalStockMakanan; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                      <i class="fas fa-chart-line"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Terjual</h4>
                        </div>
                        <div class="card-body">
                         <?php
                           if($dataPenjualan == 0){
                            echo 0;
                           }else{
                            echo $dataPenjualan; 
                           }
                         ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-warning">
                      <i class="fas fa-shopping-cart"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Orders</h4>
                        </div>
                        <div class="card-body">
                          <?php if($jmlOrders == 0){
                             echo 0;
                          }else{
                              echo $jmlOrders;
                          } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-success">
                      <i class="fas fa-coins"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Profit</h4>
                        </div>
                        <div class="card-body">
                          <?php if($totalProfit == 0){
                            echo "Rp. ".  0;
                          }else{
                            echo "Rp. " . $totalProfit;
                          } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="row" data-aos="fade-up" data-aos-duration="3000">
                          <div class="col-lg-6 col-md-12 col-12 col-sm-12 stock-grafik">
                            <div class="title"><h5>Grafik Persediaan Makanan</h5></div>
                              <!-- Grafik -->
                                <div style="width: 400px;height: 300px">
                                  <canvas id="myChart"></canvas>
                                </div>
                                <script>
                                    var ctx = document.getElementById("myChart").getContext('2d');
                                    var myChart = new Chart(ctx, {
                                      type: 'doughnut',
                                      data: {
                                        labels: ["Ayam", "Beef", "Cumi", "Udang"],
                                        datasets: [{
                                          label: '',
                                          data: [
                                          <?php 
                                          $stockAyam = $conn->query("SELECT SUM(total) AS totalAyam FROM stock WHERE id_menu = 'DPK001'");
                                          $fethData = $stockAyam->fetch_array();
                                          $jmlAyam = $fethData['totalAyam'];
                                          echo $jmlAyam;
                                          ?>, 
                                          <?php 
                                          $stockBeef = $conn->query("SELECT SUM(total) AS totalBeef FROM stock WHERE id_menu = 'DPK002'");
                                          $fethData2 = $stockBeef->fetch_array();
                                          $jmlBeef = $fethData2['totalBeef'];
                                          echo $jmlBeef;
                                          ?>, 
                                          <?php 
                                          $stockCumi = $conn->query("SELECT SUM(total) AS totalCumi FROM stock WHERE id_menu = 'DPK003'");
                                          $fethData3 = $stockCumi->fetch_array();
                                          $jmlCumi = $fethData3['totalCumi'];
                                          echo $jmlCumi;
                                          ?>, 
                                          <?php 
                                          $stockUdang = $conn->query("SELECT SUM(total) AS totalUdang FROM stock WHERE id_menu = 'DPK004'");
                                          $fethData4 = $stockUdang->fetch_array();
                                          $jmlUdang = $fethData4['totalUdang'];
                                          echo $jmlUdang;
                                          ?>
                                          ],
                                          backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                          ],
                                          borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                          ],
                                          borderWidth: 1
                                        }]
                                      },
                                      options: {
                                        scales: {
                                          yAxes: [{
                                            ticks: {
                                              beginAtZero:true
                                            }
                                          }]
                                        }
                                      }
                                    });
                                </script>
                                <!-- End of Grafik -->
                          </div>
                          <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                            <div class="card shadow-md rounded">
                              <div class="card-header"><strong>My Profile - </strong> You're login as @<?=$_SESSION['username'] . " ". "[" . $_SESSION['id'] . "]" ?></div>
                              <div class="card-body text-center">
                                    <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1" height=75>
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
