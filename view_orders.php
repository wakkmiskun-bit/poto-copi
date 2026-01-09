<?php include 'db.php'; ?>
<?php include 'auth_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Masuk</title>
    <style>
        body { font-family: sans-serif; background: #121212; color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #1e1e1e; }
        th, td { padding: 15px; border: 1px solid #333; }
        th { background: #f9ab00; color: black; }
    </style>
</head>
<body>
    <h2>Riwayat Pesanan Pelanggan</h2>
    <a href="admin.php" style="color: gold;"> Kembali ke Admin</a>
    <br><br>
    <table>
        <tr>
            <th>Nama</th>
            <th>No. HP</th>
            <th>Produk</th>
            <th>Waktu</th>
        </tr>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
        while($r = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $r['customer_name'] ?></td>
            <td><?= $r['customer_phone'] ?></td>
            <td><?= $r['item_name'] ?></td>
            <td><?= $r['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>