<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header("Location: mahasiswa.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $user_input = $_SESSION['username'];

    $sql = "INSERT INTO mahasiswa (nim, nama, tahun_masuk, alamat, no_telp, user_input) 
            VALUES ('$nim', '$nama', '$tahun_masuk', '$alamat', '$no_telp', '$user_input')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: mahasiswa.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
