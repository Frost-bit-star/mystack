<?php
/**
 * session.php
 * Session management functions for Stack Framework
 */

// Set session value
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

// Get session value or default
function getSession($key, $default = null) {
    return $_SESSION[$key] ?? $default;
}

// Destroy session
function destroySession() {
    session_unset();
    session_destroy();
}