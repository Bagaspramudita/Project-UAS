<?php
include "session.php";
include "config/koneksi.php";
// Inisialisasi variabel untuk edit
$id_metode = 0;
$nama_metode = '';
$foto_metode = '';
$is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id_metode = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran WHERE id_metode = '$id_metode'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $nama_metode = $data['nama_metode'];
        $foto_metode = $data['foto_metode'] ? $data['foto_metode'] : '';
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
    <title>Showroom Metode Pembayaran - Dashboard</title>
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $is_edit ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran'; ?></h6>
                        </div>
                        <div class="card-body">
                            <form action="proses_metode_pembayaran.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_metode" value="<?php echo $id_metode; ?>">
                                <div class="mb-3">
                                    <label for="nama_metode" class="form-label">Nama Metode Pembayaran</label>
                                    <input type="text" class="form-control" id="nama_metode" name="nama_metode" value="<?php echo htmlspecialchars($nama_metode); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="foto_metode" class="form-label">Unggah Foto Metode (JPG/PNG, max 2MB)</label>
                                    <input type="file" class="form-control" id="foto_metode" name="foto_metode" accept=".jpg,.jpeg,.png">
                                    <?php if ($is_edit && $foto_metode): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo htmlspecialchars($foto_metode); ?>" alt="Foto Metode" style="max-width: 200px; max-height: 200px;">
                                            <p class="text-muted">Biarkan kosong untuk mempertahankan gambar lama.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Metode' : 'Simpan Metode'; ?></button>
                                    <a href="tampil_metode_pembayaran.php" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
    </body>
</html>