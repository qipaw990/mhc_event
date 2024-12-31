<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Jika session admin_id tidak ditemukan, arahkan ke halaman login
    echo json_encode([
        'status' => 'error',
        'message' => 'Anda harus login terlebih dahulu.'
    ]);
    exit();
}

include('db_connection.php');

// Pastikan parameter 'id' dikirimkan melalui GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $beritaId = $_GET['id'];

    // Query untuk mengambil data berita berdasarkan id
    $sql = "SELECT * FROM berita WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $beritaId);  // Mengikat parameter id sebagai integer
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data berita
        $berita = $result->fetch_assoc();

        // Mengembalikan hasil dalam format JSON
        echo json_encode([
            'status' => 'success',
            'data' => $berita
        ]);
    } else {
        // Jika tidak ada data yang ditemukan
        echo json_encode([
            'status' => 'error',
            'message' => 'Berita tidak ditemukan'
        ]);
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    // Jika id tidak ditemukan di parameter GET
    echo json_encode([
        'status' => 'error',
        'message' => 'ID berita tidak ditemukan'
    ]);
}
?>
