<?php
require 'config.php';

// Jika belum login, arahkan ke login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
