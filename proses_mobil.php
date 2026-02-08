<?php
include "session.php";
include 'config/koneksi.php';

// Ambil data dari form dan sanitasi
$nama_mobil = mysqli_real_escape_string($koneksi, $_POST['nama_mobil']);
$merek = mysqli_real_escape_string($koneksi, $_POST['merek']);
$tipe = mysqli_real_escape_string($koneksi, $_POST['tipe']);
$warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
$tahun = (int)$_POST['tahun'];
$harga = (float)$_POST['harga'];
$stok = (int)$_POST['stok'];

// Cek apakah kombinasi tipe, warna, dan tahun sudah ada
$cek = mysqli_query($koneksi, "SELECT * FROM tbl_mobil WHERE tipe = '$tipe' AND warna = '$warna' AND tahun = '$tahun'");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Tipe, warna, dan tahun sudah terdaftar! Silakan gunakan kombinasi yang lain.');
            window.location.href = 'form-mobil.php';
          </script>";
} else {
    // Simpan ke database
    $query = mysqli_query($koneksi, "INSERT INTO tbl_mobil 
        (nama_mobil, merek, tipe, warna, tahun, harga, stok)
        VALUES 
        ('$nama_mobil', '$merek', '$tipe', '$warna', '$tahun', '$harga', '$stok')");

    if ($query) {
        echo "<script>
                alert('Data mobil berhasil ditambahkan!');
                window.location.href = 'tampil_mobil.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data mobil: " . mysqli_error($koneksi) . "');
                window.location.href = 'form-mobil.php';
              </script>";
    }
}
?>