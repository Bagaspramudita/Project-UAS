<?php
include "session.php";
include "config/koneksi.php";

// Proses hapus jika ada parameter 'action' dan 'id'
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id_pelanggan = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tbl_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    if ($query) {
        echo "<script>
                alert('Pelanggan berhasil dihapus!');
                window.location.href = 'tampil_pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus pelanggan: " . mysqli_error($koneksi) . "');
                window.location.href = 'tampil_pelanggan.php';
              </script>";
    }
    exit;
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
      .action-btn {
         margin: 0 3px;
         padding: 6px 10px;
         font-size: 0.9rem;
         transition: all 0.2s ease;
      }
      .action-btn:hover {
         transform: translateY(-1px);
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
      .card-header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 1rem;
      }
      .btn-add {
         padding: 6px 12px;
         font-size: 0.9rem;
      }
   </style>
</head>
<body id="page-top">
   <div id="wrapper">
      <?php include 'menu_kiri.php'; ?>
      <div id="content-wrapper" class="d-flex flex-column">
         <div id="content">
            <?php include 'header.php'; ?>
            <div class="main-content">
               <div class="container-fluid">
                  <div class="col-md-12">
                     <div class="card shadow mb-4">
                        <div class="card-header">
                           <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
                           <a href="form-pelanggan.php" class="btn btn-primary btn-add">Tambah Pelanggan</a>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                 <thead>
                                    <tr>
                                       <th>No</th>
                                       <th>Nama</th>
                                       <th>Alamat</th>
                                       <th>No Telepon</th>
                                       <th>Email</th>
                                       <th>Aksi</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $no = 1;
                                    $query = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan");
                                    while ($data = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($data['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($data['alamat']) . "</td>";
                                        echo "<td>" . htmlspecialchars($data['no_telp']) . "</td>";
                                        echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                                        echo "<td class='text-center'>
                                            <div class='btn-group'>
                                                <a href='form-pelanggan.php?id=" . $data['id_pelanggan'] . "' class='btn btn-sm edit-btn action-btn' title='Edit' onclick='console.log(\"Redirecting to: form-pelanggan.php?id=" . $data['id_pelanggan'] . "\")'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                                <a href='tampil_pelanggan.php?action=hapus&id=" . $data['id_pelanggan'] . "' class='btn btn-sm delete-btn action-btn' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </a>
                                            </div>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <footer class="footer"><?php include 'footer.php'; ?></footer>
         </div>
      </div>
      <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
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