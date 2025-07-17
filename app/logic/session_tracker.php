<?php
/**
 * session_tracker.php
 * Stack Framework Session Tracker
 *
 * Tracks user visits, routes, IPs, and timestamps.
 * View with view_sessions() for real-time monitoring.
 */

function track_session(string $route): void {
    $sessionFile = __DIR__ . '/../logs/sessions.log';

    // Gather user data
    $data = [
        'time' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'route' => $route,
        'session_id' => session_id(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];

    // Convert to JSON line for easier parsing later
    file_put_contents($sessionFile, json_encode($data) . PHP_EOL, FILE_APPEND);
}

function view_sessions(): void {
    $sessionFile = __DIR__ . '/../logs/sessions.log';

    if (file_exists($sessionFile)) {
        header('Content-Type: text/plain');
        $lines = file($sessionFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if ($entry) {
                echo "[{$entry['time']}] {$entry['ip']} visited {$entry['route']} | Session: {$entry['session_id']}\n";
            }
        }
    } else {
        echo "No sessions tracked yet.";
    }
}