<?php
require_once __DIR__ . '/../connection/init.php';
require_once __DIR__ . '/../logic/session_tracker.php';

echo "<h2>Session Tracker</h2><pre>";
view_sessions();
echo "</pre>";