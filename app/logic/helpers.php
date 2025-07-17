<?php
/**
 * helpers.php
 * Global helper functions for Stack Framework
 */

// Clean input string
function clean($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

// JSON Response with status code
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Redirect to another page
function redirect($url) {
    header("Location: $url");
    exit;
}

// Generate random string
function randomString($length = 10) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}