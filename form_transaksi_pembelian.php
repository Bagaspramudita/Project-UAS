<?php
include "session.php";
include "config/koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$current_date_time = date('h:i A T \o\n l, F j, Y', strtotime('06:38 PM WIB'));

// Inisialisasi nilai default
$id_transaksi = 0;
$id_pelanggan = 0;
$id_mobil = 0;
$nama = ''; // Akan diisi otomatis dari tbl_pelanggan
$jumlah = 0;
$harga_satuan = 0.00;
$harga_total = 0.00;
$tanggal_pembelian = date('Y-m-d');
$metode_pembayaran = ''; // Akan diisi dari tabel metode_pembayaran
$status_pembayaran = 'Kredit'; // Default status pembayaran
$is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id_transaksi = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_transaksi_pembelian WHERE id_transaksi = '$id_transaksi'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $id_pelanggan = $data['id_pelanggan'];
        $id_mobil = $data['id_mobil'];
        $nama = $data['nama']; // Tetap diambil untuk edit
        $jumlah = $data['jumlah'];
        $harga_satuan = $data['harga_satuan'];
        $harga_total = $data['harga_total'];
        $tanggal_pembelian = $data['tanggal_pembelian'];
        $metode_pembayaran = $data['metode_pembayaran']; // Ambil nilai dari tabel lama
        $status_pembayaran = $data['status_pembayaran'];
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
   <title>Showroom Transaksi Pembelian - Dashboard</title>
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
   <link href="css/ruang-admin.min.css" rel="stylesheet">
   <script src="vendor/jquery/jquery.min.js"></script>
   <script>
       $(document).ready(function() {
           $('#id_pelanggan').on('change', function() {
               var nama = $(this).find(':selected').data('nama');
               $('input[name="nama"]').val(nama);
           });

           $('#id_mobil').on('change', function() {
               var harga = $(this).find(':selected').data('harga');
               var stok = $(this).find(':selected').data('stok');
               $('#harga_satuan').val(harga);
               $('#stok_info').text('Stok Tersedia: ' + stok);
               updateTotal();
           });

           $('#jumlah').on('input', function() {
               updateTotal();
           });

           function updateTotal() {
               var jumlah = parseFloat($('#jumlah').val()) || 0;
               var harga_satuan = parseFloat($('#harga_satuan').val()) || 0;
               var total = jumlah * harga_satuan;
               $('#harga_total').val(total.toFixed(2));
           }

           // Inisialisasi nama pelanggan dan harga satuan serta total saat halaman dimuat jika ada data edit
           if ($('#id_pelanggan').val()) {
               var nama = $('#id_pelanggan').find(':selected').data('nama');
               $('input[name="nama"]').val(nama);
           }
           if ($('#id_mobil').val()) {
               var harga = $('#id_mobil').find(':selected').data('harga');
               var stok = $('#id_mobil').find(':selected').data('stok');
               $('#harga_satuan').val(harga);
               $('#stok_info').text('Stok Tersedia: ' + stok);
               updateTotal();
           }
       });
   </script>
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
                        <h1 class="display-5 fw-bolder mb-6">🚗 Data Transaksi Pembelian</h1>
                        <div class="card-body">
                           <form action="<?php echo $is_edit ? 'proses_edit_transaksi_pembelian.php' : 'proses_transaksi_pembelian.php'; ?>" method="post">
                              <?php if ($is_edit): ?>
                                 <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                                 <input type="hidden" name="nama" value="<?php echo htmlspecialchars($nama); ?>">
                              <?php else: ?>
                                 <?php
                                 // Ambil nama pelanggan otomatis berdasarkan id_pelanggan yang dipilih
                                 $pelanggan_query = mysqli_query($koneksi, "SELECT id_pelanggan, nama FROM tbl_pelanggan");
                                 ?>
                                 <div class="mb-3">
                                    <label for="id_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                                       <option value="" disabled>Pilih Pelanggan</option>
                                       <?php
                                       while ($pelanggan = mysqli_fetch_assoc($pelanggan_query)) {
                                           $sel = ($id_pelanggan == $pelanggan['id_pelanggan']) ? 'selected' : '';
                                           echo "<option value='{$pelanggan['id_pelanggan']}' data-nama='{$pelanggan['nama']}' $sel>{$pelanggan['nama']}</option>";
                                       }
                                       ?>
                                    </select>
                                    <input type="hidden" name="nama" value="<?php echo htmlspecialchars($nama); ?>">
                                 </div>
                              <?php endif; ?>
                              <div class="mb-3">
                                 <label for="id_mobil" class="form-label">Nama Mobil (Stok)</label>
                                 <select class="form-control" id="id_mobil" name="id_mobil" required>
                                    <option value="" disabled>Pilih Mobil</option>
                                    <?php
                                    $mobil_query = mysqli_query($koneksi, "SELECT id_mobil, nama_mobil, merek, tipe, warna, tahun, harga, stok FROM tbl_mobil WHERE stok > 0");
                                    while ($mobil = mysqli_fetch_assoc($mobil_query)) {
                                        $sel = ($id_mobil == $mobil['id_mobil']) ? 'selected' : '';
                                        echo "<option value='{$mobil['id_mobil']}' data-harga='{$mobil['harga']}' data-stok='{$mobil['stok']}' $sel>{$mobil['nama_mobil']} ({$mobil['merek']}, {$mobil['tipe']}, {$mobil['warna']}, {$mobil['tahun']}) - Stok: {$mobil['stok']}</option>";
                                    }
                                    ?>
                                 </select>
                                 <small id="stok_info" class="form-text text-muted"></small>
                              </div>
                              <div class="mb-3">
                                 <label for="jumlah" class="form-label">Jumlah</label>
                                 <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required value="<?php echo htmlspecialchars($jumlah); ?>">
                              </div>
                              <div class="mb-3">
                                 <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
                                 <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" step="0.01" required value="<?php echo htmlspecialchars($harga_satuan); ?>" readonly>
                              </div>
                              <div class="mb-3">
                                 <label for="harga_total" class="form-label">Harga Total (Rp)</label>
                                 <input type="number" class="form-control" id="harga_total" name="harga_total" step="0.01" value="<?php echo htmlspecialchars($harga_total); ?>" readonly>
                              </div>
                              <div class="mb-3">
                                 <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                                 <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembayaran" required value="<?php echo htmlspecialchars($tanggal_pembelian); ?>">
                              </div>
                              <div class="mb-3">
                                 <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                 <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                                    <option value="" disabled>Pilih Metode Pembayaran</option>
                                    <?php
                                    $metode_query = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran");
                                    while ($metode = mysqli_fetch_assoc($metode_query)) {
                                        $sel = ($metode_pembayaran == $metode['nama_metode']) ? 'selected' : '';
                                        echo "<option value='{$metode['nama_metode']}' $sel>{$metode['nama_metode']}</option>";
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="mb-3">
                                 <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                 <select class="form-control" id="status_pembayaran" name="status_pembayaran" required>
                                    <option value="Lunas" <?php echo ($status_pembayaran == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                                    <option value="Kredit" <?php echo ($status_pembayaran == 'Kredit') ? 'selected' : ''; ?>>Kredit</option>
                                 </select>
                              </div>
                              <div class="mb-3 text-end">
                                 <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Transaksi' : 'Simpan Transaksi'; ?></button>
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
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
   </body>
</html>