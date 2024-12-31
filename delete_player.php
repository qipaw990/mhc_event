<?php
// Include the database connection file (change the path if necessary)
include('db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Check if id is provided in the request
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Check if the player exists in the database and belongs to the current user
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM pemain WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Player exists, proceed to delete
        $deleteSql = "DELETE FROM pemain WHERE id = ? AND user_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("ii", $id, $userId);

        if ($deleteStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Player deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete player']);
        }
        $deleteStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Player not found or not authorized']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Player ID is required']);
}

// Close the database connection
$conn->close();
?>
