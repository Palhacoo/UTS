<?php
require 'config.php'; // Menggunakan file konfigurasi database
session_start();

$message = ""; // Variabel untuk menampilkan pesan kesalahan

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Ambil username dari sesi

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli($host, $user, $pass, $dbname); // Koneksi ke database

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if ($username === "dosen") {
        $sql = "SELECT * FROM dosen WHERE nik = ?";
    } elseif ($username === "mahasiswa") {
        $sql = "SELECT * FROM mahasiswa WHERE nim = ?";
    } elseif ($username === "admin" && isset($_GET['tipe'])) {
        $tipe = $_GET['tipe'];
        $sql = $tipe === "dosen" ? "SELECT * FROM dosen WHERE nik = ?" : "SELECT * FROM mahasiswa WHERE nim = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($username === "dosen" || ($username === "admin" && $tipe === "dosen")) {
            header("Location: laporan_dosen.php?nik=$id");
        } elseif ($username === "mahasiswa" || ($username === "admin" && $tipe === "mahasiswa")) {
            header("Location: laporan_mahasiswa.php?nim=$id");
        }
        exit();
    } else {
        // Tampilkan pesan error jika NIK/NIM tidak ditemukan
        if ($username === "dosen" || ($username === "admin" && $tipe === "dosen")) {
            $message = "NIK tidak ditemukan!";
        } elseif ($username === "mahasiswa" || ($username === "admin" && $tipe === "mahasiswa")) {
            $message = "NIM tidak ditemukan!";
        }
    }

    $stmt->close();
}

// Query untuk mendapatkan daftar mahasiswa
$sql_mahasiswa = "SELECT nim, nama FROM mahasiswa ORDER BY nim";
$result_mahasiswa = $conn->query($sql_mahasiswa);

// Query untuk mendapatkan daftar dosen
$sql_dosen = "SELECT nik, nama FROM dosen ORDER BY nik";
$result_dosen = $conn->query($sql_dosen);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Laporan</title>
    <link rel="stylesheet" href="laporan.css">
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    <h2>Pilih Laporan</h2>
    <div class="form-container">
        <form action="" method="GET">
            <label>
                <?php if ($username === "mahasiswa"): ?>
                    Masukkan NIM:
                <?php elseif ($username === "dosen"): ?>
                    Masukkan NIK:
                <?php else: ?>
                    Masukkan NIK atau NIM:
                <?php endif; ?>
            </label><br>
            <input type="text" name="id" required><br><br>

            <button type="submit">Tampilkan Laporan</button>
        </form>

            <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($message)): ?>
            <p style="color: red; font-weight: bold; text-align: center;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>