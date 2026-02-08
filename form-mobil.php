<?php
include "session.php";
include "config/koneksi.php";

$nama_mobil = "";
$merek = "";
$tipe = "";
$tahun = "";
$warna = "";
$harga = "";
$stok = "";
$is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_mobil WHERE id_mobil = '$id'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $nama_mobil = $data['nama_mobil'];
        $merek = $data['merek'];
        $tipe = $data['tipe'];
        $tahun = $data['tahun'];
        $warna = $data['warna'];
        $harga = $data['harga'];
        $stok = $data['stok'];
    }
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
   <title>Showroom Mobil - Dashboard</title>
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
      /* Mengatur tata letak tombol dan jarak */
      .button-container {
         display: flex;
         justify-content: flex-start;
         margin-bottom: 15px; /* Jarak antara tombol dan input Nama Pelanggan */
      }
      .back-button {
         margin-right: 10px; /* Jarak horizontal dari elemen lain jika ada */
      }
   </style>
</head>

<body id="page-top">
   <div id="wrapper">
      <!-- Sidebar -->
      <?php
      include 'menu_kiri.php';
      ?>
      <!-- Sidebar -->
      <div id="content-wrapper" class="d-flex flex-column">
         <div id="content">
            <!-- TopBar -->
            <?php
            include 'header.php';
            ?>
            <!-- Topbar -->

            <!-- Container Fluid-->
            <div class="main-content">
               <div class="container-fluid">
                  <div class="col-md-6">
                     <div class="card" style="min-height: 484px;">
                        <h1 class="display-6 fw-bolder mb-3">🚗 <?php echo $is_edit ? 'Edit Mobil Showroom' : 'Tambah Mobil Showroom'; ?></h1>
                        <div class="card-body">
                           <div class="button-container">
                              <a href="tampil_mobil.php" class="btn btn-primary back-button">Daftar Mobil</a>
                           </div>
                           <form action="<?php echo $is_edit ? 'proses_edit_mobil.php' : 'proses_mobil.php'; ?>" method="post">
                              <?php if ($is_edit): ?>
                                 <input type="hidden" name="id_mobil" value="<?php echo $id; ?>">
                              <?php endif; ?>

                              <div class="mb-3">
                                 <label for="nama_mobil" class="form-label">Nama Mobil</label>
                                 <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" required
                                    value="<?php echo htmlspecialchars($nama_mobil); ?>">
                              </div>

                              <div class="mb-3">
                                 <label for="merek" class="form-label">Merek</label>
                                 <select class="form-control" id="merek" name="merek" required>
                                    <option value="" disabled <?php echo $merek == "" ? "selected" : ""; ?>>Pilih Merek</option>
                                    <option value="Toyota" <?php echo $merek == "Toyota" ? "selected" : ""; ?>>Toyota</option>
                                    <option value="Honda" <?php echo $merek == "Honda" ? "selected" : ""; ?>>Honda</option>
                                    <option value="Suzuki" <?php echo $merek == "Suzuki" ? "selected" : ""; ?>>Suzuki</option>
                                    <option value="Mitsubishi" <?php echo $merek == "Mitsubishi" ? "selected" : ""; ?>>Mitsubishi</option>
                                    <option value="Daihatsu" <?php echo $merek == "Daihatsu" ? "selected" : ""; ?>>Daihatsu</option>
                                    <option value="Nissan" <?php echo $merek == "Nissan" ? "selected" : ""; ?>>Nissan</option>
                                    <option value="BMW" <?php echo $merek == "BMW" ? "selected" : ""; ?>>BMW</option>
                                    <option value="Mercedes-Benz" <?php echo $merek == "Mercedes-Benz" ? "selected" : ""; ?>>Mercedes-Benz</option>
                                    <option value="Audi" <?php echo $merek == "Audi" ? "selected" : ""; ?>>Audi</option>
                                    <option value="Hyundai" <?php echo $merek == "Hyundai" ? "selected" : ""; ?>>Hyundai</option>
                                    <option value="Chevrolet" <?php echo $merek == "Chevrolet" ? "selected" : ""; ?>>Chevrolet</option>
                                    <option value="Mazda" <?php echo $merek == "Mazda" ? "selected" : ""; ?>>Mazda</option>
                                 </select>
                              </div>

                              <div class="mb-3">
                                 <label for="tipe" class="form-label">Tipe</label>
                                 <input type="text" class="form-control" id="tipe" name="tipe" required
                                    value="<?php echo htmlspecialchars($tipe); ?>">
                              </div>

                              <div class="mb-3">
                                 <label for="tahun" class="form-label">Tahun</label>
                                 <select name="tahun" id="tahun" class="form-control" required>
                                    <option value="" disabled <?php echo $tahun == "" ? "selected" : ""; ?>>Pilih Tahun</option>
                                    <?php
                                    for ($th = 2020; $th <= 2025; $th++) {
                                       $sel = ($tahun == $th) ? "selected" : "";
                                       echo "<option value='$th' $sel>$th</option>";
                                    }
                                    ?>
                                 </select>
                              </div>

                              <div class="mb-3">
                                 <label for="warna" class="form-label">Warna</label>
                                 <input type="text" class="form-control" id="warna" name="warna" required
                                    value="<?php echo htmlspecialchars($warna); ?>">
                              </div>

                              <div class="mb-3">
                                 <label for="harga" class="form-label">Harga (Rp)</label>
                                 <input type="number" class="form-control" id="harga" name="harga" step="0.01" required
                                    value="<?php echo htmlspecialchars($harga); ?>">
                              </div>

                              <div class="mb-3">
                                 <label for="stok" class="form-label">Stok</label>
                                 <input type="number" class="form-control" id="stok" name="stok" required
                                    value="<?php echo htmlspecialchars($stok); ?>">
                              </div>

                              <div class="mb-3 text-end">
                                 <button type="submit" name="<?php echo $is_edit ? 'update' : 'tambah'; ?>" class="btn btn-primary">
                                    <?php echo $is_edit ? 'Update Mobil' : 'Tambah Mobil'; ?>
                                 </button>
                                 <button type="reset" class="btn btn-secondary">Batal</button>
                              </div>
                           </form>
                        </div>
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
                                 <span aria-hidden="true">&times;</span>
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
               </div>
               <!---Container Fluid-->
            </div>

            <!-- Footer -->
            <footer class="footer">
               <?php
               include 'footer.php';
               ?>
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
</body>

</html>