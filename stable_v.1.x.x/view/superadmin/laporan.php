<?php
  session_start();

  include "../../conn/koneksi.php";
  // include "../../functions/laporan_count.php";

  if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }

    //mengatur hak akses user
    $level = $_SESSION['level'];
    if($level == "Admin"){
      header("location:../admin/406_error.php");
      die();
    }
  

    //cari data berdasarkan tanggal
    if(isset($_POST['cari']))
    {
        $keyword = $_POST['keyword'];
        $selectData = $_POST['select_data'];

       if($selectData == 'Orders'){
            $getDataOrders = $conn->query("SELECT SUM(jumlah) AS jmlOrders FROM orders WHERE tgl_order LIKE '%$keyword%'");
            $resultDataOrders = $getDataOrders->fetch_array();
            $jmlDataOrders = $resultDataOrders['jmlOrders'];
       }else if($selectData == 'Penjualan'){
            $getDataPenjualan = $conn->query("SELECT SUM(jumlah) AS jmlPenjualan FROM penjualan WHERE tgl LIKE '%$keyword%'");
            $resultDataPenjualan = $getDataPenjualan->fetch_array();
            $jmlDataPenjualan = $resultDataPenjualan['jmlPenjualan'];
       }
        
    }



  $getAllOrders = $conn->query("SELECT SUM(jumlah) AS totalOrders FROM orders");
  $resultAllOrders = $getAllOrders->fetch_array();
  $allOrders = $resultAllOrders['totalOrders'];

  $getAllPenjualan = $conn->query("SELECT SUM(jumlah) AS totalPenjualan FROM penjualan");
  $resultAllPenjualan = $getAllPenjualan->fetch_array();
  $allPenjualan = $resultAllPenjualan['totalPenjualan'];

  $getDataStock = mysqli_query($conn, "SELECT SUM(total) AS totalStock FROM stock");
  $resultDataStock = mysqli_fetch_array($getDataStock);
  $jmlDataStock = $resultDataStock['totalStock'];
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include "../master/header.php";
  ?>
  <title>Laporan - Dimsum Pawonkulo</title>
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
              <li class=""><a class="nav-link" href="profit.php"><i class="fas fa-coins"></i><span>Profit</span></a></li>
              <li class="active"><a class="nav-link" href="laporan.php"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
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
            <h1>Laporan</h1>
          </div>
          <div class="section-body">
                <div class="container">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian!</strong> Fitur ini digunakan untuk mencetak laporan stok makanan, data masuk dan data keluar.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form cari data -->
                    <p>Silahkan pilih data yang ingin ditampilkan.</p>
                    <form action="" method="post">
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <select name="select_data" id="select_data" class="form-control" required>
                            <option value="" disabled selected hidden>--Pilih Data--</option>
                            <option value="Orders">Data Orders</option>
                            <option value="Penjualan">Data Penjualan</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <input type="date" id="keyword" name="keyword"  class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                          <button type="submit" name="cari" class="btn btn-primary">Cari data</button>
                        </div>
                      </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-4">
                           <div class="card shadow-lg">
                               <div class="card-header bg-primary text-light"><strong>Orders</strong></div>
                               <div class="card-body text-center">
                                    <h1 class="text-success">
                                      <?php
                                        if(@$jmlDataOrders == 0){
                                          echo "<h1 class='text-danger'>0</h1>"; 
                                        }else{
                                          echo @$jmlDataOrders; 
                                        }
                                      ?>
                                    </h1>
                                    <p>
                                      Total data : <?=@$allOrders; ?>
                                    </p>
                                    <div class="form-inline mt-5 d-block justify-content-center">
                                        <a  href="../../functions/orders_report_pdf.php" target="_blank" class="btn btn-dark mr-3"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                                        <a href="../../functions/orders_report_xls.php" target="_blank" class="btn btn-success"> <i class="fas fa-file-excel"></i> Cetak XLS</a>
                                    </div>
                               </div>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="card shadow-lg">
                               <div class="card-header bg-primary text-light"><strong>Penjualan</strong></div>
                               <div class="card-body text-center">
                                 <h1 class="text-success">
                                  <?php
                                      if(@$jmlDataPenjualan == 0){
                                        echo "<h1 class='text-danger'>0</h1>"; 
                                      }else{
                                        echo @$jmlDataPenjualan; 
                                      }
                                    ?>
                                 </h1>
                                 <p>
                                   Total data : <?=@$allPenjualan; ?>
                                 </p>
                                    <div class="form-inline mt-5 d-block justify-content-center">
                                        <a href="../../functions/penjualan_report_pdf.php" target="_blank" class="btn btn-dark mr-3"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                                        <a href="../../functions/penjualan_report_xls.php" target="_blank" class="btn btn-success"> <i class="fas fa-file-excel"></i> Cetak XLS</a>
                                    </div>
                               </div>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="card shadow-lg">
                               <div class="card-header bg-primary text-light"><strong>Total Stock</strong></div>
                               <div class="card-body text-center">
                                    <h1 class="text-success"><?=@$jmlDataStock; ?></h1>
                                    <p>
                                      Total data : <?=@$jmlDataStock; ?>
                                    </p>
                                    <div class="form-inline mt-5 d-block justify-content-center">
                                        <a href="../../functions/stock_report_pdf.php" target="_blank" class="btn btn-dark mr-3"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                                        <a href="../../functions/stock_report_xls.php" target="_blank" class="btn btn-success"> <i class="fas fa-file-excel"></i> Cetak XLS</a>
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
