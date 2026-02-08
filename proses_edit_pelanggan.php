<?php
include "session.php";
include 'config/koneksi.php';

// Tangkap data dari form dan sanitasi
$id_pelanggan = (int)$_POST['id_pelanggan'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);

// Update data
$query = mysqli_query($koneksi, "UPDATE tbl_pelanggan SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp', email = '$email' WHERE id_pelanggan = '$id_pelanggan'");

if ($query) {
    echo "<script>
            alert('Pelanggan berhasil diperbarui!');
            window.location.href = 'tampil_pelanggan.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui pelanggan: " . mysqli_error($koneksi) . "');
            window.location.href = 'form_pelanggan.php?id=$id_pelanggan';
          </script>";
}
?>