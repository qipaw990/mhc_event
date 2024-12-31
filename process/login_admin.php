<?php
// Include koneksi database
include('../db_connection.php');

// Start session
session_start();

// Periksa apakah data POST telah diterima
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil email dan password dari request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari admin berdasarkan email
    $query = "SELECT * FROM admin_users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password_hash'])) {
            // Simpan data admin ke session
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];

            // Kirim respons sukses
            echo 'success';
        } else {
            // Password salah
            echo 'error';
        }
    } else {
        // Email tidak ditemukan
        echo 'error';
    }

    $stmt->close();
} else {
    // Jika bukan POST request, tolak akses
    echo 'invalid_request';
}

$conn->close();
?>
