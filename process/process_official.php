<?php
// Include the database connection file (change the path if necessary)
include('../db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the required fields are set in the POST request
if (isset($_POST['nama'], $_POST['nama_pendek'], $_POST['tanggal_lahir'], $_POST['tempat_lahir'], $_POST['alamat'], $_POST['nik'], $_POST['phone_number'])) {

    // Get the form data from POST request
    $officialId = isset($_POST['officialId']) ? $_POST['officialId'] : '';  // Check if officialId exists (for edit)
    $nama = $_POST['nama'];
    $namaPendek = $_POST['nama_pendek'];
    $tanggalLahir = $_POST['tanggal_lahir'];
    $tempatLahir = $_POST['tempat_lahir'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $phoneNumber = $_POST['phone_number'];

    // Get the user_id from session
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Handle file uploads
    $foto = null;
    $ktp = null;

    // Initialize error flag
    $uploadErrors = [];

    // Process file uploads
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = uploadFile($_FILES['foto']);
        if (!$foto) {
            $uploadErrors[] = "Failed to upload 'foto'.";
        }
    }
    if (isset($_FILES['ktp']) && $_FILES['ktp']['error'] === 0) {
        $ktp = uploadFile($_FILES['ktp']);
        if (!$ktp) {
            $uploadErrors[] = "Failed to upload 'ktp'.";
        }
    }

    // If there are any file upload errors, return them in the response
    if (!empty($uploadErrors)) {
        echo json_encode(['status' => 'error', 'message' => implode(' ', $uploadErrors)]);
        exit;
    }

    // Prepare the SQL query for inserting or updating official data
    if (empty($officialId)) {
        // Insert a new official
        $sql = "INSERT INTO official 
            (user_id, nama, nama_pendek, tanggal_lahir, tempat_lahir, alamat, nik, phone_number, foto, ktp, created_at, updated_at) 
            VALUES ('$userId', '$nama', '$namaPendek', '$tanggalLahir', '$tempatLahir', '$alamat', '$nik', '$phoneNumber', '$foto', '$ktp', NOW(), NOW())";
    } else {
        // Update an existing official
        $sql = "UPDATE official SET 
            nama = '$nama', nama_pendek = '$namaPendek', tanggal_lahir = '$tanggalLahir', 
            tempat_lahir = '$tempatLahir', alamat = '$alamat', nik = '$nik', phone_number = '$phoneNumber', 
            foto = COALESCE('$foto', foto), ktp = COALESCE('$ktp', ktp), updated_at = NOW() 
            WHERE official_id = '$officialId' AND user_id = '$userId'";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data official berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data official.']);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data yang diperlukan tidak lengkap.']);
}

// Function to handle file uploads
function uploadFile($file) {
    $uploadDir = 'uploads/';  // Directory to store uploaded files
    $uploadFile = $uploadDir . uniqid() . '_' . basename($file['name']);
    
    // Check if the file is a valid file (you can add more validation here)
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        return $uploadFile;  // Return the path of the uploaded file
    } else {
        return null;  // Return null if the file upload failed
    }
}
?>
