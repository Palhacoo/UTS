<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $no_telp = $_POST['no_telp'];

    // Query untuk update data dosen
    $sql = "UPDATE dosen SET nik = ?, nama = ?, gelar = ?, lulusan = ?, no_telp = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssi", $nik, $nama, $gelar, $lulusan, $no_telp, $id);
        if ($stmt->execute()) {
            header("Location: dosen.php"); // Redirect kembali ke halaman dosen
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
