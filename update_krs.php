<?php
require "config.php";

$kode_matakuliah = $_GET['kode_matakuliah'];
$nim = $_GET['nim'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_matakuliah_baru = $_POST['kode_matakuliah'];
    $nim_baru = $_POST['nim'];

    $sql = "UPDATE jadwal_mahasiswa SET kode_matakuliah='$kode_matakuliah_baru', nim='$nim_baru' WHERE kode_matakuliah='$kode_matakuliah' AND nim='$nim'";

    if ($conn->query($sql) === TRUE) {
        header("Location: krs.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit KRS</title>
</head>
<body>
    <h2>Edit KRS</h2>
    <form method="POST">
        <label>Kode Mata Kuliah:</label>
        <input type="text" name="kode_matakuliah" value="<?= htmlspecialchars($kode_matakuliah) ?>" required><br>
        
        <label>NIM Mahasiswa:</label>
        <input type="text" name="nim" value="<?= htmlspecialchars($nim) ?>" required><br>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>
