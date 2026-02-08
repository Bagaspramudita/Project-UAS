<?php
session_start();
include "config/koneksi.php";

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek ke database (gunakan prepared statements untuk produksi)
    $query = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        // Login berhasil
        session_regenerate_id(true); // Regenerate session ID untuk keamanan
        $_SESSION['username'] = $username;
        $_SESSION['welcome_message'] = "Selamat Datang di Showroom Biispace!!!";
        header("Location: dashboard.php");
        exit;
    } else {
        // Login gagal
        $_SESSION['login_error'] = "Username atau Password salah!";
        header("Location: index.php");
        exit;
    }
}
?>
