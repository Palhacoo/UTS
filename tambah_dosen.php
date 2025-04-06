<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $no_telp = $_POST['no_telp'];
    $user_input = $_SESSION['username'];

    $sql = "INSERT INTO dosen (nik, nama, gelar, lulusan, no_telp, user_input, tanggal_input) 
            VALUES ('$nik', '$nama', '$gelar', '$lulusan', '$no_telp', '$user_input', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: dosen.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
