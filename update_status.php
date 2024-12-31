<?php
session_start();
include('db_connection.php');

// Memeriksa apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login terlebih dahulu.']);
    exit();
}

// Memeriksa apakah parameter id dan status ada
if (isset($_POST['id']) && isset($_POST['status'])) {
    $playerId = $_POST['id'];
    $status = $_POST['status'];

    // Validasi status (untuk memastikan hanya status yang diizinkan)
    if (!in_array($status, ['pending', 'rejected', 'verified'])) {
        echo json_encode(['status' => 'error', 'message' => 'Status tidak valid.']);
        exit();
    }

    // Update status pemain di database
    $sql = "UPDATE pemain SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $playerId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Status pemain berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui status.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID atau status tidak ditemukan.']);
}
?>
