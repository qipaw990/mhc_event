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

include('../db_connection.php');

// Fungsi untuk upload gambar
function uploadGambar($file) {
    $targetDir = "uploads/";  // Folder tempat gambar akan disimpan
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Memeriksa apakah file adalah gambar
    if (getimagesize($file["tmp_name"]) === false) {
        return ['status' => 'error', 'message' => 'File bukan gambar'];
    }

    // Memeriksa apakah file sudah ada
    if (file_exists($targetFile)) {
        return ['status' => 'error', 'message' => 'File sudah ada'];
    }

    // Memeriksa ukuran file (maksimal 5MB)
    if ($file["size"] > 5000000) {
        return ['status' => 'error', 'message' => 'Ukuran file terlalu besar'];
    }

    // Hanya izinkan ekstensi file tertentu
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return ['status' => 'error', 'message' => 'Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan'];
    }

    // Coba untuk mengupload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return ['status' => 'success', 'message' => 'File berhasil diupload', 'filename' => basename($file["name"])];
    } else {
        return ['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupload file'];
    }
}

// Periksa apakah form dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $beritaId = isset($_POST['beritaId']) ? $_POST['beritaId'] : '';
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $gambar = null;  // Menyimpan nama file gambar

    // Cek apakah ada gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $uploadResult = uploadGambar($_FILES['gambar']);
        if ($uploadResult['status'] == 'error') {
            echo json_encode([
                'status' => 'error',
                'message' => $uploadResult['message']
            ]);
            exit();
        }
        $gambar = $uploadResult['filename'];
    }

    if (empty($beritaId)) {
        // Tambah berita baru
        $sql = "INSERT INTO berita (judul, isi, gambar, tanggal, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $status);
    } else {
        // Edit berita yang sudah ada
        $sql = "UPDATE berita SET judul = ?, isi = ?, gambar = ?, tanggal = ?, status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $status, $beritaId);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => empty($beritaId) ? 'Berita berhasil ditambahkan' : 'Berita berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat memproses data berita'
        ]);
    }

    // Menutup statement
    $stmt->close();
    $conn->close();
}
?>
