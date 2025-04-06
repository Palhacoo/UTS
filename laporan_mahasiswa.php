<?php
include 'config.php'; // Menggunakan konfigurasi database yang sudah ada

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk mendapatkan nama mahasiswa berdasarkan NIM
    $query_mahasiswa = "SELECT nama FROM mahasiswa WHERE nim = ?";
    $stmt_mahasiswa = $conn->prepare($query_mahasiswa);
    $stmt_mahasiswa->bind_param("s", $nim);
    $stmt_mahasiswa->execute();
    $result_mahasiswa = $stmt_mahasiswa->get_result();
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    if (!$mahasiswa) {
        echo "Mahasiswa dengan NIM $nim tidak ditemukan!";
        exit;
    }

    // Query untuk mendapatkan jadwal mahasiswa
    $query = "SELECT * FROM krs WHERE nim = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Silakan masukkan NIM mahasiswa!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jadwal Mahasiswa</title>
    <link rel="stylesheet" href="tabel_laporan.css">
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a href="laporan.php">Back</a>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    <h2>Laporan Jadwal Mahasiswa</h2>
    <p><strong>Nama Mahasiswa:</strong> <?= htmlspecialchars($mahasiswa['nama']) ?> (NIM: <?= htmlspecialchars($nim) ?>)</p>
    <table border="1">
        <tr>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Hari</th>
            <th>Dosen Pengampu</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['kode_matakuliah']) ?></td>
                <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
                <td><?= htmlspecialchars($row['sks']) ?></td>
                <td><?= htmlspecialchars($row['semester']) ?></td>
                <td><?= htmlspecialchars($row['hari_matkul']) ?></td>
                <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
