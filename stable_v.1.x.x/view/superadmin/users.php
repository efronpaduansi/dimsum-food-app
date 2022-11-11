<?php

    session_start();

    if(!isset($_SESSION['login'])){
    header("location:../../index.php?session=false");
  }


    include "../../conn/koneksi.php";
  


    //ambil data user dari database
    $query = mysqli_query($conn, "SELECT * FROM user");
    $result = array();
    while ($data = mysqli_fetch_array($query)) {
      $result[] = $data; //result dijadikan array
    }

    if(isset( $_GET['simpan'])){
        if($_GET['simpan'] =="sukses"){
            $notif = "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>User baru berhasil ditambahkan</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            ";
        }
    }

    //cek hapus
    if(isset($_GET['hapus'])){
        if($_GET['hapus']== "sukses"){
          $notif = "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>User berhasil dihapus</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
            ";
        }
    }
    
    //cek edit
    if(isset($_GET['edit'])){
      if($_GET['edit']== "sukses"){
        $notif = "
              <div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>User berhasil diubah</strong>
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
  <title>Users | Dimsum Pawonkulo</title>
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
              <li class=""><a class="nav-link" href="laporan.php"><i class="fas fa-file-excel"></i> <span>Laporan</span></a></li>
              <li class="nav-item dropdown active">
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
            <h1>Users</h1>
          </div>
          <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <?=@$notif; ?>
                    <!-- Tombol tambah user baru -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahUserModal">
                        Tambah Pengguna
                    </button>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">ID</th>
                                <th scope="col">USERNAME</th>
                                <th scope="col">FULLNAME</th>
                                <th scope="col">LEVEL</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                             foreach ($result as $user) :
                             ?>
                            <tr>
                                <th scope="row"><?= $no; ?></th>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['username']; ?></td>
                                <td><?= $user['fname']; ?></td>
                                <td><?= $user['level']; ?></td>
                                <td>
                                  <div class="form-inline row">
                                        <a href="user_edit.php?id=<?=$user['id']; ?>" class="mr-2 text-info" data-toggle="tooltip" data-placement="top" title="Ubah Data User"><i class="fas fa-edit"></i></a> 
                                        <a href="../../functions/user_delete.php?id=<?=$user['id']; ?>" data-toggle="tooltip" data-placement="top" title="Hapus data user" class="text-primary" onclick = "return confirm ('Tindakan ini akan menghapus data secara permanen. Yakin ?');"><i class="fas fa-trash"></i>
                                        </a>
                                  </div>
                                </td>
                            </tr>
                            <?php 
                                $no++;
                                endforeach 
                            ?>
                        </tbody>
                    </table>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian !</strong> Fitur ini hanya bisa di lihat oleh Owner.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
          </div>
        </section>
      </div>
        <!-- Modal -->
            <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                            <form action="../../functions/user_insert.php" method="post">
                                <?php
                                  //membuat user id otomatis
                                  $query = "SELECT max(id) as idUser FROM user";
                                  $hasil = mysqli_query($conn, $query);
                                  $data = mysqli_fetch_array($hasil);
                                
                                  $maxkode = $data['idUser'];
                                
                                  $noUrut = (int) substr($maxkode, 9, 3);
                                
                                  $noUrut++;
                                  $char = 'USR' . date('dmy');
                                  $idNewUser = $char . sprintf("%03s", $noUrut);
                                ?>
                                <input class="form-control mb-3" name="id_user" type="text" value="<?= $idNewUser; ?>" readonly>
                                <input type="text" name="username" id="username" class="form-control mb-3" placeholder="Username" required autofocus autocomplete="off" minlength="4" maxlength="20">
                                <span id="pesan"></span>
                                <input type="text" name="fname" class="form-control mb-3" placeholder="Fullname" minlength="4" required>
                                <select name="level" id="level" class="form-control mb-3" required>
                                    <option value="" disabled selected hidden>Select Level User</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Owner">Owner</option>
                                </select>
                                <div class="input-group mb-5" id="show_hide_password">
                                    <input type="password" name='password' class="form-control" autocomplete="off" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <a href="" class="btn btn-outline-secondary"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal -->
     <?php include "../master/footer.php" ?>
     <!-- Fungsi untuk mengecek ketersediaan username  -->
          <script>
            $(document).ready(function(){
                $('#username').blur(function(){
                    $('#pesan').html('<p>Cek username...</p>');
                    var username = $(this).val();

                    $.ajax({
                        type	: 'POST',
                        url 	: 'user_cek_username.php', //cek di file user_cek_username.php
                        data 	: 'username='+username,
                        success	: function(data){
                            $('#pesan').html(data);
                        }
                    })

                });
            });
          </script>

          <!-- show hide password functions -->
        <script>
            $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "bi bi-eye-slash" );
                    $('#show_hide_password i').removeClass( "bi bi-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "bi bi-eye-slash" );
                    $('#show_hide_password i').addClass( "bi bi-eye" );
                }
            });
            });
        </script>
</body>
</html>
