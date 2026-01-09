<?php 
include 'auth_check.php'; 
include 'db.php'; 

// Proses saat tombol simpan ditekan
if (isset($_POST['submit'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']); // Opsional jika tabelmu ada kolom kategori

    // Pengaturan Upload Foto
    $target_dir = "uploads/";
    
    // Buat folder uploads otomatis jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $_FILES['foto']['name'];
    $file_tmp  = $_FILES['foto']['tmp_name'];
    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Buat nama file unik (contoh: 1712345678.jpg)
    $new_file_name = time() . '.' . $file_ext;
    $target_file   = $target_dir . $new_file_name;

    // Validasi file
    $allowed_ext = array("jpg", "jpeg", "png", "webp");

    if (in_array($file_ext, $allowed_ext)) {
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Masukkan ke database (sesuaikan nama kolom 'icon_or_img' dengan database kamu)
            $query = "INSERT INTO items (name, price, icon_or_img) VALUES ('$nama', '$harga', '$new_file_name')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Produk Berhasil Ditambahkan!'); window.location='admin.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal upload file.');</script>";
        }
    } else {
        echo "<script>alert('Format file harus JPG, PNG, atau WEBP.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Adiba</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #0a0a0a; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #161616; padding: 30px; border-radius: 15px; border: 1px solid #2a2a2a; width: 100%; max-width: 400px; }
        h2 { color: #f9ab00; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 8px; color: #888; font-size: 0.9rem; }
        input, select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #2a2a2a; background: #0a0a0a; color: white; box-sizing: border-box; }
        input[type="file"] { padding: 8px; background: #161616; cursor: pointer; }
        .btn-submit { width: 100%; padding: 12px; background: #f9ab00; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; transition: 0.3s; }
        .btn-submit:hover { background: #ffb700; transform: translateY(-2px); }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="card">
    <h2>Tambah Item Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Item</label>
            <input type="text" name="nama" placeholder="Contoh: Print Warna" required>
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="SERVICE">SERVICE (Jasa)</option>
                <option value="PRODUK">PRODUK (Barang)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" placeholder="Contoh: 2000" required>
        </div>

        <div class="form-group">
            <label>Foto Produk (Upload)</label>
            <input type="file" name="foto" accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn-submit">SIMPAN PRODUK</button>
        <a href="admin.php" class="btn-back">Kembali</a>
    </form>
</div>

</body>
</html>