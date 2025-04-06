<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_matakuliah'];
    $nama = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $hari = $_POST['hari_matkul'];
    $nik = $_POST['nik'];
    $user_input = "admin"; // Bisa diganti dengan sesi pengguna yang login
    $tanggal_input = date("Y-m-d");

    // Cek apakah NIK dosen ada di database
    $cek_nik = "SELECT COUNT(*) AS jumlah FROM dosen WHERE nik = ?";
    if ($stmt = $conn->prepare($cek_nik)) {
        $stmt->bind_param("s", $nik);
        $stmt->execute();
        $stmt->bind_result($jumlah);
        $stmt->fetch();
        $stmt->close();

        if ($jumlah == 0) {
            // Redirect ke jadwal.php dengan pesan error
            header("Location: jadwal.php?error=NIK dosen tidak ditemukan!");
            exit();
        }
    } else {
        header("Location: jadwal.php?error=Terjadi kesalahan pada server!");
        exit();
    }

    // Jika NIK ada, lanjutkan proses penyimpanan data
    $sql = "INSERT INTO jadwal (kode_matakuliah, nama_matakuliah, sks, semester, hari_matkul, nik, user_input, tanggal_input) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssisssss", $kode, $nama, $sks, $semester, $hari, $nik, $user_input, $tanggal_input);
        if ($stmt->execute()) {
            header("Location: jadwal.php");
            exit();
        } else {
            header("Location: jadwal.php?error=Gagal menyimpan data!");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: jadwal.php?error=Terjadi kesalahan pada server!");
        exit();
    }
}

$conn->close();
?>
