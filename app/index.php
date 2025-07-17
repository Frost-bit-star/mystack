<?php
/**
 * Stack Framework - Home Entry Point
 *
 * All requests are routed through this file.
 */

declare(strict_types=1);

// Load core initialization
require_once __DIR__ . '/connection/init.php';

// Determine requested route, default to 'home'
$route = $_GET['route'] ?? 'home';

// Sanitize route to allow only letters, numbers, dashes, underscores
$route = preg_replace('/[^a-zA-Z0-9_-]/', '', $route);

// Resolve path to requested public file
$pageFile = __DIR__ . '/public/' . $route . '.php';

// Load the page if it exists, otherwise show 404
if (file_exists($pageFile)) {
    require_once $pageFile;
} else {
    http_response_code(404);
    echo "<h2>404 - Page Not Found</h2>";
}