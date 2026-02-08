<?php
include "session.php";
include "config/koneksi.php";

// Inisialisasi nilai default
$id_pelanggan = 0;
$nama = '';
$alamat = '';
$no_telp = '';
$email = '';
$is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id_pelanggan = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];
        $email = $data['email'];
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
   <title>Showroom Pelanggan - Dashboard</title>
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
      <?php include 'menu_kiri.php'; ?>
      <!-- Sidebar -->
      <div id="content-wrapper" class="d-flex flex-column">
         <div id="content">
            <!-- TopBar -->
            <?php include 'header.php'; ?>
            <!-- Topbar -->
            <div class="main-content">
               <div class="container-fluid">
                  <div class="col-md-6">
                     <div class="card" style="min-height: 484px;">
                        <h1 class="display-6 fw-bolder mb-3">👤 <?php echo $is_edit ? 'Edit Pelanggan' : 'Tambah Pelanggan'; ?></h1>
                        <div class="card-body">
                           <div class="button-container">
                              <a href="tampil_pelanggan.php" class="btn btn-primary back-button">Daftar Pelanggan</a>
                           </div>
                           <form action="<?php echo $is_edit ? 'proses_edit_pelanggan.php' : 'proses_pelanggan.php'; ?>" method="post">
                              <?php if ($is_edit): ?>
                                 <input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>">
                              <?php endif; ?>
                              <div class="mb-3">
                                 <label for="nama" class="form-label">Nama Pelanggan</label>
                                 <input type="text" class="form-control" id="nama" name="nama" required value="<?php echo htmlspecialchars($nama); ?>">
                              </div>
                              <div class="mb-3">
                                 <label for="alamat" class="form-label">Alamat</label>
                                 <textarea class="form-control" id="alamat" name="alamat" required><?php echo htmlspecialchars($alamat); ?></textarea>
                              </div>
                              <div class="mb-3">
                                 <label for="no_telp" class="form-label">No Telepon</label>
                                 <input type="text" class="form-control" id="no_telp" name="no_telp" required value="<?php echo htmlspecialchars($no_telp); ?>">
                              </div>
                              <div class="mb-3">
                                 <label for="email" class="form-label">Email</label>
                                 <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                              </div>
                              <div class="mb-3 text-end">
                                 <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Pelanggan' : 'Simpan Pelanggan'; ?></button>
                                 <button type="reset" class="btn btn-secondary">Batal</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
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
               </div>
            </div>
            <footer class="footer">
               <?php include 'footer.php'; ?>
            </footer>
         </div>
      </div>
      <a class="scroll-to-top rounded" href="#page-top">
         <i class="fas fa-angle-up"></i>
      </a>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
   </body>
</html>