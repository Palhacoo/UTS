<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM dosen WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dosen.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
