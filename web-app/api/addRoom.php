<?php
require 'dbconnect.php';
require 'checklogin.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve POST data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $room_number = isset($_POST['room_number']) ? $_POST['room_number'] : '';
    $location_id = isset($_POST['location_id']) ? $_POST['location_id'] : '';
    $room_max_occupancy = isset($_POST['room_max_occupancy']) ? $_POST['room_max_occupancy'] : '';
    $room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';

    // Simple validation example
    if (empty($name) || empty($room_number) || empty($location_id) || empty($room_max_occupancy) || empty($room_type)) {
        http_response_code(400);
        $response = array('status' => 'error', 'message' => 'Incomplete data');
        echo json_encode($response);
        exit;
    }

    // Prepare SQL query to insert a new room
    $sql = "INSERT INTO rooms (name, room_number, location_id, max_occupancy, type) VALUES (?,?,?,?,?)";

    // Prepare a parameterized query to prevent SQL injection (int)$num;
    $stmt = $conn->prepare($sql);

    // Bind parameters dynamically
    $stmt->bind_param("ssiis", $name, $room_number, $location_id, $room_max_occupancy, $room_type);

    // Execute SQL query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Room created successfully');
            http_response_code(201); // 201 Created
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to create room');
            http_response_code(500);
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
