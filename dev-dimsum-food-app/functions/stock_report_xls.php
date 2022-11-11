<?php
    session_start();
    include "../conn/koneksi.php";
       // fungsi header dengan mengirimkan raw data excel
       header("Content-type: application/vnd-ms-excel");      
       // membuat nama file ekspor "data-anggota.xls"
       header("Content-Disposition: attachment; filename=dimsum-pawonkulo.xls");    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">

    <title>Stock Report - Dimsum Pawon Kulo</title>
</head>
<body>
    <div class="container">
        <div class="header mr-auto mt-3 mb-3">
            <strong><?= "Cetak : " . date("d/m/Y"); ?></strong> 
            <strong>Time : <?=date("h:i:sa") ?></strong>
        </div>
        <div class="title text-center">
            <h2 class="text-primary">DIMSUM PAWON KULO</h2>
            <h4><strong>LAPORAN PERSEDIAAN STOK MAKANAN</strong></h4>
            <p class="mb-4">Jl. Ampera Poncol Babakan Setu Tangsel - Tlp : 081xxxxxx</p>
        </div>
       <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">ID MENU</th>
                    <th scope="col">MAKANAN</th>
                    <th scope="col">VARIAN RASA</th>
                    <th scope="col">HRG/Pcs (Rp)</th>
                    <th scope="col">TOTAL STOCK (Pcs)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $sql = mysqli_query($conn,"SELECT menu.id, menu.makanan, menu.varian_rasa, menu.harga, stock.total FROM(menu INNER JOIN stock ON menu.id = stock.id_menu)");
                    while($data = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <th scope="row"><?= $no++;?></th>
                    <td><?=$data['id'];?></td>
                    <td><?=$data['makanan'];?></td>
                    <td><?=$data['varian_rasa'];?></td>
                    <td><?= "Rp.". " " . $data['harga'];?></td>
                    <td><?=$data['total'] . " " . "Pcs";?></td>
                </tr>
                <?php } ?>
            </tbody>
       </table>
        <!-- Hitung total data -->
        <?php
            $getTotal = mysqli_query($conn, "SELECT SUM(total) AS total FROM stock");
            // $getPengeluaran = mysqli_query($conn, "SELECT SUM(hrg_beli * jumlah) AS pengeluaran FROM stock");
            $result = mysqli_fetch_array($getTotal);
            // $hasilPengeluaran = mysqli_fetch_array($getPengeluaran);
            $total = $result['total'];
            // $totalPengeluaran = $hasilPengeluaran['pengeluaran'];
            echo "<strong>" . "Total Makanan : ". " " . $total . " " . "pcs" . "</strong>" . "<br>";
            // echo "<strong>" . "Total Pengeluaran : " . " " . "Rp. " . " " . $totalPengeluaran . "</strong>";
        ?>
        
       <br> <br> <br>
       <div class="text-center">
           <p>Depok, <?=date('d M Y'); ?></p>
           <strong>Administrator</strong> 
           <br> <br>
           <p><?=$_SESSION['fname']; ?></p>
       </div>
    </div>
    
    <!-- Cetak -->
    <script>
      window.print();
    </script>


    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
     <script src="assets/js/stisla.js"></script>

     <!-- JS Libraies -->

     <!-- Template JS File -->
     <script src="assets/js/scripts.js"></script>
     <script src="assets/js/custom.js"></script>

</body>
</html>