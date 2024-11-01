<?php
session_start();
if(!isset($_SESSION['user'])) {
    http_response_code(401);
    $response = array('status' => 'error', 'message' => 'Please log in!!');
    echo json_encode($response);
    exit;
}
?>