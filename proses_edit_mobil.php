<?php
include "session.php";
include 'config/koneksi.php';

// Tangkap data dari form dan sanitasi
$id_mobil = (int)$_POST['id_mobil'];
$nama_mobil = mysqli_real_escape_string($koneksi, $_POST['nama_mobil']);
$merek = mysqli_real_escape_string($koneksi, $_POST['merek']);
$tipe = mysqli_real_escape_string($koneksi, $_POST['tipe']);
$warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
$tahun = (int)$_POST['tahun'];
$harga = (float)$_POST['harga'];
$stok = (int)$_POST['stok'];

// Update data mobil ke database
$query = mysqli_query($koneksi, "UPDATE tbl_mobil SET 
    nama_mobil = '$nama_mobil',
    merek = '$merek',
    tipe = '$tipe',
    warna = '$warna',
    tahun = '$tahun',
    harga = '$harga',
    stok = '$stok'
    WHERE id_mobil = '$id_mobil'");

if ($query) {
    echo "<script>
            alert('Data mobil berhasil diperbarui!');
            window.location.href = 'tampil_mobil.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal update data: " . mysqli_error($koneksi) . "');
            window.location.href = 'form-mobil.php?id=$id_mobil';
          </script>";
}
?>