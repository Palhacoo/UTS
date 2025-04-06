<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke login jika tidak ada sesi
    exit();
}

$username = $_SESSION['username']; // Ambil username dari session
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="background-circle circle-top-left"></div>
    <div class="background-circle circle-bottom-right"></div>
    <div class="container">
        <div class="header">
            <h1>SELAMAT DATANG, <?php echo htmlspecialchars($username); ?>!</h1>
        </div>
        <div class="menu">
            <?php if ($username === 'admin'): ?>
                <a href="jadwal.php" class="menu-item">JADWAL</a>
                <a href="dosen.php" class="menu-item">DOSEN</a>
                <a href="mahasiswa.php" class="menu-item">MAHASISWA</a>
                <a href="krs.php" class="menu-item">KRS</a>
            <?php endif; ?>
            <?php if ($username != 'admin'): ?>
            <a href="laporan.php" class="menu-item">LAPORAN</a>
            <?php endif; ?>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>