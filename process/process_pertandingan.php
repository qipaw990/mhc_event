<?php
// Include the database connection file
include('../db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the required fields are set in the POST request
if (isset($_POST['home_user_id'], $_POST['away_user_id'], $_POST['tanggal'], $_POST['lokasi'], $_POST['status'])) {

    // Get the form data from POST request
    $pertandinganId = isset($_POST['pertandinganId']) ? $_POST['pertandinganId'] : ''; // Check if pertandinganId exists (for edit)
    $homeUserId = $_POST['home_user_id'];
    $awayUserId = $_POST['away_user_id'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $hasil = isset($_POST['hasil']) ? $_POST['hasil'] : null; // Optional field for the result

    // Get the user_id from session
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Prepare the SQL query for inserting or updating pertandingan data
    if (empty($pertandinganId)) {
        // Insert a new pertandingan (without created_at and updated_at)
        $sql = "INSERT INTO pertandingan 
            (tim_home, tim_away, tanggal, lokasi, status, hasil, home_user_id, away_user_id) 
            VALUES ('$homeUserId', '$awayUserId', '$tanggal', '$lokasi', '$status', '$hasil', '$homeUserId', '$awayUserId')";
    } else {
        // Update an existing pertandingan (without updating created_at and updated_at)
        $sql = "UPDATE pertandingan SET 
            tim_home = '$homeUserId', tim_away = '$awayUserId', tanggal = '$tanggal', 
            lokasi = '$lokasi', status = '$status', hasil = COALESCE('$hasil', hasil), 
            home_user_id = '$homeUserId', away_user_id = '$awayUserId' 
            WHERE id = '$pertandinganId' AND home_user_id = '$homeUserId' AND away_user_id = '$awayUserId'";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Pertandingan berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan pertandingan.']);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data yang diperlukan tidak lengkap.']);
}
?>
