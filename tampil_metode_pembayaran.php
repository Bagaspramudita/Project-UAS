<?php
include "session.php";
include "config/koneksi.php";
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
    <style>
        .method-card {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: box-shadow 0.3s;
            position: relative;
            overflow: hidden;
            height: 350px; /* Membesarkan kotak */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .method-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .method-card img {
            max-width: 100%;
            height: 200px; /* Membesarkan gambar */
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .card-content {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .action-btn {
            margin: 0 5px;
            padding: 8px 15px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        .edit-btn {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .edit-btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .delete-btn {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .delete-btn:hover {
            background-color: #c82333;
            border-color: #c82333;
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
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h4 mb-0 text-gray-800">Daftar Metode Pembayaran</h1>
                        <a href="form_metode_pembayaran.php" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Metode</a>
                    </div>
                    <div class="row">
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran");
                        while ($data = mysqli_fetch_assoc($query)) {
                            echo "<div class='col-md-4'>";
                            echo "<div class='method-card'>";
                            echo "<div class='card-content'>";
                            if ($data['foto_metode']) {
                                echo "<img src='" . htmlspecialchars($data['foto_metode']) . "' alt='Foto " . htmlspecialchars($data['nama_metode']) . "' class='img-fluid mb-3'>";
                            } else {
                                echo "<div style='height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;'><i class='fas fa-image fa-5x text-muted'></i></div>";
                            }
                            echo "<h5 class='card-title'>" . htmlspecialchars($data['nama_metode']) . "</h5>";
                            echo "<div class='btn-group mt-3' role='group'>";
                            echo "<a href='form_metode_pembayaran.php?id=" . $data['id_metode'] . "' class='btn btn-sm edit-btn action-btn' title='Edit Gambar'><i class='fas fa-camera'></i></a>";
                            echo "<a href='proses_metode_pembayaran.php?delete_id=" . $data['id_metode'] . "' class='btn btn-sm delete-btn action-btn' title='Hapus' onclick='return confirm(\"Yakin hapus metode ini?\")'><i class='fas fa-trash-alt'></i></a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        if (mysqli_num_rows($query) == 0) {
                            echo "<div class='col-12'><p class='text-center text-muted'>Tidak ada metode pembayaran yang tersedia.</p></div>";
                        }
                        ?>
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