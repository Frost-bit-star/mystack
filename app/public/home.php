<?php
// public/home.php

require_once 'header.php';
require_once __DIR__ . '/../logic/ai.php';

$userId = 'demo-user';
$userMessage = $_POST['message'] ?? null;
$aiReply = null;

if ($userMessage) {
    $aiReply = fetchStackVerifyAI($userId, $userMessage);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stack Framework Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col">

  <main class="flex-grow container mx-auto px-4 py-8">

    <div class="mb-10 text-center">
      <h1 class="text-4xl font-bold mb-2">Welcome to Stack Framework</h1>
      <p class="text-gray-400 max-w-2xl mx-auto">
        A lightweight PHP framework using <code>SQLite3</code> built for clean, scalable APIs with minimal setup.
      </p>
      <p class="mt-4">
        <a href="?route=about" class="text-blue-400 hover:underline">Visit About Page</a>
      </p>
    </div>

    <section class="bg-gray-800 rounded-lg p-6 mb-12">
      <h2 class="text-2xl font-semibold mb-4 flex items-center justify-center gap-2">
        <!-- Inline AI SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        Stack AI Chat
      </h2>

      <form method="POST" class="flex flex-col md:flex-row items-center gap-4">
        <input type="text" name="message" placeholder="Ask Stack AI anything..." required
          class="flex-grow px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
        <button type="submit"
          class="px-4 py-2 bg-green-600 rounded hover:bg-green-700 transition">Send</button>
      </form>

      <?php if ($aiReply): ?>
        <div class="mt-6 bg-gray-700 rounded p-4">
          <p class="text-green-400">AI Reply:</p>
          <p class="mt-2"><?php echo htmlspecialchars($aiReply); ?></p>
        </div>
      <?php endif; ?>
    </section>

    <section class="bg-gray-800 rounded-lg p-6">
      <h2 class="text-2xl font-semibold mb-4 flex items-center justify-center gap-2">
        <!-- Inline Mail SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m0 4l4 4m6-4a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Email OTP Integration
      </h2>

      <p class="text-gray-400">
        Stack Framework supports secure email OTP verification.
      </p>
      <ol class="list-decimal list-inside mt-4 text-gray-300">
        <li>Open <code>js-pack/email.js</code></li>
        <li>Include it in your registration or forgot password page</li>
        <li>Call its functions to send and verify OTP seamlessly</li>
      </ol>
      <p class="mt-4 text-gray-400">
        This ensures your flows are secure and production-ready with minimal setup.
      </p>
    </section>

  </main>

  <?php require_once 'footer.php'; ?>
</body>
</html>