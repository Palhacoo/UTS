<?php
require 'config.php'; // Perbaiki jalur ke file config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM jadwal WHERE id='$id'";

    if ($conn->query($sql)) {
        header("Location: jadwal.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
