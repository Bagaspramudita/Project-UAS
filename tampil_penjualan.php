<?php
include "session.php";
include "config/koneksi.php";

// Ambil filter tanggal dari form
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Validasi tanggal agar tidak kosong atau salah format
if (!empty($tanggal)) {
    $tanggal = date('Y-m-d', strtotime($tanggal));
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
    <title>Showroom Penjualan - Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
        .title-large {
            font-size: 1.5rem;
        }
    </style>
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

                <!-- Container Fluid -->
                <div class="main-content">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h4 class="m-0 font-weight-bold text-primary title-large">Daftar Penjualan</h4>
                                    <div class="d-flex align-items-center">
                                        <a href="print_all_penjualan.php?<?php echo !empty($tanggal) ? 'tanggal=' . urlencode($tanggal) : ''; ?>" class="btn btn-success mr-2" target="_blank"><i class="fas fa-print"></i> Print All</a>
                                        <form method="GET" class="d-inline-flex">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Tanggal</span>
                                                </div>
                                                <input type="date" name="tanggal" class="form-control" value="<?php echo $tanggal ? date('Y-m-d', strtotime($tanggal)) : ''; ?>" placeholder="Pilih Tanggal">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-filter"></i> Filter</button>
                                                    <a href="tampil_penjualan.php" class="btn btn-secondary ml-2"><i class="fas fa-times"></i> Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
                                                    <th>Harga Total</th>
                                                    <th>Tanggal</th>
                                                    <th>Status Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query = "SELECT 
                                                    t.id_transaksi,
                                                    p.nama AS nama_pelanggan,
                                                    m.nama_mobil AS nama_mobil,
                                                    t.jumlah,
                                                    t.harga_total,
                                                    DATE(t.tanggal_pembelian) AS tanggal_pembelian,
                                                    t.status_pembayaran
                                                FROM 
                                                    tbl_transaksi_pembelian t
                                                    LEFT JOIN tbl_pelanggan p ON t.id_pelanggan = p.id_pelanggan
                                                    LEFT JOIN tbl_mobil m ON t.id_mobil = m.id_mobil
                                                WHERE 1=1";
                                                if (!empty($tanggal)) {
                                                    $query .= " AND DATE(t.tanggal_pembelian) = '$tanggal'";
                                                }
                                                $query .= " ORDER BY t.id_transaksi DESC";
                                                $result = mysqli_query($koneksi, $query);
                                                if (!$result) {
                                                    die("Query error: " . mysqli_error($koneksi));
                                                }
                                                while ($data = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . htmlspecialchars($data['nama_pelanggan']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($data['nama_mobil']) . "</td>";
                                                    echo "<td>" . (int)$data['jumlah'] . "</td>";
                                                    echo "<td>Rp " . number_format($data['harga_total'], 2) . "</td>";
                                                    echo "<td>" . htmlspecialchars($data['tanggal_pembelian']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($data['status_pembayaran']) . "</td>";
                                                    echo "</tr>";
                                                }
                                                if (mysqli_num_rows($result) == 0) {
                                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data penjualan.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="footer">
                    <?php include 'footer.php'; ?>
                </footer>
                <!-- Footer -->
            </div>
        </div>
        <!-- Scroll to top -->
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