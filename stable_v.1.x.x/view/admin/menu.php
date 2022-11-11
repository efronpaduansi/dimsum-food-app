<?php
    session_start();
    
    include "../../conn/koneksi.php";

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }

  //cek jika tombol cari di klik
  if(isset($_POST['cari'])){

    $keyword = $_POST['keyword'];

    $query = $conn->query("SELECT * FROM menu WHERE makanan LIKE '%$keyword%' OR varian_rasa LIKE '%$keyword%' OR harga LIKE '%$keyword%'");

  }else{
    //tampilkan data menu kedalam table
    $query = $conn->query("SELECT * FROM menu");
  }

    $menus = array();
    while ($data = $query->fetch_array()){
      $menus[] = $data;
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include "../master/header.php";
  ?>
  <title>Menu | Dimsum Pawonkulo</title>
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
             <li class=""><a class="nav-link" href="penjualan.php"><i class="fas fa-shopping-bag"></i><span>Penjualan</span></a></li>
              <li class=""><a class="nav-link" href="stock.php"><i class="fas fa-layer-group"></i><span>Stock</span></a></li>
              <li class="active"><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
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
            <h1>Daftar Menu</h1>
          </div>
          <div class="section-body">
              <div class="container">
                <div class="row" data-aos="fade-up" data-aos-duration="1000">
                  <div class="col-lg-9">
                    <?=@$alert; ?>
                    <!-- tombol cari menu -->
                    <form class="form-inline mb-3" action="" method="post">
                        <input type="text" name="keyword" placeholder="Telusuri menu..." class="form-control mr-3" autofocus>
                        <button type="submit" name="cari" class="btn btn-primary">Cari</button>
                    </form>
                    <table class="table table-striped">
                        <thead class="bg-primary">
                          <tr>
                            <th scope="col" class="text-light">NO</th>
                            <th scope="col" class="text-light">KODE</th>
                            <th scope="col" class="text-light">NAMA MAKANAN</th>
                            <th scope="col" class="text-light">VARIAN RASA</th>
                            <th scope="col" class="text-light">HARGA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no = 1;
                            foreach($menus as $menu) :
                          ?>
                            <tr>
                                <th scope="row"><?=$no; ?></th>
                                <td><?=$menu['id']; ?></td>
                                <td><?=$menu['makanan']; ?></td>
                                <td><?=$menu['varian_rasa']; ?></td>
                                <td><?="Rp." . " " . $menu['harga']; ?></td>
                            </tr>
                            <?php
                              $no++;
                              endforeach
                            ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </section> 
      </div>
     <?php include "../master/footer.php" ?>
</body>
</html>
