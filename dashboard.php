<?php
session_start();

// Jika belum login, arahkan ke index dengan pesan
if (!isset($_SESSION['username'])) {
    $_SESSION['login_error'] = "Anda Harus Login Terlebih Dahulu!!!";
    header("Location: index.php");
    exit;
}

// Anti-cache headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_SESSION['welcome_message'])) {
    echo "<script>alert('" . $_SESSION['welcome_message'] . "');</script>";
    unset($_SESSION['welcome_message']); // Supaya tidak muncul lagi setelah refresh
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
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <link href="img/logo/image.jpg" rel="icon">
  <title>Showroom Mobil - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .car-card {
      transition: transform 0.2s;
    }
    .car-card:hover {
      transform: scale(1.05);
    }
    .car-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px 8px 0 0;
    }
    .carousel-inner {
      height: 300px; /* Tinggi slider */
    }
    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Pastikan gambar menutup area dengan proporsi yang baik */
    }
    .carousel-caption {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 10px;
      border-radius: 5px;
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

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <!-- Slider Mobil -->
          <div id="carouselShowroom" class="carousel slide mb-4" data-ride="carousel" data-interval="3000" data-pause="hover">
            <ol class="carousel-indicators">
              <li data-target="#carouselShowroom" data-slide-to="0" class="active"></li>
              <li data-target="#carouselShowroom" data-slide-to="1"></li>
              <li data-target="#carouselShowroom" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="img/logo/dbshoowroom2.jpg">
                <div class="carousel-caption d-none d-md-block">
                </div>
              </div>
              <div class="carousel-item">
                <img src="img/logo/brv2.jpg">
                <div class="carousel-caption d-none d-md-block">
                </div>
              </div>
              <div class="carousel-item">
                <img src="img/logo/civic4.jpg">
                <div class="carousel-caption d-none d-md-block">
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselShowroom" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselShowroom" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <!-- Card Row -->
          <div class="row mb-4">
            <!-- Jumlah Mobil -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card bg-primary text-white shadow">
                <div class="card-body">
                  <i class="fas fa-car fa-fw"></i> Jumlah Mobil
                  <div class="text-white-50 small mt-2">25 Unit</div>
                </div>
              </div>
            </div>
            <!-- Jumlah Pelanggan -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card bg-success text-white shadow">
                <div class="card-body">
                  <i class="fas fa-users fa-fw"></i> Pelanggan
                  <div class="text-white-50 small mt-2">14 Orang</div>
                </div>
              </div>
            </div>
            <!-- Jumlah Transaksi -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card bg-warning text-white shadow">
                <div class="card-body">
                  <i class="fas fa-receipt fa-fw"></i> Transaksi
                  <div class="text-white-50 small mt-2">32 Transaksi</div>
                </div>
              </div>
            </div>
            <!-- Pendapatan -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card bg-danger text-white shadow">
                <div class="card-body">
                  <i class="fas fa-money-bill-wave fa-fw"></i> Pendapatan Bulan Ini
                  <div class="text-white-50 small mt-2">Rp 126.000.000.000</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobil Terbaru dengan Foto -->
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-car-side"></i> Mobil Terbaru
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card car-card shadow">
                    <img src="img/logo/Toyota-Vel2.jpg" class="card-img-top car-image" alt="Avanza Veloz">
                    <div class="card-body">
                      <h5 class="card-title">Avanza Veloz</h5>
                      <p class="card-text"><strong>Merek:</strong> Toyota</p>
                      <p class="card-text"><strong>Tahun:</strong> 2022</p>
                      <p class="card-text"><strong>Harga:</strong> Rp 250.000.000</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card car-card shadow">
                    <img src="img/logo/brv.jpg" class="card-img-top car-image" alt="BR-V Prestige">
                    <div class="card-body">
                      <h5 class="card-title">BR-V Prestige</h5>
                      <p class="card-text"><strong>Merek:</strong> Honda</p>
                      <p class="card-text"><strong>Tahun:</strong> 2023</p>
                      <p class="card-text"><strong>Harga:</strong> Rp 280.000.000</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card car-card shadow">
                    <img src="img/logo/civic.jpg" class="card-img-top car-image" alt="Civic Type R">
                    <div class="card-body">
                      <h5 class="card-title">Civic Type R</h5>
                      <p class="card-text"><strong>Merek:</strong> Honda</p>
                      <p class="card-text"><strong>Tahun:</strong> 2024</p>
                      <p class="card-text"><strong>Harga:</strong> Rp 800.000.000</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- Footer -->
      <?php include 'footer.php'; ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Modal Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh Tidak!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apa Kamu Serius Ingin Keluar???</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tidak</button>
          <a href="logout.php" class="btn btn-primary">Keluar</a>
        </div>
      </div>
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
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
  <script>
    // Cegah tombol kembali untuk memuat halaman dari cache
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
      history.go(1);
      window.location.href = 'index.php';
    };
  </script>
</body>

</html>