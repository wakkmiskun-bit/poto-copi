<?php
session_start();
include 'db.php';

// Jika sudah login, redirect ke admin
if(isset($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $query = mysqli_query($conn, "SELECT * FROM admin_users WHERE username='$username'");
    
    if(mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        
        if(password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_id'] = $user['id'];
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Adiba Photocopy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: #e0e0e0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-container {
            background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo i {
            font-size: 4rem;
            color: #f9ab00;
            margin-bottom: 15px;
        }
        
        .logo h2 {
            color: #f9ab00;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .logo p {
            color: #888;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #c0c0c0;
            font-size: 0.9rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: #0a0a0a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #e0e0e0;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #f9ab00;
            box-shadow: 0 0 0 3px rgba(249,171,0,0.1);
        }
        
        .error-message {
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.3);
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #f9ab00 0%, #ffb700 100%);
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #ffb700 0%, #ffc400 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(249,171,0,0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #888;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .back-link a:hover {
            color: #f9ab00;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .logo h2 {
                font-size: 1.5rem;
            }
            
            .logo i {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-shield-halved"></i>
            <h2>Admin Login</h2>
            <p>Adiba Photocopy</p>
        </div>
        
        <?php if($error): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= $error ?></span>
        </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login</span>
            </button>
        </form>
        
        <div class="back-link">
            <a href="index.php">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>