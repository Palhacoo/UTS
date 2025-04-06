<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header("Location: mahasiswa.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', tahun_masuk='$tahun_masuk', 
            alamat='$alamat', no_telp='$no_telp' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: mahasiswa.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
