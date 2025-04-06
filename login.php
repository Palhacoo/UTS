<?php
session_start();
require 'config.php';

$error_message = ""; // Variabel untuk menyimpan error pesan

if (isset($_GET['error'])) {
    $error_message = $_GET['error']; // Ambil pesan error dari URL
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Cek password (jika sudah di-hash)
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=Username/Password Salah");
            exit();
        }
    } else {
        header("Location: login.php?error=Username/Password Salah");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            width: 50%;
            padding: 40px;
            background-color: #fafafa;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-container h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 2px solid #ffeb3b;
            background-color: transparent;
            font-size: 16px;
            color: #333;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            border-color: #ffeb3b;
        }

        .forgot-password {
            color: #ffeb3b;
            font-size: 14px;
            text-align: right;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .login-btn {
            background-color: #ffeb3b;
            color: #000;
            font-size: 16px;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .login-btn:hover {
            background-color: #e67e22;
        }

        .right-section {
            width: 50%;
            background-color: #ffeb3b;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .flower-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>UTS Pemrograman Website</h1>
        <h2 style="color: #ffeb3b;">LOGIN</h2>
        <br>
        <p>Silahkan login terlebih dahulu</p>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error_message)): ?>
            <p style="color: red; font-weight: bold; text-align: center;"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <input type="text" name="username" class="input-field" placeholder="Username" required />
            <input type="password" name="password" class="input-field" placeholder="Password" required />
            <div class="forgot-password">Forgot Password?</div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    <div class="right-section">
</body>
</html>
