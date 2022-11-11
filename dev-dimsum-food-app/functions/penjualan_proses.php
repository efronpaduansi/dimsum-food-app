<?php

    session_start();
    include "../conn/koneksi.php";
   
   

    $id             = $_POST['id'];
    $id_user        = $_SESSION['id'];
    $nama_makanan   = $_POST['nama_makanan'];
    $varian_rasa    = $_POST['varian_rasa'];
    $jumlah         = $_POST['jumlah'];
    $tgl            = date('Y-m-d');
    $administrator  = $_POST['administrator'];


    //Select id dari tabel menu berdasarkan varian_rasa
    $getIdMenu = $conn->query("SELECT id AS idMenu FROM menu WHERE varian_rasa = '$varian_rasa'");
    $resultIdMenu = $getIdMenu->fetch_array();
    $idMenu = $resultIdMenu['idMenu'];
  
    
    //ambil id_stock dari tabel stock
    $getIdStock = $conn->query("SELECT id AS id_stock FROM stock WHERE id_menu = '$idMenu'");
    $resultIdStock = $getIdStock->fetch_array();
    $idStock = $resultIdStock['id_stock'];
   
    //ambil harga beli dari tabel orders
    $getHargaBeli = $conn->query("SELECT hrg_beli AS hrgBeli FROM orders WHERE id_menu = '$idMenu'");
    $resultHargaBeli = $getHargaBeli->fetch_array();
    $hrgBeli = $resultHargaBeli['hrgBeli'];
   

    //ambil harga jual dari tabel menu
    $getHarga = $conn->query("SELECT harga AS hrgJual FROM menu WHERE varian_rasa = '$varian_rasa'");
    $resultHarga = $getHarga->fetch_array();
    $hrgJual = $resultHarga['hrgJual'];

    //menghitung profit
    $profit = ($hrgJual - $hrgBeli) * $jumlah;
   

     //mengambil jumlah stock makanan pada tabel stock
     $getStock = $conn->query("SELECT total AS jmlStock FROM stock WHERE id_menu = '$idMenu'");
     $resultStock = $getStock->fetch_array();
     $jumlahStock = $resultStock['jmlStock'];
     
     //hitung sisa stock makanan pada tabel stock
      $sisa = ($jumlahStock - $jumlah);
  
    //cek apakah jumlah input lebih dari jumlah stock
   if( $idMenu == "DPK001"){
       $getJmlAyam = $conn->query("SELECT total AS totalRasaAyam FROM stock WHERE id_menu = 'DPK001'");
       $fetchAyam = $getJmlAyam->fetch_array();
       $stockAyam = $fetchAyam['totalRasaAyam'];
       if($jumlah > $stockAyam){
            header("location:../view/admin/penjualan.php?stock=kurang");
       }else{
           //masukan data ke tabel penjualan
           $insertData = $conn->query("INSERT INTO penjualan(id, id_stock, id_menu, id_user, hrg_jual, jumlah, profit, tgl, administrator) VALUES
            ('$id', '$idStock', '$idMenu', '$id_user', '$hrgJual', '$jumlah', '$profit', '$tgl', '$administrator')");
            if($insertData){
                // update tabel stock
                $update = $conn->query("UPDATE stock SET
                            id_menu = '$idMenu', 
                            total = '$sisa' 
                            WHERE id_menu = '$idMenu'");
                if($update){
                    //update tabel profit
                    $updateProfit = $conn->query("UPDATE profit SET
                                                id_menu = '$idMenu',
                                                total_profit = '$profitRasaAyam'
                                                WHERE id_menu = '$idMenu'");
                    header("location:../view/admin/penjualan.php?transaksi=sukses");
                }
            }else{
                header("location:../view/admin/penjualan.php?transaksi=gagal");
            }
       }
   }else if($idMenu == 'DPK002'){
       $getJmlBeef = $conn->query("SELECT total AS totalRasaBeef FROM stock WHERE id_menu = 'DPK002'");
       $fetchBeef = $getJmlBeef->fetch_array();
       $stockBeef = $fetchBeef['totalRasaBeef'];
       if( $jumlah > $stockBeef){
        header("location:../view/admin/penjualan.php?stock=kurang");
       }else{
            //masukan data ke tabel penjualan
            $insertData = $conn->query("INSERT INTO penjualan(id, id_stock, id_menu, id_user, hrg_jual, jumlah, profit, tgl, administrator) VALUES
            ('$id', '$idStock', '$idMenu', '$id_user', '$hrgJual', '$jumlah', '$profit', '$tgl', '$administrator')");
            if($insertData){
                // update tabel stock
                $update = $conn->query("UPDATE stock SET
                                id_menu = '$idMenu', 
                                total = '$sisa' 
                                WHERE id_menu = '$idMenu'");
                     if($update){
                        //update tabel profit
                        $updateProfit = $conn->query("UPDATE profit SET
                                                    id_menu = '$idMenu',
                                                    total_profit = '$profitRasaBeef'
                                                    WHERE id_menu = '$idMenu'");
                        header("location:../view/admin/penjualan.php?transaksi=sukses");
                    }
            }else{
                header("location:../view/admin/penjualan.php?transaksi=gagal");
            }
       }
   }else if($idMenu == 'DPK003'){
    $getJmlCumi = $conn->query("SELECT total AS totalRasaCumi FROM stock WHERE id_menu = 'DPK003'");
    $fetchCumi = $getJmlCumi->fetch_array();
    $stockCumi= $fetchCumi['totalRasaCumi'];
        if( $jumlah > $stockCumi){
            header("location:../view/admin/penjualan.php?stock=kurang");
        }else{
            //masukan data ke tabel penjualan
            $insertData = $conn->query("INSERT INTO penjualan(id, id_stock, id_menu, id_user, hrg_jual, jumlah, profit, tgl, administrator) VALUES
            ('$id', '$idStock', '$idMenu', '$id_user', '$hrgJual', '$jumlah', '$profit', '$tgl', '$administrator')");
            if($insertData){
                // update tabel stock
                $update = $conn->query("UPDATE stock SET
                            id_menu = '$idMenu', 
                            total = '$sisa' 
                            WHERE id_menu = '$idMenu'");
                if($update){
                    //update tabel profit
                    $updateProfit = $conn->query("UPDATE profit SET
                                                id_menu = '$idMenu',
                                                total_profit = '$profitRasaCumi'
                                                WHERE id_menu = '$idMenu'");
                    header("location:../view/admin/penjualan.php?transaksi=sukses");
                }
            }else{
                header("location:../view/admin/penjualan.php?transaksi=gagal");
            }
        }
   }else if( $idMenu == 'DPK004'){
        $getJmlUdang = $conn->query("SELECT total AS totalRasaUdang FROM stock WHERE id_menu = 'DPK004'");
        $fetchUdang = $getJmlUdang->fetch_array();
        $stockUdang = $fetchUdang['totalRasaUdang'];
        if( $jumlah > $stockUdang){
            header("location:../view/admin/penjualan.php?stock=kurang");
        }else{
             //masukan data ke tabel penjualan
           $insertData = $conn->query("INSERT INTO penjualan(id, id_stock, id_menu, id_user, hrg_jual, jumlah, profit, tgl, administrator) VALUES
           ('$id','$idStock', '$idMenu', '$id_user', '$hrgJual', '$jumlah', '$profit', '$tgl', '$administrator')");
           if($insertData){
               // update tabel stock
               $update = $conn->query("UPDATE stock SET
                            id_menu = '$idMenu', 
                            total = '$sisa' 
                            WHERE id_menu = '$idMenu'");
                 if($update){
                    //update tabel profit
                    $updateProfit = $conn->query("UPDATE profit SET
                                                id_menu = '$idMenu',
                                                total_profit = '$profitRasaUdang'
                                                WHERE id_menu = '$idMenu'");
                    header("location:../view/admin/penjualan.php?transaksi=sukses");
                }
           }else{
            header("location:../view/admin/penjualan.php?transaksi=gagal");
           }
        }
   }else{
       die();
   }
    
  
?>