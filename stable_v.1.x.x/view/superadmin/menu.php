<?php
  session_start();
    //membuat kode menu otomatis
    include "../../conn/koneksi.php";

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }


    $query = "SELECT max(id) as idMenu FROM menu";
    $hasil = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($hasil);

    $maxkode = $data['idMenu'];
    $noUrut = (int) substr($maxkode, 3, 3);
    
    $noUrut++;
    $char = 'DPK';
    $idMenu = $char . sprintf("%03s", $noUrut);

    //tampilkan data menu kedalam table
    $getData = mysqli_query($conn, "SELECT * FROM menu");
    $menus = array();
    while ($data = mysqli_fetch_array($getData)){
      $menus[] = $data;
    }

    //cek pesan masuk
    if(isset($_GET['pesan'])){
      if($_GET['pesan'] == "sukses"){
        $alert = "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Menu baru berhasil ditambahkan</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            ";
      }else{
        $alert = "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Menu baru gagal ditambahkan</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            ";
      }
    }

    //cek hapus menu
    if( isset($_GET['hapus'])){
      if($_GET['hapus'] == "sukses"){
        $alert = "
          <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Menu baru berhasil dihapus</strong>
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
              </button>
          </div>
          ";
      }
    }

    //cek update menu
    if( isset($_GET['update'])){
      if($_GET['update'] == "sukses"){
        $alert = "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Menu baru berhasil diubah</strong>
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
  <title>Menu - Dimsum Pawonkulo</title>
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
              <li class="active"><a class="nav-link" href="menu.php"><i class="fas fa-clipboard-list"></i><span>Menu</span></a></li>
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
            <h1>Daftar Menu</h1>
          </div>
          <div class="section-body">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12" data-aos="fade-up" data-aos-duration="1000">
                    <?=@$alert; ?>
                    <!-- tombol tambah menu -->
                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#menuModal">
                        Tambah Menu Baru
                    </button>
                    <div class="table-responsive">
                      <table class="table table-striped">
                          <thead class="bg-primary">
                            <tr>
                              <th scope="col" class="text-light">NO</th>
                              <th scope="col" class="text-light">ID MAKANAN</th>
                              <th scope="col" class="text-light">NAMA MAKANAN</th>
                              <th scope="col" class="text-light">VARIAN RASA</th>
                              <th scope="col" class="text-light">HARGA/ <sub>Pcs</sub></th>
                              <th scope="col" class="text-light text-center">AKSI</th>
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
                                  <td><?= "Rp.". " " . $menu['harga']; ?></td>
                                  <td class="d-flex justify-content-center">
                                    <div class="form-inline">
                                        <a class="btn btn-success mr-2" href="menu_edit.php?id=<?=$menu['id']; ?>" data-toggle="tooltip" data-placement="top" title="Ubah data">Ubah</a>
                                        <a class="btn btn-danger" href="../../functions/menu_delete.php?id=<?=$menu['id']; ?>" onclick = "return confirm ('Tindakan ini akan menghapus data secara permanen. Yakin ?');" data-toggle="tooltip" data-placement="top" title="Hapus data">Hapus</a>
                                    </div>
                                  </td>
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
          </div>
        </section>
        <!-- Menu Modal -->
          <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Menu Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <!-- form input -->
                    <form action="../../functions/menu_insert.php" method="post">
                          <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Fitur ini hanya bisa diakses oleh Owner.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <input type="text" name="id" class="form-control mb-3" value="<?=$idMenu; ?>" readonly>
                        <input type="text" name="makanan" placeholder="Makanan" class="form-control mb-3" required autocomplete="off">
                        <input type="text" name="varian_rasa" placeholder="Varian Rasa" class="form-control mb-3" required autocomplete="off">
                        <input type="number" name="harga" placeholder="Harga Jual (Rp)" class="form-control mb-5" min="3500" max="999999" required autocomplete="off">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
      </div>
     <?php include "../master/footer.php" ?>
</body>
</html>
