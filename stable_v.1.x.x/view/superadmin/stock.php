<?php

    session_start();
    include "../../conn/koneksi.php";

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }

   
    //tampilkan data kedalam table
    $getlastUpdate = $conn->query("SELECT menu.makanan, menu.varian_rasa, orders.id, orders.hrg_beli, orders.jumlah, orders.tgl_order, orders.administrator FROM (menu INNER JOIN orders ON menu.id = orders.id_menu) ORDER BY id DESC LIMIT 3");
    
    
    //hitung jumlah data berdasarkan varian rasa
    $getRasaAyam = $conn->query("SELECT SUM(total) AS jml FROM stock WHERE id_menu = 'DPK001'");
    $result = mysqli_fetch_array($getRasaAyam);
    $jmlRasaAyam = $result['jml'];

    $getRasabBeef = $conn->query("SELECT SUM(total) AS jml FROM stock WHERE id_menu = 'DPK002'");
    $result = mysqli_fetch_array($getRasabBeef);
    $jmlRasaBeef = $result['jml'];

    $getRasaCumi = $conn->query("SELECT SUM(total) AS jml FROM stock WHERE id_menu = 'DPK003'");
    $result = mysqli_fetch_array($getRasaCumi);
    $jmlRasaCumi = $result['jml'];

    $getRasaUdang = $conn->query("SELECT SUM(total) AS jml FROM stock WHERE id_menu = 'DPK004'");
    $result = mysqli_fetch_array($getRasaUdang);
    $jmlRasaUdang = $result['jml'];

    $getTotal = $conn->query("SELECT SUM(total) AS total FROM stock");
    $result = mysqli_fetch_array($getTotal);
    $total = $result['total'];

    //cek insert data stock
    if(isset($_GET['pesan'])){
      if($_GET['pesan'] == "sukses"){
        $alert = "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Data stock berhasil ditambahkan</strong>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
      }
    }

    //cek update data stock
    if(isset($_GET['update'])){
      if($_GET['update'] == "sukses"){
        $alert = "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Data stock berhasil diubah</strong>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
      }
    }

    //cek hapus data stock
    if(isset($_GET['hapus'])){
      if($_GET['hapus'] == "sukses"){
        $alert = "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Data stock berhasil dihapus</strong>
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
  <title>Stock - Dimsum Pawonkulo</title>
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
              <li class="active"><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
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
            <h1>Stok Makanan</h1>
          </div>
          <div class="section-body">
              <!-- Table stok makanan -->
                    <div class="col-12">
                        <?=@$alert; ?>
                        <div class="form-inline mb-3">
                              <a href="../../functions/stock_report_pdf.php" target="_blank" class="btn btn-dark"><i class="fas fa-file-pdf"></i> Cetak Laporan PDF</a>
                              <a href="../../functions/stock_report_xls.php" target="_blank" class="btn btn-success ml-3"><i class="fas fa-file-excel"></i> Cetak Laporan XLS</a>
                              <input type="text" class="form-control ml-3 bg-dark text-light" value="<?="Total" . " ". $total . " " . "Pcs"; ?>" readonly>
                          </div>
                        <div class="row">
                            <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
                              <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                  <div class="card card-statistic-1">
                                      <div class="card-icon bg-primary">
                                      <i class="fas fa-layer-group"></i>
                                      </div>
                                      <div class="card-wrap">
                                        <div class="card-header">
                                          <h4>Rasa Ayam</h4>
                                        </div>
                                        <div class="card-body">
                                          <?php if($jmlRasaAyam == 0){
                                              echo "<h1 class='text-danger'>0</h1>" . "<br>";
                                          }else{
                                              echo "<h1>". $jmlRasaAyam . "</h1>" . "<br>";
                                          } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Card II -->
                                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                  <div class="card card-statistic-1">
                                      <div class="card-icon bg-danger">
                                      <i class="fas fa-layer-group"></i>
                                      </div>
                                      <div class="card-wrap">
                                        <div class="card-header">
                                          <h4>Rasa Beef</h4>
                                        </div>
                                        <div class="card-body">
                                          <?php if($jmlRasaBeef == 0){
                                              echo "<h1 class='text-danger'>0</h1>" . "<br>";
                                          }else{
                                              echo "<h1>". $jmlRasaBeef . "</h1>" . "<br>";
                                          } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Card III -->
                                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                  <div class="card card-statistic-1">
                                      <div class="card-icon bg-warning">
                                      <i class="fas fa-layer-group"></i>
                                      </div>
                                      <div class="card-wrap">
                                        <div class="card-header">
                                          <h4>Rasa Cumi</h4>
                                        </div>
                                        <div class="card-body">
                                          <?php if($jmlRasaCumi == 0){
                                              echo "<h1 class='text-danger'>0</h1>" . "<br>";
                                          }else{
                                              echo "<h1>". $jmlRasaCumi . "</h1>" . "<br>";
                                          } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Card IV -->
                                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                  <div class="card card-statistic-1">
                                      <div class="card-icon bg-success">
                                      <i class="fas fa-layer-group"></i>
                                      </div>
                                      <div class="card-wrap">
                                        <div class="card-header">
                                          <h4>Rasa Udang</h4>
                                        </div>
                                        <div class="card-body">
                                          <?php if($jmlRasaUdang == 0){
                                              echo "<h1 class='text-danger'>0</h1>" . "<br>";
                                          }else{
                                              echo "<h1>". $jmlRasaUdang . "</h1>" . "<br>";
                                          } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>  
                              </div>
                             <h6 class="alert alert-info">Terakhir ditambahkan</h6>
                             <div class="table-responsive">
                              <table class="table table-bordered table-secondary">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">NO</th>
                                        <th scope="col">ID ORDER</th>
                                        <th scope="col">MAKANAN</th>
                                        <th scope="col">VARIAN RASA</th>
                                        <th scope="col">HARGA BELI / <sub>Pcs</sub></th>
                                        <th scope="col">JUMLAH</th>
                                        <th scope="col">TGL ORDER</th>
                                        <th scope="col">ADMIN</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $no = 1;
                                        while($stock = $getlastUpdate->fetch_array()) {
                                      ?>
                                      <tr>
                                        <td><?=$no; ?></td>
                                        <td><?=$stock['id']; ?></td>
                                        <td><?=$stock['makanan']; ?></td>
                                        <td><?=$stock['varian_rasa']; ?></td>
                                        <td><?=$stock['hrg_beli']; ?></td>
                                        <td><?=$stock['jumlah']; ?></td>
                                        <td><?=$stock['tgl_order']; ?></td>
                                        <td><?=$stock['administrator']; ?></td>
                                      </tr>
                                      <?php $no++; } ?>
                                    </tbody>
                                </table>
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
