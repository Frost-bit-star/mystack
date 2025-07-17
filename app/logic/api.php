<?php
// app/public/api.php

require_once __DIR__ . '/../connection/init.php';
require_once __DIR__ . '/../logic/helpers.php';
require_once __DIR__ . '/../logic/router.php';

// Allow CORS for any frontend
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Initialize router
$router = new Router();

// Sample hello route for testing frontend
$router->get('/hello', function() {
    jsonResponse(['message' => 'Hello from Stack Framework API']);
});

// Auth routes
$router->post('/register', function() {
    require_once __DIR__ . '/../logic/vash.php';
});

$router->post('/login', function() {
    require_once __DIR__ . '/../logic/auth.php';
});

// AI example route
$router->post('/ai', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || !isset($input['userId']) || !isset($input['message'])) {
        jsonResponse(['error' => 'Invalid input'], 400);
    }

    require_once __DIR__ . '/../logic/ai.php';
    $reply = fetchStackVerifyAI($input['userId'], $input['message']);
    jsonResponse(['reply' => $reply]);
});

// Dispatch routes
$router->dispatch();

// If no route matched, return 404
jsonResponse(['error' => 'Endpoint not found'], 404);