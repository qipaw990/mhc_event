<?php
// Mulai sesi untuk mendapatkan session user_id atau admin_id jika perlu
session_start();

// Pastikan user telah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login sebagai admin untuk menghapus berita.']);
    exit();
}

// Menghubungkan ke database
include('db_connection.php');

// Periksa apakah ID berita ada dalam data POST
if (isset($_POST['id'])) {
    $berita_id = $_POST['id'];

    // Pastikan ID adalah angka
    if (!is_numeric($berita_id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID berita tidak valid.']);
        exit();
    }

    // Query untuk menghapus berita berdasarkan ID
    $sql = "DELETE FROM berita WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Bind parameter dan eksekusi query
    $stmt->bind_param("i", $berita_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Berita berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus berita.']);
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID berita tidak ditemukan.']);
}
?>
