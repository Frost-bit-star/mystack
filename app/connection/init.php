<?php

/**
 * Stack Framework init.php
 * Loads environment, autoloads classes, and initializes DB connection.
 */

date_default_timezone_set('UTC');
session_start();

// Autoload Core Files (logic, db, connection)
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../logic/' . $class . '.php',
        __DIR__ . '/../db/' . $class . '.php',
        __DIR__ . '/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});

// Load Env Config (Optional .env at root)
$config = @parse_ini_file(__DIR__ . '/../.env');

// SQLite Connection
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../db/app.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'DB Connection Failed: ' . $e->getMessage()]));
}

// JSON Response Helper (for APIs)
function respond($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}