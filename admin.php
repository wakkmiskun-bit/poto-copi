<?php 
include 'auth_check.php'; // Proteksi halaman
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Adiba Photocopy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background: #0a0a0a; 
            color: white; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 20px;
        }
        
        .header {
            background: #161616;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px solid #2a2a2a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-left {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .header h2 {
            color: #f9ab00;
            font-size: 1.5rem;
        }
        
        .header h2 i {
            margin-right: 10px;
        }
        
        .welcome-text {
            color: #888;
            font-size: 0.9rem;
        }
        
        .welcome-text span {
            color: #f9ab00;
            font-weight: bold;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn { 
            padding: 10px 20px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }
        
        .btn-back {
            background: #2a2a2a;
            color: white;
        }
        
        .btn-back:hover {
            background: #3a3a3a;
            transform: translateY(-2px);
        }
        
        .btn-add { 
            background: #28a745; 
            color: white; 
        }
        
        .btn-add:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .btn-orders {
            background: #f9ab00;
            color: #000;
        }
        
        .btn-orders:hover {
            background: #ffb700;
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background: #dc3545;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .content-box { 
            background: #161616; 
            padding: 30px; 
            border-radius: 15px; 
            border: 1px solid #2a2a2a;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #0a0a0a;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #2a2a2a;
            text-align: center;
        }
        
        .stat-card i {
            font-size: 2rem;
            color: #f9ab00;
            margin-bottom: 10px;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            color: #f9ab00;
            margin: 10px 0 5px 0;
        }
        
        .stat-card p {
            color: #888;
            font-size: 0.9rem;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            background: #0a0a0a;
            border-radius: 10px;
            overflow: hidden;
        }
        
        th { 
            background: #f9ab00; 
            color: black; 
            padding: 15px; 
            text-align: left;
            font-weight: 600;
        }
        
        td { 
            padding: 15px; 
            border-bottom: 1px solid #2a2a2a;
        }
        
        tr:hover {
            background: #161616;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .action-links a {
            color: #f9ab00;
            text-decoration: none;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .action-links a:hover {
            color: #ffb700;
        }
        
        .action-links .delete {
            color: #dc3545;
        }
        
        .action-links .delete:hover {
            color: #ff4757;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h2 {
                font-size: 1.2rem;
            }
            
            .btn {
                padding: 8px 15px;
                font-size: 0.85rem;
            }
            
            .content-box {
                padding: 20px;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 10px;
            }
            
            .action-links {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
            <div class="welcome-text">
                <i class="fas fa-user-circle"></i> Selamat datang, <span><?= $_SESSION['admin_username'] ?></span>
            </div>
        </div>
        <div class="btn-group">
            <a href="index.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <a href="add_item.php" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
            <a href="view_orders.php" class="btn btn-orders">
                <i class="fas fa-shopping-cart"></i> Cek Pesanan
            </a>
            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="content-box">
        <div class="stats">
            <?php
            $total_items = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM items"));
            $total_value = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) as total FROM items"))['total'];
            ?>
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <h3><?= $total_items ?></h3>
                <p>Total Produk</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Rp <?= number_format($total_value, 0, ',', '.') ?></h3>
                <p>Total Nilai Produk</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line"></i>
                <h3>Aktif</h3>
                <p>Status Toko</p>
            </div>
        </div>

        <h3 style="color: #f9ab00; margin-bottom: 15px;">
            <i class="fas fa-list"></i> Daftar Produk
        </h3>
        
        <?php
        $q = mysqli_query($conn, "SELECT * FROM items ORDER BY id DESC");
        if(mysqli_num_rows($q) > 0): ?>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Icon</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($r = mysqli_fetch_assoc($q)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <i class="fas <?= $r['icon_or_img'] ?: 'fa-star' ?>" style="color: #f9ab00; font-size: 1.5rem;"></i>
                        </td>
                        <td><strong><?= $r['name'] ?></strong></td>
                        <td><strong style="color: #f9ab00;">Rp <?= number_format($r['price'], 0, ',', '.') ?></strong></td>
                        <td class="action-links">
                            <a href="edit_item.php?id=<?= $r['id'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <span style="color: #333;">|</span>
                            <a href="delete.php?id=<?= $r['id'] ?>" class="delete" onclick="return confirmDelete('<?= $r['name'] ?>')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Produk</h3>
            <p>Klik tombol "Tambah Produk" untuk menambahkan produk pertama</p>
        </div>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete(name) {
            return confirm('Yakin ingin menghapus produk "' + name + '"?\nData yang dihapus tidak dapat dikembalikan.');
        }
    </script>
</body>
</html>