<?php

function getAccessToken($jsonKey)
{
    $header = [
        'alg' => 'RS256',
        'typ' => 'JWT'
    ];

    $now = time();
    $expires = $now + 3600;

    $claims = [
        'iss' => $jsonKey['client_email'],
        'scope' => 'https://www.googleapis.com/auth/cloud-platform',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $expires
    ];

    $jwtHeader = base64UrlEncode(json_encode($header));
    $jwtClaims = base64UrlEncode(json_encode($claims));
    $signatureInput = $jwtHeader . '.' . $jwtClaims;

    openssl_sign($signatureInput, $signature, $jsonKey['private_key'], 'sha256');

    $jwtSignature = base64UrlEncode($signature);
    $jwt = $jwtHeader . '.' . $jwtClaims . '.' . $jwtSignature;

    $postData = [
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['access_token'])) {
        return $responseData['access_token'];
    } else {
        throw new Exception('Error fetching access token: ' . json_encode($responseData));
    }
}

function sendFCMNotification($accessToken, $data)
{
    if($data['is_notified'] == 1){
        echo "already send";
        return;
    }

    $url = 'https://fcm.googleapis.com/v1/projects/pushnotification-43ae5/messages:send';

    $body = json_encode([
        "message" => [
            "topic" => "news",
            "notification" => [
                "title" => "Ku Event",
                "body" => "กิจกรรม '" . $data['name'] . "' กำลังจะจัดวันนี้เวลา " . $formattedTime = date('G นาฬิกา', strtotime($data['start_date'])),
                "image" => "http://ku-event.42web.io/api/getImage.php?event_id=41", //ลิ้งรูป
            ],
            "android" => [
                "priority" => "high",
                "notification" => [
                    "channel_id" => "high_importance_channel" // โชว์แจ้งเตือน
                ]
            ],
            "data" => [
                "story_id" => "story_12345"
            ]
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        throw new Exception('Error sending FCM notification: ' . curl_error($ch));
    }
   
    if (setSendNOTIFY($data)) {
        echo 'อัปเดตสถานะการแจ้งเตือนสำเร็จ';
    } else {
        echo 'เกิดข้อผิดพลาดในการอัปเดตสถานะการแจ้งเตือน';
    }
    echo 'Response: ' . $response;
}

function setSendNOTIFY($data) {
    // ตรวจสอบว่า $data ไม่ใช่ null และมี 'id' ที่เป็นตัวเลข
    if ($data === null || !isset($data['id']) || !is_numeric($data['id'])) {
        echo "ข้อมูลไม่ถูกต้องสำหรับการอัปเดต";
        return false;
    }

    require 'dbconnect.php';

    // ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
    if ($conn->connect_error) {
        echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error;
        return false;
    }

    $sql = "UPDATE events SET is_notified = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
        return false;
    }

    $stmt->bind_param("i", $data['id']);
    $result = $stmt->execute();

    if ($result === false) {
        echo "เกิดข้อผิดพลาดในการอัปเดตฐานข้อมูล: " . $stmt->error;
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

function shouldSendNotification($currentDateTime, $scheduledDateTime)
{
    $dateTimeScheduled = new DateTime($scheduledDateTime);
    $dateTimeCurrent = new DateTime($currentDateTime);

    $dateTimeScheduled->modify('-1 hour');
    return $dateTimeCurrent >= $dateTimeScheduled && $dateTimeCurrent < (new DateTime($scheduledDateTime));
}

function geteventForNotification($getwhat)
{
    try {
        switch ($getwhat) {
            case 'gettime':
                require 'dbconnect.php';
                $sql = "SELECT start_date FROM events WHERE start_date > NOW() AND is_notified = 0 ORDER BY start_date ASC LIMIT 1;";
                break;
            case 'getAll':
                require 'dbconnect.php';
                $sql = "SELECT * FROM events WHERE start_date > NOW() AND is_notified = 0  ORDER BY start_date ASC LIMIT 1;";
                break;
            default:
                throw new Exception("Invalid parameter: $getwhat");
        }

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $dataEvent = $result->fetch_assoc();
            return $getwhat === 'gettime' ? $dataEvent['start_date'] : $dataEvent;
        } else {
            return null; // กรณีไม่มีผลลัพธ์
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return null; // กรณีเกิดข้อผิดพลาด
    }
}

date_default_timezone_set('Asia/Bangkok');
$currentDateTime = date('Y-m-d H:i:s');

//test if true
if (shouldSendNotification($currentDateTime, geteventForNotification("gettime"))) {
    try {
        $accessToken = getAccessToken($jsonKey);
        sendFCMNotification($accessToken, geteventForNotification("getAll"));
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
else{
    echo "no new event";
}
function base64UrlEncode($data)
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

