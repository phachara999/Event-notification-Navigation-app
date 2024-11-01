<?php
require 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if ($id == "total" && isset($_GET['year'])) {
            $year = $_GET['year'];
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `events` WHERE YEAR(start_date) = ?");
            $stmt->bind_param("i", $year); // Bind the year parameter
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $event = $result->fetch_assoc();
                http_response_code(200);
                echo json_encode($event);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
            }
            $stmt->close();
            exit();
        } else if ($id == "total") {
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `events`");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $event = $result->fetch_assoc();
                http_response_code(200);
                echo json_encode($event);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
            }
            $stmt->close();
            exit();
        }

        $stmt = $conn->prepare("SELECT `events`.*, `branch`.`name` AS branch_name, `faculty`.`name` AS faculty_name, `location`.`latitude`, `location`.`longitude`, `location`.`name` AS location_name, `personnel`.`first_name` AS personnel_fname, `personnel`.`last_name` AS personnel_lname, `personnel`.`personnel_number` AS personnel_number, `rooms`.`name` AS room_name, `rooms`.`room_number`
        FROM `events` 
        LEFT JOIN `branch` ON `events`.`branch_id` = `branch`.`id` 
        LEFT JOIN `faculty` ON `branch`.`faculty_id` = `faculty`.`id` 
        LEFT JOIN `location` ON `events`.`location_id` = `location`.`id` 
        LEFT JOIN `personnel` ON `events`.`personnel_id` = `personnel`.`id` 
        LEFT JOIN `rooms` ON `events`.`room_id` = `rooms`.`id`
        WHERE events.id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $event = $result->fetch_assoc();
            if ($event) {
                http_response_code(200);
                echo json_encode($event, JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Event not found']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        }
        $stmt->close();
    } else {
        $sql = "SELECT `events`.*, `location`.`name` AS location_name FROM `events` LEFT JOIN `location` ON `events`.`location_id` = `location`.`id` order by start_date desc";
        $result = $conn->query($sql);
        if ($result) {
            $events = $result->fetch_all(MYSQLI_ASSOC);
            $events = addEventStatus($events);
            // $events->array_push($events, $status);
            http_response_code(200);
            echo json_encode($events);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        }
    }
} else {
    // Invalid request method, return an error response
    http_response_code(405);  // 405 Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();


function addEventStatus($events) {
    date_default_timezone_set('Asia/Bangkok');
    $currentDate = date('Y-m-d'); // กำหนดเฉพาะวันที่ ไม่รวมเวลา
    foreach ($events as &$event) {
        $startDate = date('Y-m-d', strtotime($event['start_date']));
        $endDate = date('Y-m-d', strtotime($event['end_date']));
        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            $event['status'] = 'วันนี้';
        } elseif ($startDate > $currentDate && $startDate <= date('Y-m-d', strtotime('+7 days'))) {
            $event['status'] = '7 วัน';
        } elseif ($startDate > $currentDate && $startDate <= date('Y-m-d', strtotime('+30 days'))) {
            $event['status'] = '30 วัน';
        } elseif ($endDate < $currentDate) {
            $event['status'] = 'จัดแล้ว';
        } else {
            $event['status'] = 'ไม่ตรงกับเงื่อนไข';
        }
    }

    // เรียงลำดับตามสถานะ
    usort($events, function($a, $b) {
        $order = ['วันนี้', '7 วัน', '30 วัน', 'จัดแล้ว'];
        $posA = array_search($a['status'], $order);
        $posB = array_search($b['status'], $order);
        return $posA - $posB;
    });

    return $events;
}
