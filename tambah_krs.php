<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nim = $_POST['nim'];

    // Periksa apakah kode mata kuliah ada di database
    $cek_kode_sql = "SELECT COUNT(*) AS jumlah FROM jadwal WHERE kode_matakuliah = ?";
    $cek_kode_stmt = $conn->prepare($cek_kode_sql);
    $cek_kode_stmt->bind_param("s", $kode_matakuliah);
    $cek_kode_stmt->execute();
    $cek_kode_stmt->bind_result($jumlah_kode);
    $cek_kode_stmt->fetch();
    $cek_kode_stmt->close();

    // Periksa apakah NIM mahasiswa ada di database
    $cek_nim_sql = "SELECT COUNT(*) AS jumlah FROM mahasiswa WHERE nim = ?";
    $cek_nim_stmt = $conn->prepare($cek_nim_sql);
    $cek_nim_stmt->bind_param("s", $nim);
    $cek_nim_stmt->execute();
    $cek_nim_stmt->bind_result($jumlah_nim);
    $cek_nim_stmt->fetch();
    $cek_nim_stmt->close();

    // Jika kode mata kuliah atau NIM tidak ditemukan
    if ($jumlah_kode == 0 || $jumlah_nim == 0) {
        header("Location: tambah_krs.php?error=Kode atau NIM tidak ditemukan");
        exit();
    }

    // Periksa apakah kombinasi NIM dan Kode Matkul sudah ada
    $cek_sql = "SELECT * FROM jadwal_mahasiswa WHERE kode_matakuliah = ? AND nim = ?";
    $cek_stmt = $conn->prepare($cek_sql);
    $cek_stmt->bind_param("ss", $kode_matakuliah, $nim);
    $cek_stmt->execute();
    $cek_result = $cek_stmt->get_result();

    if ($cek_result->num_rows > 0) {
        // Jika sudah ada, kembalikan dengan pesan error
        header("Location: tambah_krs.php?error=Mahasiswa sudah terdaftar di kelas ini");
        exit();
    } else {
        // Jika belum ada, lakukan insert
        $sql = "INSERT INTO jadwal_mahasiswa (kode_matakuliah, nim) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $kode_matakuliah, $nim);

        if ($stmt->execute()) {
            header("Location: krs.php?status=sukses");
            exit();
        } else {
            header("Location: tambah_krs.php?error=Gagal menyimpan data");
            exit();
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah KRS</title>
    <link rel="stylesheet" href="tambah_krs.css">
</head>
<body>
    <h2>Tambah KRS</h2>
    <form method="POST">
            <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red; font-weight: bold;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        <label>Kode Mata Kuliah:</label>
        <input type="text" name="kode_matakuliah" required><br>
        
        <label>NIM Mahasiswa:</label>
        <input type="text" name="nim" required><br>
        
        <button type="submit">Simpan</button>
        <a href="krs.php">Kembali</a>
    </form>
</body>
</html>