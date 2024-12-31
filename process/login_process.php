<?php
// Memulai session
session_start();

// Menghubungkan ke file koneksi
include('../db_connection.php');

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email ada di database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Pengguna ditemukan, ambil data pengguna
        $user = $result->fetch_assoc();

        // Verifikasi password yang dimasukkan dengan password yang di-hash
        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan data pengguna di session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];  // Contoh menyimpan nama pengguna
            echo "success";
        } else {
            // Password salah
            echo "error";
        }
    } else {
        // Email tidak ditemukan
        echo "error";
    }
}
?>
