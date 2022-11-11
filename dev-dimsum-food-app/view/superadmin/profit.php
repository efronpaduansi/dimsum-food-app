<?php
  session_start();
    //membuat kode menu otomatis
    include "../../conn/koneksi.php";
    

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }


    //fungsi mencari profit
    if(isset($_POST['cari'])){
      $tanggal = $_POST['tanggal'];
      $showProfit = $conn->query("SELECT profit FROM penjualan WHERE tgl = '$tanggal' AND (id_menu = 'DPK001' OR id_menu ='DPK002' OR id_menu = 'DPK003' OR id_menu = 'DPK004')");
      $array = array();
      while($data = $showProfit->fetch_array()){
        $array[] = $data;
      }

    }else{
      $tgl = date('Y/m/d');
      $showProfit = $conn->query("SELECT profit FROM penjualan WHERE tgl = '$tgl' AND (id_menu = 'DPK001' OR id_menu ='DPK002' OR id_menu = 'DPK003' OR id_menu = 'DPK004')");
      $array = array();
      while($data = $showProfit->fetch_array()){
        $array[] = $data;
      }

    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include "../master/header.php";
  ?>
  <title>Profit - Dimsum Pawonkulo</title>
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
              <li class="nav-item">
                <a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
              </li>
              <li class=""><a class="nav-link" href="orders.php"><i class="fas fa-shopping-bag"></i><span>Orders</span></a></li>
              <li class=""><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
              <li class=""><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
              <li class=""><a class="nav-link" href="data_penjualan.php"><i class="fas fa-chart-line"></i><span>Penjualan</span></a></li>
              <li class="active"><a class="nav-link" href="profit.php"><i class="fas fa-coins"></i><span>Profit</span></a></li>
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
            <h1>Pendapatan</h1>
          </div>
          <div class="section-body">
              <div class="container">
                <!-- Alert  -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Hi, <?=$_SESSION['fname']; ?>!</strong> Kamu bisa melihat pendapatan kamu dibawah ini.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-lg-12">
                  <p>Lihat profit berdasarkan tgl :</p>
                  <form action="" method="post">
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <input type="date" name="tanggal" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                      <button type="submit" name="cari" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </form>
                  <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 text-left">
                          <h1 class="text-primary">Profit</h1>
                        </div>
                        <div class="col-lg-6 text-right">
                          <?php if(isset($_POST['cari'])){
                            $tanggal = $_POST['tanggal'];
                            echo "<h5 class='text-primary'>"."Date : ".date('d/m/Y', strtotime($tanggal))."</h5>";
                          }else{
                            echo "<h5 class='text-primary'>" ."Today : ".date('d/m/Y') ."</h5>";
                          }
                          ?>
                        </div>
                      </div>
                    </div> <hr>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6 text-left">
                          <h5>Varian Rasa</h5> <hr>
                          <p>Rasa Ayam </p>
                          <p>Rasa Beef  </p>
                          <p>Rasa Cumi </p>
                          <p>Rasa Udang </p>
                        </div>
                        <div class="col-lg-6 text-right">
                          <h5>Profit</h5> <hr>
                            <?php foreach($array as $myProfit) : ?>
                              <p><?= "IDR. " . $myProfit['profit'] .",00"; ?></p>
                            <?php endforeach ?>
                          <p class="font-weight-bold">Total</p> <hr>
                          <?php
                            if(isset($_POST['cari'])){
                              $tanggal = $_POST['tanggal'];
                              $getTotalProfit = $conn->query("SELECT SUM(profit) AS totalProfit FROM penjualan WHERE tgl ='$tanggal'");
                              $fetch = $getTotalProfit->fetch_array();
                              $totalProfit = $fetch['totalProfit'];
                            }else{
                              //Menghitung total pendapatan
                              $getTotalProfit = $conn->query("SELECT SUM(profit) AS totalProfit FROM penjualan WHERE tgl = '$tgl'");
                              $fetch = $getTotalProfit->fetch_array();
                              $totalProfit = $fetch['totalProfit'];

                            }
                            ?>
                        
                      </div>
                        <h5 class="ml-auto">Total IDR. <?=$totalProfit .",00"; ?></h5>
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
