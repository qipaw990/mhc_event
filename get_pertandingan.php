<?php
// Include the database connection file
include('db_connection.php');

// Start the session to access the user_id
session_start();

// Check if the 'id' parameter is passed in the request
if (isset($_GET['id'])) {
    $pertandinganId = $_GET['id'];  // Get the pertandingan ID from the query parameter

    // Prepare the SQL query to get the pertandingan data
    $sql = "SELECT * FROM pertandingan WHERE id = '$pertandinganId' LIMIT 1";

    // Execute the query and check if a record was found
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch the data from the result set
        $pertandingan = $result->fetch_assoc();

        // Return the data as a JSON response
        echo json_encode($pertandingan);
    } else {
        // If no record found, return an error message
        echo json_encode(['status' => 'error', 'message' => 'Pertandingan tidak ditemukan']);
    }

    // Close the connection
    $conn->close();
} else {
    // If 'id' is not passed, return an error message
    echo json_encode(['status' => 'error', 'message' => 'ID pertandingan tidak diberikan']);
}
?>
