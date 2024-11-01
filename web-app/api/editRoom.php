<?php
require 'dbconnect.php';
require 'checklogin.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve POST data
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $room_number = isset($_POST['room_number']) ? $_POST['room_number'] : '';
    $location_id = isset($_POST['location_id']) ? $_POST['location_id'] : '';
    $room_max_occupancy = isset($_POST['room_max_occupancy']) ? $_POST['room_max_occupancy'] : '';
    $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';

    // Simple validation example
    if (empty($id) || empty($name) || empty($room_number) || empty($location_id) || empty($room_max_occupancy) || empty($room_type)) {
        http_response_code(400);
        $response = array('status' => 'error', 'message' => 'Incomplete data');
        echo json_encode($response);
        exit;
    }

    // Prepare SQL query to update a room
    $sql = "UPDATE rooms 
            SET name = ?, room_number = ?, location_id = ? , max_occupancy = ? , type = ?
            WHERE id = ?";
    
    // Prepare a parameterized query to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiisi", $name, $room_number, $location_id,$room_max_occupancy,$room_type, $id);

    // Execute SQL query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Room updated successfully');
            http_response_code(200);
        } else {
            $response = array('status' => 'error', 'message' => 'Room not found or data not changed');
            http_response_code(404);
        }
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => 'Server Error');
        http_response_code(500);
        echo json_encode($response);
    }

    // Close statement
    $stmt->close();
} else {
    // Invalid request method, return an error response
    http_response_code(405); // 405 Method Not Allowed
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
