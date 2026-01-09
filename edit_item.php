<?php 
include 'db.php'; 
<?php include 'auth_check.php'; ?>

// Cek apakah ada ID yang dikirim melalui URL
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

// Keamanan: Membersihkan input ID
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Mengambil data lama dari database
$query = mysqli_query($conn, "SELECT * FROM items WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Jika ID tidak ditemukan di database
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='admin.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item - Adiba Photocopy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #f9ab00; --bg-dark: #121212; --bg-card: #1e1e1e; }
        body { background: var(--bg-dark); color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        form { background: var(--bg-card); padding: 40px; border-radius: 15px; width: 100%; max-width: 400px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h3 { color: var(--primary); margin-top: 0; text-align: center; font-size: 1.5rem; text-transform: uppercase; letter-spacing: 1px; }
        label { font-size: 0.85rem; color: #aaa; display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 12px; margin-top: 5px; box-sizing: border-box; background: #2a2a2a; border: 1px solid #444; color: white; border-radius: 8px; outline: none; transition: 0.3s; }
        input:focus { border-color: var(--primary); }
        button { width: 100%; padding: 12px; background: var(--primary); border: none; font-weight: bold; cursor: pointer; margin-top: 25px; border-radius: 8px; color: #000; text-transform: uppercase; transition: 0.3s; }
        button:hover { background: #ffc107; transform: translateY(-2px); }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #777; text-decoration: none; font-size: 0.85rem; }
        .back-link:hover { color: var(--primary); }
    </style>
</head>
<body>
    <form action="update_item.php" method="POST">
        <h3><i class="fas fa-edit"></i> Edit Item</h3>
        
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Nama Barang / Jasa</label>
        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required>

        <label>Kategori</label>
        <select name="category">
            <option value="service" <?= $data['category'] == 'service' ? 'selected' : '' ?>>SERVICE (Jasa)</option>
            <option value="product" <?= $data['category'] == 'product' ? 'selected' : '' ?>>PRODUCT (Barang/ATK)</option>
        </select>

        <label>Harga Satuan (Rp)</label>
        <input type="number" name="price" value="<?= $data['price'] ?>" required>

        <label>Ikon FontAwesome (Contoh: fa-print)</label>
        <input type="text" name="icon_or_img" value="<?= htmlspecialchars($data['icon_or_img']) ?>">

        <button type="submit" name="update">Update Data</button>
        
        <a href="admin.php" class="back-link">← Kembali ke Dashboard</a>
    </form>
</body>
</html>