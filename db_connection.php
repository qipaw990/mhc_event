<?php
// db_connection.php
$host = "localhost";    // Ganti dengan host Anda
$user = "root";         // Ganti dengan username database Anda
$password = "";         // Ganti dengan password database Anda
$dbname = "mhc_event_app"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
