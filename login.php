<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, password, role FROM users WHERE username = ?"; // ✅ Pastikan role diambil
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

            // 🔍 
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            exit(); // 

            header("Location: jadwal.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
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
            border-bottom: 2px solid #f1c40f;
            background-color: transparent;
            font-size: 16px;
            color: #333;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            border-color: #e67e22;
        }

        .forgot-password {
            color: #f1c40f;
            font-size: 14px;
            text-align: right;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .login-btn {
            background-color: #f1c40f;
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
            background-color: #f1c40f;
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
        <h1>JUDUL PROJECT/NAMA WEB</h1>
        <h2 style="color: #f1c40f;">LOGIN</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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

