<?php
include "session.php";
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_metode = isset($_POST['id_metode']) ? (int)$_POST['id_metode'] : 0;
    $nama_metode = trim($_POST['nama_metode']);
    $foto_metode = isset($_FILES['foto_metode']) ? $_FILES['foto_metode'] : null;

    $foto_path = '';

    try {
        // Handle upload foto
        if ($foto_metode && $foto_metode['error'] == UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png'];
            $max_size = 2 * 1024 * 1024; // 2MB
            if (!in_array($foto_metode['type'], $allowed_types)) {
                throw new Exception("Hanya file JPG/PNG yang diperbolehkan!");
            }
            if ($foto_metode['size'] > $max_size) {
                throw new Exception("Ukuran file tidak boleh lebih dari 2MB!");
            }

            $upload_dir = "uploads/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $foto_name = uniqid() . '_' . basename($foto_metode['name']);
            $foto_path = $upload_dir . $foto_name;
            move_uploaded_file($foto_metode['tmp_name'], $foto_path);

            // Hapus foto lama jika ada dan ini edit
            if ($id_metode > 0) {
                $old_query = mysqli_query($koneksi, "SELECT foto_metode FROM metode_pembayaran WHERE id_metode = '$id_metode'");
                $old_data = mysqli_fetch_assoc($old_query);
                if ($old_data['foto_metode'] && file_exists($old_data['foto_metode'])) {
                    unlink($old_data['foto_metode']);
                }
            }
        } elseif ($id_metode > 0) {
            // Ambil foto lama jika tidak ada upload baru
            $old_query = mysqli_query($koneksi, "SELECT foto_metode FROM metode_pembayaran WHERE id_metode = '$id_metode'");
            $old_data = mysqli_fetch_assoc($old_query);
            $foto_path = $old_data['foto_metode'] ?: '';
        }

        if ($id_metode > 0) {
            // Update metode pembayaran
            $update_query = mysqli_prepare($koneksi, "UPDATE metode_pembayaran SET nama_metode = ?, foto_metode = ? WHERE id_metode = ?");
            mysqli_stmt_bind_param($update_query, "ssi", $nama_metode, $foto_path, $id_metode);
            mysqli_stmt_execute($update_query);
            $message = "Metode pembayaran berhasil diperbarui!";
        } else {
            // Tambah metode pembayaran baru
            $check_query = mysqli_query($koneksi, "SELECT id_metode FROM metode_pembayaran WHERE nama_metode = '$nama_metode'");
            if (mysqli_num_rows($check_query) > 0) {
                throw new Exception("Metode pembayaran sudah ada!");
            }
            $insert_query = mysqli_prepare($koneksi, "INSERT INTO metode_pembayaran (nama_metode, foto_metode) VALUES (?, ?)");
            mysqli_stmt_bind_param($insert_query, "ss", $nama_metode, $foto_path);
            mysqli_stmt_execute($insert_query);
            $message = "Metode pembayaran berhasil ditambahkan!";
        }

        echo "<script>alert('$message'); window.location='tampil_metode_pembayaran.php';</script>";
        exit;
    } catch (Exception $e) {
        if ($foto_path && file_exists($foto_path)) {
            unlink($foto_path); // Hapus file jika error
        }
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location='tampil_metode_pembayaran.php';</script>";
        exit;
    }
}

// Proses hapus metode pemabayaran
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $delete_query = mysqli_prepare($koneksi, "SELECT foto_metode FROM metode_pembayaran WHERE id_metode = ?");
    mysqli_stmt_bind_param($delete_query, "i", $delete_id);
    mysqli_stmt_execute($delete_query);
    $result = mysqli_stmt_get_result($delete_query);
    $old_data = mysqli_fetch_assoc($result);
    if ($old_data['foto_metode'] && file_exists($old_data['foto_metode'])) {
        unlink($old_data['foto_metode']);
    }

    $delete_query = mysqli_prepare($koneksi, "DELETE FROM metode_pembayaran WHERE id_metode = ?");
    mysqli_stmt_bind_param($delete_query, "i", $delete_id);
    if (mysqli_stmt_execute($delete_query)) {
        echo "<script>alert('Metode pembayaran berhasil dihapus'); window.location='tampil_metode_pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus metode pembayaran: " . mysqli_error($koneksi) . "'); window.location='tampil_metode_pembayaran.php';</script>";
    }
    exit;
}
?> 