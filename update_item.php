<?php
include 'db.php';

// Pastikan data dikirim melalui tombol 'update'
if(isset($_POST['update'])){
    
    // Membersihkan input agar aman dari serangan SQL Injection
    $id       = mysqli_real_escape_string($conn, $_POST['id']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $price    = mysqli_real_escape_string($conn, $_POST['price']);
    $icon     = mysqli_real_escape_string($conn, $_POST['icon_or_img']);

    // Menjalankan Query Update
    $sql = "UPDATE items SET 
            category = '$category', 
            name     = '$name', 
            price    = '$price', 
            icon_or_img = '$icon' 
            WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)){
        // Jika berhasil, balikkan ke halaman admin
        header("location:admin.php?status=sukses_update");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error saat memperbarui data: " . mysqli_error($conn);
    }
} else {
    // Jika mencoba akses file ini secara langsung tanpa form
    header("location:admin.php");
}
?>