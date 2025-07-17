<?php
/**
 * Stack Framework - Minimal Test Kit (CLI Safe, Error Free)
 *
 * Run via:
 *   php test.php
 */

declare(strict_types=1);

echo "=== 🚀 Stack Framework Minimal Test Kit ===\n\n";

// Detect CLI mode
define('IS_CLI', php_sapi_name() === 'cli');

// Load core initialization safely
require_once __DIR__ . '/app/connection/init.php';

$results = [];

/**
 * ✅ Test 1: Database connection
 */
try {
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
    $results[] = "[DB TEST] ✅ Connected successfully. Tables: " . implode(', ', $tables);
} catch (Exception $e) {
    $results[] = "[DB TEST] ❌ Failed: " . $e->getMessage();
}

/**
 * ✅ Test 2: AI Integration (if available)
 */
if (function_exists('fetchStackVerifyAI')) {
    $aiReply = fetchStackVerifyAI('test-user', 'Hello Stack AI, what can you do?');
    $short = substr($aiReply, 0, 60) . '...';
    $results[] = "[AI TEST] ✅ AI responded: $short";
} else {
    $results[] = "[AI TEST] ⚠️ Skipped (function not found).";
}

/**
 * ✅ Test 3: Routes existence check
 */
$publicDir = __DIR__ . '/app/public/';
$routes = ['home', 'about'];
foreach ($routes as $route) {
    $file = $publicDir . $route . '.php';
    if (file_exists($file)) {
        $results[] = "[ROUTE TEST] ✅ Route '$route' exists.";
    } else {
        $results[] = "[ROUTE TEST] ⚠️ Route '$route' missing.";
    }
}

/**
 * ✅ Summary output
 */
echo implode("\n", $results) . "\n\n";
echo "=== ✅ TESTS COMPLETE ===\n";