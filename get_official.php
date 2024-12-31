<?php
// Memastikan pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Menghubungkan ke database
include('db_connection.php');

// Memeriksa apakah official_id disediakan
if (!isset($_GET['official_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing official_id parameter']);
    exit();
}

$official_id = intval($_GET['official_id']);

// Query untuk mengambil data official berdasarkan official_id
$sql = "SELECT * FROM official WHERE official_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $official_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $official = $result->fetch_assoc();
    echo json_encode($official);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Official not found']);
}

$stmt->close();
$conn->close();
?>
