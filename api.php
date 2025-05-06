<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$data = json_decode(file_get_contents('php://input'), true);

$message = $data['message'] ?? '';

if (empty($message)) {
    echo json_encode(['reply' => 'ไม่ได้รับข้อความจากผู้ใช้'], JSON_UNESCAPED_UNICODE);
    exit;
}

$apiKey = $_ENV['API_KEY'] ?? '';
if (empty($apiKey)) {
    echo json_encode(['reply' => '❌ API Key ไม่ได้ตั้งค่า'], JSON_UNESCAPED_UNICODE);
    exit;
}

// 🧠 สร้าง payload ตามโครงสร้าง Gemini API
$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => $message]
            ]
        ]
    ]
];

// 🌐 เรียก Gemini API
$apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['reply' => 'cURL error: ' . curl_error($ch)], JSON_UNESCAPED_UNICODE);
    curl_close($ch);
    exit;
}

curl_close($ch);

// 🧾 แปลงผลลัพธ์เป็น JSON
$result = json_decode($response, true);

// 🕵️ ตรวจสอบว่า Gemini ตอบกลับมาหรือไม่
if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $errorMsg = $result['error']['message'] ?? 'เกิดข้อผิดพลาดในการติดต่อ Gemini';
    echo json_encode(['reply' => '❌ ' . $errorMsg], JSON_UNESCAPED_UNICODE);
    exit;
}

// ✅ ดึงข้อความจาก Gemini
$reply = $result['candidates'][0]['content']['parts'][0]['text'];

// 🔁 ตอบกลับไปที่ frontend
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['reply' => $reply], JSON_UNESCAPED_UNICODE);
