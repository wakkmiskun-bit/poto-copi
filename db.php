<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "copy"; // Pastikan nama database di XAMPP Anda adalah 'copy'

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>