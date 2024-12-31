<?php
// Include the database connection file (change the path if necessary)
include('../db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the required fields are set in the POST request
if (isset($_POST['nama'], $_POST['no_punggung'], $_POST['gender'], $_POST['tanggal_lahir'], 
          $_POST['tempat_lahir'], $_POST['nama_orangtua'], $_POST['nik'], $_POST['alamat'], 
          $_POST['domisili'], $_POST['email'], $_POST['phone_number'], $_POST['berat_badan'], 
          $_POST['tinggi_badan'], $_POST['status'])) {

    // Get the form data from POST request
    $playerId = isset($_POST['playerId']) ? $_POST['playerId'] : '';  // Check if playerId exists (for edit)
    $nama = $_POST['nama'];
    $noPunggung = $_POST['no_punggung'];
    $gender = $_POST['gender'];
    $tanggalLahir = $_POST['tanggal_lahir'];
    $tempatLahir = $_POST['tempat_lahir'];
    $namaOrangtua = $_POST['nama_orangtua'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $domisili = $_POST['domisili'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $beratBadan = $_POST['berat_badan'];
    $tinggiBadan = $_POST['tinggi_badan'];
    $status = $_POST['status'];

    // Get the user_id from session
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Handle file uploads
    $foto = null;
    $ktp = null;
    $kartuKeluarga = null;
    $aktaKelahiran = null;

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
    if (isset($_FILES['kartu_keluarga']) && $_FILES['kartu_keluarga']['error'] === 0) {
        $kartuKeluarga = uploadFile($_FILES['kartu_keluarga']);
        if (!$kartuKeluarga) {
            $uploadErrors[] = "Failed to upload 'kartu_keluarga'.";
        }
    }
    if (isset($_FILES['akta_kelahiran']) && $_FILES['akta_kelahiran']['error'] === 0) {
        $aktaKelahiran = uploadFile($_FILES['akta_kelahiran']);
        if (!$aktaKelahiran) {
            $uploadErrors[] = "Failed to upload 'akta_kelahiran'.";
        }
    }

    // If there are any file upload errors, return them in the response
    if (!empty($uploadErrors)) {
        echo json_encode(['status' => 'error', 'message' => implode(' ', $uploadErrors)]);
        exit;
    }

    // Prepare the SQL query for inserting or updating player data
    if (empty($playerId)) {
        // Insert a new player
        $sql = "INSERT INTO pemain 
            (nama, no_punggung, gender, tanggal_lahir, tempat_lahir, nama_orangtua, nik, 
            alamat, domisili, email, phone_number, berat_badan, tinggi_badan, `status`, 
            foto, ktp, kartu_keluarga, akta_kelahiran, user_id) 
            VALUES ('$nama', '$noPunggung', '$gender', '$tanggalLahir', '$tempatLahir', '$namaOrangtua', 
            '$nik', '$alamat', '$domisili', '$email', '$phoneNumber', '$beratBadan', '$tinggiBadan', 
            '$status', '$foto', '$ktp', '$kartuKeluarga', '$aktaKelahiran', '$userId')";
    } else {
        // Update an existing player
        $sql = "UPDATE pemain SET 
            nama = '$nama', no_punggung = '$noPunggung', gender = '$gender', tanggal_lahir = '$tanggalLahir', 
            tempat_lahir = '$tempatLahir', nama_orangtua = '$namaOrangtua', nik = '$nik', 
            alamat = '$alamat', domisili = '$domisili', email = '$email', phone_number = '$phoneNumber', 
            berat_badan = '$beratBadan', tinggi_badan = '$tinggiBadan', status = '$status', foto = '$foto', 
            ktp = '$ktp', kartu_keluarga = '$kartuKeluarga', akta_kelahiran = '$aktaKelahiran', user_id = '$userId' 
            WHERE id = '$playerId'";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data pemain berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data pemain.']);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data yang diperlukan tidak lengkap.']);
}

// Function to handle file uploads
function uploadFile($file) {
    $uploadDir = 'uploads/';  // Directory to store uploaded files
    $uploadFile = $uploadDir . basename($file['name']);
    
    // Check if the file is a valid file (you can add more validation here)
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        return $uploadFile;  // Return the path of the uploaded file
    } else {
        return null;  // Return null if the file upload failed
    }
}
?>
