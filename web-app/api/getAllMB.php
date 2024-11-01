<?php
require 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $sql = '';

        switch ($keyword) {
            case 'today':
                $sql = "SELECT * FROM events WHERE NOW() BETWEEN start_date AND end_date ORDER BY start_date ASC;";
                break;
            case '7day':
                $sql = "SELECT * FROM events WHERE DATE(end_date) > CURRENT_DATE AND DATE(start_date) <= CURRENT_DATE + INTERVAL 7 DAY ORDER BY start_date ASC;";
                break;
            case '1month':
                $sql = "SELECT * 
            FROM events 
            WHERE CURRENT_DATE + INTERVAL 7 DAY < DATE(start_date) 
              AND DATE(start_date) <= CURRENT_DATE + INTERVAL 30 DAY 
            ORDER BY start_date ASC;";
                break;
            case 'done':
                $sql = "SELECT * FROM events WHERE DATE(end_date) < CURRENT_DATE ORDER BY start_date ASC;";
                break;
            default:
                http_response_code(400);  // 400 Bad Request
                echo json_encode(['status' => 'error', 'message' => 'Invalid keyword']);
                exit;
        }

        $result = $conn->query($sql);
        if ($result) {
            $events = $result->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($events);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        }
    }else if(isset($_GET['date'])){
      
        $date = $_GET['date'];

        if($date == '1'){
            $sql = "SELECT start_date,id,name FROM events";
            $result = $conn->query($sql);
            if ($result) {
                $events = $result->fetch_all(MYSQLI_ASSOC);
                http_response_code(200);
                echo json_encode($events);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
            }
            exit;
        }
        $sql = "SELECT * FROM events WHERE DATE(start_date) = '$date' ORDER BY start_date ASC;";
        $result = $conn->query($sql);
        if ($result) {
            $events = $result->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($events);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        }
    }
    else {
        http_response_code(400);  // 400 Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Keyword parameter is missing']);
    }
} else {
    // Invalid request method, return an error response
    http_response_code(405);  // 405 Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
