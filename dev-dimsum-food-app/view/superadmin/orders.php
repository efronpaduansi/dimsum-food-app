<?php
  session_start();
  include "../../conn/koneksi.php";
  // include "../../functions/orders_id.php";
 

  if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }


  if(isset($_POST['cari'])){

    $keyword = $_POST['keyword'];

    $query = $conn->query("SELECT menu.makanan, menu.varian_rasa, orders.id, orders.hrg_beli, orders.jumlah, orders.tgl_order, orders.administrator FROM (menu INNER JOIN orders ON menu.id = orders.id_menu) 
    WHERE 
    menu.makanan = '$keyword' OR
    menu.varian_rasa = '$keyword'
     ");

     if($keyword == ""){
          //tampil semua data ke dalam tabel
          $query = $conn->query("SELECT menu.makanan, menu.varian_rasa, orders.id, orders.hrg_beli, orders.jumlah, orders.tgl_order, orders.administrator FROM (menu INNER JOIN orders ON menu.id = orders.id_menu) ORDER BY id DESC");
     }

  }else{
    //tampil semua data ke dalam tabel
  $query = $conn->query("SELECT menu.makanan, menu.varian_rasa, orders.id, orders.hrg_beli, orders.jumlah, orders.tgl_order, orders.administrator FROM (menu INNER JOIN orders ON menu.id = orders.id_menu) ORDER BY id DESC");
  

  }

  

  //cek simpan sukses
  if(isset($_GET['simpan'])){
    if($_GET['simpan']== "sukses"){
          $simpanAlert = "
              <div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Data berhasil ditambahkan</strong>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                  </button>
              </div>
          ";
    }
  }

  //cek hapus sukses
  if(isset($_GET['hapus'])){
    if($_GET['hapus']== "sukses"){
          $hapusAlert = "
              <div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Data berhasil dihapus</strong>
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
  <?php 
    include "../master/header.php";
  ?>
  <title>Orders - Dimsum Pawonkulo</title>
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
              <li class="active"><a class="nav-link" href="orders.php"><i class="fas fa-shopping-bag"></i><span>Orders</span></a></li>
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
            <h1>Orders</h1>
          </div>
          <div class="section-body">
              <?=@$simpanAlert; ?>
              <?=@$hapusAlert; ?>     
              <div class="container" data-aos="fade-up" data-aos-duration="1000">
                <div class="row">
                    <div class="form-inline mb-5">
                          <!-- Tombol tambah orders -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ordersModal">
                            Tambahkan ke Orders
                          </button>
                        <form action="" method="post">
                          <input type="text" name="keyword" class="form-control ml-4 mr-2" placeholder="Telusuri data..." autofocus>
                          <button type="submit" name="cari" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                        </form>
                    </div>
                    <!-- Tabel orders -->
                    <table class="table">
                      <thead class="thead-dark bg-primary">
                        <tr>
                          <th scope="col" class="text-light">NO</th>
                          <th scope="col" class="text-light">ID</th>
                          <th scope="col" class="text-light">MAKANAN</th>
                          <th scope="col" class="text-light">RASA</th>
                          <th scope="col" class="text-light">HARGA</th>
                          <th scope="col" class="text-light">JML</th>
                          <th scope="col" class="text-light">TGL</th>
                          <th scope="col" class="text-light">ADMIN</th>
                          <th scope="col" class="text-light">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $no = 1;
                           while($orders = $query->fetch_array()) {
                          ?>
                        <tr>
                          <th scope="row"><?=$no; ?></th>
                          <td><?=$orders['id']; ?></td>
                          <td><?=$orders['makanan']; ?></td>
                          <td><?=$orders['varian_rasa']; ?></td>
                          <td><?=$orders['hrg_beli']; ?></td>
                          <td><?=$orders['jumlah']; ?></td>
                          <td><?= date('d/m/y', strtotime($orders['tgl_order'])); ?></td>
                          <td><?=$orders['administrator']; ?></td>
                          <td>
                            <div class="form-inline">
                              <a href="orders_edit.php?id=<?=$orders['id']; ?>" data-toggle="tooltip" data-placement="left" title="Ubah Data"><i class="fas fa-edit"></i></a>
                              <a href="../../functions/orders_delete.php?id=<?=$orders['id']; ?>" data-toggle="tooltip" data-placement="left" title="Hapus Data" onclick="return confirm('Tindakan ini akan menghapus data secara permanen. Yakin ?')"><i class="fas fa-trash"></i></a>
                            </div>
                          </td>
                        </tr>
                        <?php $no++; } ?>
                      </tbody>
                    </table>
                </div>
              </div>
          </div>
        </section>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="ordersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Order Makanan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../../functions/orders_insert.php" method="post">
                <?php 
                   //membuat id order otomatis 
                    $query = "SELECT max(id) as orderId FROM orders";
                    $hasil = mysqli_query($conn, $query);
                    $data = mysqli_fetch_array($hasil);
                    $maxkode = $data['orderId'];
                    $noUrut = (int) substr($maxkode, 9, 3);
                    $noUrut++;
                    $char ="ID-" . date('dmy');
                    $Id = $char . sprintf("%03s", $noUrut);
                ?>
                <input type="text" class="form-control mb-3" name="id" value="<?=$Id; ?>" readonly>
                <select name="makanan" class="form-control mb-3" required>
                  <option value="" disabled selected hidden>--Select Makanan--</option>
                  <option value="Dimsum">Dimsum</option>
                </select>
                <select name="varian_rasa" class="form-control mb-3" required>
                  <option value="" disabled selected hidden>--Select Varian Rasa--</option>
                  <!-- select varian rasa from table menu -->
                    <?php 
                        $query = $conn->query("SELECT varian_rasa FROM menu");
                        while($varian_rasa = $query->fetch_array()) {
                    ?>
                  <option value="<?=$varian_rasa['varian_rasa']; ?>"><?=$varian_rasa['varian_rasa']; ?></option>
                    <?php } ?>
                </select>
                <input type="number" name="hrg_beli" class="form-control mb-3" placeholder="Harga beli (Rp)"required min="1000" max="99000">
                <input type="number" name="jumlah" class="form-control mb-3" placeholder="Jumlah (Pcs)" required min="1">
                <input type="date" name="tgl_order" class="form-control mb-3" required>
                <input type="text" name="admin" class="form-control mb-5" value="<?=$_SESSION['fname']; ?>" readonly>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
           
          </div>
        </div>
      </div>
     <?php include "../master/footer.php" ?>
</body>
</html>
