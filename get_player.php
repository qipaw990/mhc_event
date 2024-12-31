<?php
// Include the database connection file (change the path if necessary)
include('db_connection.php');

// Check if the 'id' parameter is provided in the GET request
if (isset($_GET['id'])) {
    $officialId = $_GET['id'];

    // Prepare the SQL query to fetch official details by ID
    $query = "SELECT * FROM official WHERE official_id = ?";
    if ($stmt = $conn->prepare($query)) {
        // Bind the official ID parameter
        $stmt->bind_param("i", $officialId);
        
        // Execute the query
        $stmt->execute();
        
        // Get the result of the query
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Fetch the official data as an associative array
            $official = $result->fetch_assoc();
            
            // Return the official data as a JSON response
            echo json_encode($official);
        } else {
            // If no official found, return an error message
            echo json_encode(['error' => 'Official not found']);
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Return an error if the query preparation failed
        echo json_encode(['error' => 'Query preparation failed']);
    }

    // Close the database connection
    $conn->close();
} else {
    // Return an error if the 'id' parameter is missing
    echo json_encode(['error' => 'Official ID is missing']);
}
?>
