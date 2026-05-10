<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pengolahan krs&khs"; // Ganti dengan nama database yang kamu buat di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// Update identitas kontributor
?>