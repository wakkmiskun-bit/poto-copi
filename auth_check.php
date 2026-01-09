<?php
// File ini digunakan untuk memproteksi halaman admin
// Include file ini di setiap halaman admin yang ingin diproteksi

session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit;
}

// Fungsi untuk logout (optional, bisa dipanggil dari halaman lain)
function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>