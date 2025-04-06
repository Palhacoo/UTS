<?php
include 'config.php'; // Menggunakan konfigurasi database yang sudah ada

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query untuk mendapatkan nama dosen berdasarkan NIK
    $query_dosen = "SELECT nama FROM dosen WHERE nik = ?";
    $stmt_dosen = $conn->prepare($query_dosen);
    $stmt_dosen->bind_param("s", $nik);
    $stmt_dosen->execute();
    $result_dosen = $stmt_dosen->get_result();
    $dosen = $result_dosen->fetch_assoc();

    if (!$dosen) {
        echo "Dosen dengan NIK $nik tidak ditemukan!";
        exit;
    }

    // Query untuk mendapatkan jadwal dosen
    $query = "SELECT * FROM krs WHERE nik = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Silakan masukkan NIK dosen!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jadwal Dosen</title>
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
    <h2>Laporan Jadwal Dosen</h2>
    <p><strong>Nama Dosen:</strong> <?= htmlspecialchars($dosen['nama']) ?> (NIK: <?= htmlspecialchars($nik) ?>)</p>
    <table border="1">
        <tr>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Hari</th>
            <th>Mahasiswa Terdaftar</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['kode_matakuliah']) ?></td>
                <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
                <td><?= htmlspecialchars($row['sks']) ?></td>
                <td><?= htmlspecialchars($row['semester']) ?></td>
                <td><?= htmlspecialchars($row['hari_matkul']) ?></td>
                <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
