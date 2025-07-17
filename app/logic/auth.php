<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

$action = $data['action'] ?? '';

if ($action === 'request_code') {
    $email = trim($data['email'] ?? '');
    $username = trim($data['username'] ?? '');
    if (!$email || !$username) {
        echo json_encode(['success' => false, 'error' => 'Email and username required.']);
        exit;
    }

    // Call your OTP API
    $payload = json_encode([
        'company' => 'stack',
        'username' => $username,
        'email' => $email
    ]);

    $ch = curl_init('https://rocketverify.onrender.com/request-code');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $result = curl_exec($ch);
    curl_close($ch);

    echo $result;
    exit;
}

if ($action === 'verify_code') {
    $email = trim($data['email'] ?? '');
    $code = trim($data['code'] ?? '');

    if (!$email || !$code) {
        echo json_encode(['success' => false, 'error' => 'Email and code required.']);
        exit;
    }

    // Call your OTP verification API
    $payload = json_encode([
        'email' => $email,
        'code' => $code
    ]);

    $ch = curl_init('https://rocketverify.onrender.com/verify-code');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $result = curl_exec($ch);
    curl_close($ch);

    echo $result;
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid action.']);