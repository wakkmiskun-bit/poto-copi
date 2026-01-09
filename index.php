<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adiba Photocopy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        
        .loading-screen.hide {
            opacity: 0;
            pointer-events: none;
        }
        
        .loading-logo {
            font-size: 2.5rem;
            color: #f9ab00;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 20px;
            animation: fadeInDown 0.8s ease;
        }
        
        .loading-text {
            font-size: 1.2rem;
            color: #e0e0e0;
            margin-bottom: 30px;
            animation: fadeIn 1s ease 0.3s both;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid #f9ab00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        body { 
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: #e0e0e0; 
            font-family: 'Segoe UI', sans-serif;
        }
        
        .header { 
            background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
            padding: 20px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .header h1 { 
            color: #f9ab00; 
            font-size: 1.5rem;
            text-shadow: 0 0 20px rgba(249,171,0,0.3);
        }
        
        .admin-link { 
            color: #b0b0b0; 
            text-decoration: none; 
            padding: 8px 20px; 
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 8px;
            transition: 0.3s;
            background: rgba(255,255,255,0.02);
        }
        
        .admin-link:hover { 
            color: #f9ab00; 
            border-color: #f9ab00; 
            background: rgba(249,171,0,0.05);
        }
        
        .container { 
            max-width: 1200px; 
            margin: auto; 
            padding: 40px 20px; 
        }
        
        .hero { 
            text-align: center; 
            padding: 40px 0;
        }
        
        .hero h2 { 
            color: #f9ab00; 
            font-size: 2.5rem; 
            margin-bottom: 10px;
            text-shadow: 0 0 30px rgba(249,171,0,0.2);
        }
        
        .hero p {
            color: #c0c0c0;
            font-size: 1.1rem;
        }
        
        .grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); 
            gap: 20px;
            margin-top: 40px;
        }
        
        .card { 
            background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
            border-radius: 12px; 
            border: 1px solid rgba(255,255,255,0.05); 
            overflow: hidden; 
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .card:hover { 
            transform: translateY(-5px); 
            border-color: rgba(249,171,0,0.3);
            box-shadow: 0 8px 25px rgba(0,0,0,0.5), 0 0 20px rgba(249,171,0,0.1);
        }
        
        /* MODIFIKASI: Mendukung Foto & Icon */
        .icon-box { 
            height: 180px; /* Tinggi disesuaikan untuk foto */
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            overflow: hidden;
        }

        .icon-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Agar foto tidak gepeng */
        }

        .icon-box i {
            font-size: 4rem; 
            color: #f9ab00;
        }
        
        .card-info { 
            padding: 20px; 
            text-align: center; 
        }
        
        .card-info h3 {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #e0e0e0;
        }
        
        .price { 
            font-size: 1.3rem; 
            color: #f9ab00; 
            font-weight: bold; 
            margin: 12px 0;
        }
        
        .btn-order { 
            background: linear-gradient(135deg, #f9ab00 0%, #ffb700 100%);
            color: #000; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 8px; 
            width: 100%; 
            font-weight: bold;
            cursor: pointer; 
            transition: 0.3s;
            font-size: 0.9rem;
        }
        
        .btn-order:hover { 
            background: linear-gradient(135deg, #ffb700 0%, #ffc400 100%);
            transform: scale(0.98);
            box-shadow: 0 4px 15px rgba(249,171,0,0.3);
        }
        
        .footer { 
            margin-top: 80px; 
            padding: 60px 0; 
            background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        
        .footer-content {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }
        
        .footer h3 {
            color: #f9ab00;
            margin-bottom: 20px;
        }
        
        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid rgba(249,171,0,0.3);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .info-box {
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 3px solid #f9ab00;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .info-box h4 {
            color: #f9ab00;
            margin-bottom: 8px;
        }
        
        .info-box p {
            color: #c0c0c0;
            line-height: 1.6;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .loading-logo { font-size: 2rem; }
            .loading-text { font-size: 1rem; }
            .header h1 { font-size: 1.2rem; }
            .hero h2 { font-size: 2rem; }
            .grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
            .icon-box { height: 150px; }
            .card-info { padding: 15px; }
            .btn-order { padding: 8px 15px; font-size: 0.85rem; }
            .footer-grid { grid-template-columns: 1fr; gap: 20px; }
            .map-container { height: 300px; }
        }
        
        @media (max-width: 480px) {
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="loading-screen" id="loadingScreen">
        <div class="loading-logo">ADIBA PHOTOCOPY</div>
        <div class="loading-text">Selamat Datang</div>
        <div class="spinner"></div>
    </div>

    <div class="header">
        <h1>ADIBA PHOTOCOPY</h1>
        <a href="login.php" class="admin-link">
            <i class="fas fa-user-shield"></i> Admin
        </a>
    </div>

    <div class="container">
        <div class="hero">
            <h2>Layanan & Produk Kami</h2>
            <p>Solusi Dokumen Cepat, Berkualitas, dan Profesional</p>
        </div>

        <div class="grid">
            <?php
            $data = mysqli_query($conn, "SELECT * FROM items ORDER BY id ASC");
            while($row = mysqli_fetch_assoc($data)): ?>
                <div class="card">
                    <div class="icon-box">
                        <?php 
                        // CEK: Jika data mengandung titik (extensi file), tampilkan IMG. Jika tidak, tampilkan ICON.
                        if (strpos($row['icon_or_img'], '.') !== false): ?>
                            <img src="uploads/<?= $row['icon_or_img'] ?>" alt="<?= $row['name'] ?>">
                        <?php else: ?>
                            <i class="fas <?= $row['icon_or_img'] ?: 'fa-star' ?>"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h3><?= $row['name'] ?></h3>
                        <p class="price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                        <button class="btn-order" onclick="orderWA('<?= addslashes($row['name']) ?>', '<?= number_format($row['price'], 0, ',', '.') ?>')">
                            <i class="fab fa-whatsapp"></i> Pesan Sekarang
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="footer">
        <div class="footer-content">
            <h3><i class="fas fa-map-marker-alt"></i> Kunjungi Kami</h3>
            
            <div class="footer-grid">
                <div>
                    <div class="info-box">
                        <h4><i class="fas fa-location-dot"></i> Alamat</h4>
                        <p>Jl. Ciawitali No.51, Citeureup, Cimahi Utara, Jawa Barat 40512</p>
                    </div>
                    
                    <div class="info-box">
                        <h4><i class="fas fa-phone"></i> Kontak</h4>
                        <p>0851-9116-3819</p>
                    </div>
                    
                    <div class="info-box">
                        <h4><i class="fas fa-clock"></i> Jam Operasional</h4>
                        <p>Senin - Jumat: 08.00 - 20.00<br>
                           Sabtu: 08.00 - 18.00<br>
                           Minggu: Libur</p>
                    </div>
                    
                    <a href="https://maps.app.goo.gl/YourLinkDisini" target="_blank" class="btn-order" style="display: inline-block; width: auto; text-decoration: none; padding: 12px 25px; margin-top: 10px;">
                        <i class="fas fa-directions"></i> Buka di Google Maps
                    </a>
                </div>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.16323672533!2d107.5501861747565!3d-6.871050293127719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e43e2e8e9e9f%3A0x280e8e635f5c4046!2sCiawitali%2C%20Cimahi%20Utara%2C%20Cimahi%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05); color: #808080;">
                <p>© 2024 Adiba Photocopy. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loadingScreen').classList.add('hide');
            }, 1000); // Saya percepat loadingnya ke 1 detik biar user tidak kelamaan
        });

        function orderWA(produk, harga) {
            Swal.fire({
                title: 'Konfirmasi Pesanan',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <p><strong>Produk:</strong> ${produk}</p>
                        <p><strong>Harga:</strong> Rp ${harga}</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f9ab00',
                cancelButtonColor: '#333',
                confirmButtonText: '<i class="fab fa-whatsapp"></i> Hubungi Admin',
                cancelButtonText: 'Batal',
                background: '#1e1e1e',
                color: '#e0e0e0'
            }).then((result) => {
                if (result.isConfirmed) {
                    const phone = "6285191163819";
                    const msg = encodeURIComponent(`Halo Adiba Photocopy,\n\nSaya ingin memesan:\nProduk: ${produk}\nHarga: Rp ${harga}\n\nTerima kasih!`);
                    window.open(`https://wa.me/${phone}?text=${msg}`, '_blank');
                }
            })
        }
    </script>
</body>
</html>