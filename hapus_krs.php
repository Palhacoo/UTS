<?php
require "config.php";

$kode_matakuliah = $_GET['kode_matakuliah'];
$nim = $_GET['nim'];

$sql = "DELETE FROM jadwal_mahasiswa WHERE kode_matakuliah='$kode_matakuliah' AND nim='$nim'";

if ($conn->query($sql) === TRUE) {
    header("Location: krs.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
