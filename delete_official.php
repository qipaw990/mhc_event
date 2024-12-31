<?php
// Include the database connection file
include('db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse the input data
    parse_str(file_get_contents("php://input"), $data);

    // Check if 'id' is provided
    if (isset($data['id'])) {
        $officialId = $data['id'];
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Verify user session
        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            exit();
        }

        // Prepare the SQL query to delete the official
        $query = "DELETE FROM official WHERE official_id = ? AND user_id = ?";
        if ($stmt = $conn->prepare($query)) {
            // Bind parameters
            $stmt->bind_param('ii', $officialId, $userId);

            // Execute the query
            if ($stmt->execute()) {
                // Check if any row was affected
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['status' => 'success', 'message' => 'Official deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Official not found or you do not have permission to delete this record.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete the official.']);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query preparation failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Official ID is required.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
