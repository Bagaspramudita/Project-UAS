<?php
include "session.php";
include "config/koneksi.php";

// Debugging: Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <link href="img/logo/image.jpg" rel="icon">
   <title>Showroom Transaksi Pembelian - Dashboard</title>
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body id="page-top">
   <div id="wrapper">
      <!-- Sidebar -->
      <?php include 'menu_kiri.php'; ?>
      <!-- Sidebar -->
      <div id="content-wrapper" class="d-flex flex-column">
         <div id="content">
            <!-- TopBar -->
            <?php include 'header.php'; ?>
            <!-- Topbar -->
            <div class="container-fluid">
               <div class="d-sm-flex align-items-center justify-content-between mb-4">
                  <h1 class="h3 mb-0 text-gray-800">Transaksi Pembelian</h1>
                  <a href="form_transaksi_pembelian.php" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Transaksi</a>
               </div>
               <div class="card shadow mb-4">
                  <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Pembelian</h6>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                           <thead>
                              <tr>
                                 <th>No</th>
                                 <th>Nama Pelanggan</th>
                                 <th>Nama Mobil</th>
                                 <th>Jumlah</th>
                                 <th>Harga Satuan</th>
                                 <th>Harga Total</th>
                                 <th>Tanggal Pembelian</th>
                                 <th>Metode Pembayaran</th>
                                 <th>Status Pembayaran</th>
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $no = 1;
                              $query = mysqli_query($koneksi, "SELECT t.*, p.nama AS nama_pelanggan, m.nama_mobil AS nama_mobil, m.harga AS harga_mobil 
                                  FROM tbl_transaksi_pembelian t 
                                  LEFT JOIN tbl_pelanggan p ON t.id_pelanggan = p.id_pelanggan 
                                  LEFT JOIN tbl_mobil m ON t.id_mobil = m.id_mobil");
                              if (!$query) {
                                  echo "<tr><td colspan='10'>Error: " . mysqli_error($koneksi) . "</td></tr>";
                              } else {
                                  while ($data = mysqli_fetch_assoc($query)) {
                                      $harga_satuan = $data['harga_satuan'] > 0 ? $data['harga_satuan'] : ($data['harga_mobil'] > 0 ? $data['harga_mobil'] : 0.00);
                                      $harga_total = $data['harga_total'] > 0 ? $data['harga_total'] : $data['jumlah'] * $harga_satuan;

                                      echo "<tr>";
                                      echo "<td>" . $no++ . "</td>";
                                      echo "<td>" . htmlspecialchars($data['nama']) . "</td>";
                                      echo "<td>" . (isset($data['nama_mobil']) && !empty($data['nama_mobil']) ? htmlspecialchars($data['nama_mobil']) : 'Tidak Ditemukan') . "</td>";
                                      echo "<td>" . htmlspecialchars($data['jumlah']) . "</td>";
                                      echo "<td>" . number_format($harga_satuan, 2) . "</td>";
                                      echo "<td>" . number_format($harga_total, 2) . "</td>";
                                      echo "<td>" . htmlspecialchars($data['tanggal_pembelian']) . "</td>";
                                      echo "<td>" . htmlspecialchars($data['metode_pembayaran']) . "</td>";
                                      echo "<td>" . htmlspecialchars($data['status_pembayaran']) . "</td>";
                                      echo "<td>
                                              <a href='print_transaksi.php?id=" . htmlspecialchars($data['id_transaksi']) . "' target='_blank' class='btn btn-info btn-sm'><i class='fas fa-print'></i></a>
                                            </td>";
                                      echo "</tr>";
                                  }
                              }
                              ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
          <!-- Footer -->
            <footer class="footer">
               <?php include 'footer.php'; ?>
            </footer>
      </div>
      <a class="scroll-to-top rounded" href="#page-top">
         <i class="fas fa-angle-up"></i>
      </a>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
      <script src="vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
      <script>
         $(document).ready(function() {
            $('#dataTable').DataTable();
         });
      </script>
   </body>
</html>