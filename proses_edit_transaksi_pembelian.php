<?php
include "session.php";
include 'config/koneksi.php';

// Tangkap data dari form dan sanitasi
$id_transaksi = (int)$_POST['id_transaksi'];
$id_pelanggan = (int)$_POST['id_pelanggan'];
$id_mobil = (int)$_POST['id_mobil'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$jumlah = (int)$_POST['jumlah'];
$harga_satuan = mysqli_real_escape_string($koneksi, $_POST['harga_satuan']);
$harga_total = mysqli_real_escape_string($koneksi, $_POST['harga_total']);
$tanggal_pembelian = mysqli_real_escape_string($koneksi, $_POST['tanggal_pembayaran']);
$metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
$status_pembayaran = mysqli_real_escape_string($koneksi, $_POST['status_pembayaran']);

// Ambil data transaksi lama untuk menghitung perubahan stok
$old_query = mysqli_query($koneksi, "SELECT jumlah, id_mobil FROM tbl_transaksi_pembelian WHERE id_transaksi = '$id_transaksi'");
if (mysqli_num_rows($old_query) > 0) {
    $old_data = mysqli_fetch_assoc($old_query);
    $old_jumlah = $old_data['jumlah'];
    $old_id_mobil = $old_data['id_mobil'];
    $new_stok_change = $old_jumlah - $jumlah;

    // Update stok mobil lama
    $mobil_query = mysqli_query($koneksi, "SELECT stok FROM tbl_mobil WHERE id_mobil = '$old_id_mobil'");
    if (mysqli_num_rows($mobil_query) > 0) {
        $mobil_data = mysqli_fetch_assoc($mobil_query);
        $current_stok = $mobil_data['stok'] + $new_stok_change;

        if ($current_stok >= 0) {
            mysqli_query($koneksi, "UPDATE tbl_mobil SET stok = '$current_stok' WHERE id_mobil = '$old_id_mobil'");

            // Update stok mobil baru jika ID mobil berubah
            if ($old_id_mobil != $id_mobil) {
                $new_mobil_query = mysqli_query($koneksi, "SELECT stok FROM tbl_mobil WHERE id_mobil = '$id_mobil'");
                if (mysqli_num_rows($new_mobil_query) > 0) {
                    $new_mobil_data = mysqli_fetch_assoc($new_mobil_query);
                    $new_stok = $new_mobil_data['stok'] - $jumlah;
                    if ($new_stok >= 0) {
                        mysqli_query($koneksi, "UPDATE tbl_mobil SET stok = '$new_stok' WHERE id_mobil = '$id_mobil'");
                    } else {
                        echo "<script>
                                alert('Stok mobil baru tidak cukup!');
                                window.location.href = 'form_transaksi_pembelian.php?id=$id_transaksi';
                              </script>";
                        exit;
                    }
                }
            }

            // Update data transaksi
            $query = mysqli_query($koneksi, "UPDATE tbl_transaksi_pembelian SET id_pelanggan = '$id_pelanggan', id_mobil = '$id_mobil', nama = '$nama', jumlah = '$jumlah', 
                harga_satuan = '$harga_satuan', harga_total = '$harga_total', tanggal_pembelian = '$tanggal_pembelian', 
                metode_pembayaran = '$metode_pembayaran', status_pembayaran = '$status_pembayaran' 
                WHERE id_transaksi = '$id_transaksi'");

            if ($query) {
                echo "<script>
                        alert('Transaksi berhasil diperbarui!');
                        window.location.href = 'tampil_transaksi_pembelian.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal memperbarui transaksi: " . mysqli_error($koneksi) . "');
                        window.location.href = 'form_transaksi_pembelian.php?id=$id_transaksi';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Stok mobil tidak cukup setelah perubahan!');
                    window.location.href = 'form_transaksi_pembelian.php?id=$id_transaksi';
                  </script>";
        }
    }
}
?>