<?php
include "session.php";
include 'config/koneksi.php';

// Tangkap data dari form dan sanitasi
$id_pelanggan = (int)$_POST['id_pelanggan'];
$id_mobil = (int)$_POST['id_mobil'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$jumlah = (int)$_POST['jumlah'];
$harga_satuan = mysqli_real_escape_string($koneksi, $_POST['harga_satuan']);
$harga_total = mysqli_real_escape_string($koneksi, $_POST['harga_total']);
$tanggal_pembelian = mysqli_real_escape_string($koneksi, $_POST['tanggal_pembayaran']);
$metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
$status_pembayaran = mysqli_real_escape_string($koneksi, $_POST['status_pembayaran']);

// Kurangi stok mobil (manual check karena tidak ada foreign key)
$mobil_query = mysqli_query($koneksi, "SELECT stok FROM tbl_mobil WHERE id_mobil = '$id_mobil'");
if (mysqli_num_rows($mobil_query) > 0) {
    $mobil_data = mysqli_fetch_assoc($mobil_query);
    $new_stok = $mobil_data['stok'] - $jumlah;

    if ($new_stok >= 0) {
        // Update stok mobil
        mysqli_query($koneksi, "UPDATE tbl_mobil SET stok = '$new_stok' WHERE id_mobil = '$id_mobil'");

        // Simpan data transaksi
        $query = mysqli_query($koneksi, "INSERT INTO tbl_transaksi_pembelian (id_pelanggan, id_mobil, nama, jumlah, harga_satuan, harga_total, tanggal_pembelian, metode_pembayaran, status_pembayaran) 
            VALUES ('$id_pelanggan', '$id_mobil', '$nama', '$jumlah', '$harga_satuan', '$harga_total', '$tanggal_pembelian', '$metode_pembayaran', '$status_pembayaran')");

        if ($query) {
            echo "<script>
                    alert('Transaksi berhasil disimpan!');
                    window.location.href = 'tampil_transaksi_pembelian.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menyimpan transaksi: " . mysqli_error($koneksi) . "');
                    window.location.href = 'form_transaksi_pembelian.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Stok mobil tidak cukup!');
                window.location.href = 'form_transaksi_pembelian.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Mobil dengan ID tersebut tidak ditemukan!');
            window.location.href = 'form_transaksi_pembelian.php';
          </script>";
}
?>