<?php
include "session.php";
include 'config/koneksi.php';

// Tangkap data dari form dan sanitasi
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);

// Simpan data
$query = mysqli_query($koneksi, "INSERT INTO tbl_pelanggan (nama, alamat, no_telp, email) VALUES ('$nama', '$alamat', '$no_telp', '$email')");

if ($query) {
    echo "<script>
            alert('Pelanggan berhasil disimpan!');
            window.location.href = 'tampil_pelanggan.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menyimpan pelanggan: " . mysqli_error($koneksi) . "');
            window.location.href = 'form_pelanggan.php';
          </script>";
}
?>