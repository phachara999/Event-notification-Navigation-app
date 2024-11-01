<?php
require 'dbconnect.php';
$options = [
         'cost' => 10,
     ];
$password = $_POST['password'];
$username = $_POST['username'];
$passwordHash = password_hash($password,  PASSWORD_BCRYPT, $options);

$sql = "INSERT INTO user (username, password) VALUES (?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $username, $passwordHash);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'message' => 'User registered successfully');
    http_response_code(200);
} else {
    $response = array('status' => 'error', 'message' => 'Failed to register user');
    http_response_code(500);
}