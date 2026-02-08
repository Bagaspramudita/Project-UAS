<?php
session_start();

// Jika belum login, arahkan ke index dengan pesan
if (!isset($_SESSION['username'])) {
    $_SESSION['login_error'] = "Anda Harus Login Terlebih Dahulu!!!";
    header("Location: index.php");
    exit;
}


?>