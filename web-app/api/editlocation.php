<?php
require 'dbconnect.php';
require 'checklogin.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
    $building_number = isset($_POST['building_number']) ? $_POST['building_number'] : '';

    $sql = "SELECT isBding FROM location WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $isBding = isset($row['isBding']) ? $row['isBding'] : 0;
    $stmt->close();

    // Check for missing fields
    if (empty($id) || empty($name) || empty($latitude) || empty($longitude) || ($building_number == "999" && $isBding == 1)) {
        http_response_code(400);
        $response = array('status' => 'error', 'message' => 'Incomplete data');
        echo json_encode($response);
        exit;
    }

    // Check if the location exists and retrieve `isBding`}

    // Update location
    if ($building_number == "999") {
        $building_number = '-';
    }

    $sql = "UPDATE location SET 
            name = ?, 
            latitude = ?, 
            longitude = ?, 
            building_number = ?,
            isBding = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $latitude, $longitude, $building_number, $isBding, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Data updated successfully');
            http_response_code(200);
        } else {
            $response = array('status' => 'error', 'message' => 'No data changed');
            http_response_code(404);
        }
        echo json_encode($response);
    } else {
        http_response_code(500);
        $response = array('status' => 'error', 'message' => 'Server Error');
        echo json_encode($response);
    }

    $stmt->close();
} else {
    http_response_code(405); // 405 Method Not Allowed
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>