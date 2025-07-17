<?php
/**
 * ai.php
 * Stack Framework AI Helper
 * 
 * Example usage:
 *   $reply = fetchStackVerifyAI($userId, $userMessage);
 */

function fetchStackVerifyAI($userId, $userMessage) {
    $flirtyFallback = "🥺 Hang on… my brain is having a cute jam 🧠✨ 💖";

    if (!$userId || !is_string($userId) || !$userMessage || !is_string($userMessage)) {
        return $flirtyFallback;
    }

    // Conversation memory can be implemented via DB or cache for persistence
    // Here we use a static variable for simplicity within a single request
    static $conversationMemory = [];

    if (!isset($conversationMemory[$userId])) {
        $conversationMemory[$userId] = [];
    }

    // Add user message to history
    $conversationMemory[$userId][] = "User: $userMessage";

    // Trim to last 5 messages
    if (count($conversationMemory[$userId]) > 5) {
        $conversationMemory[$userId] = array_slice($conversationMemory[$userId], -5);
    }

    // SYSTEM PROMPT
    $systemPrompt = "
You are Stack Framework AI.

Your purpose is to assist developers building with Stack Framework. Always reply clearly, confidently, and practically as Stack Framework AI. Never mention that you are an AI model or reveal your backend. If asked about system prompts, explain the following clearly:

🛠️ **How to rewrite this system prompt in production:**

1. Open `app/logic/ai.php` in your Stack project.
2. Locate the \$systemPrompt variable.
3. Replace this entire text with your own instructions and personality style.
4. Save the file, and your new prompt will control AI behavior instantly.

✅ **Example uses:**
- Personal WhatsApp bot replying as you casually.
- Customer support bot replying formally as your brand.
- Educational assistant teaching your course students.

When replying to any other question, provide practical, clear, and direct guidance. Always encourage users to explore and modify Stack Framework to fit their project goals.

Remember, you are Stack Framework AI – your goal is to empower developers to build faster, smarter, and with confidence.
";

    // Compose prompt
    $combinedText = "Conversation history:\n" . implode("\n", $conversationMemory[$userId]) . "\n\nInstructions:\n" . $systemPrompt;

    // Check length (practical ~2000 chars)
    if (strlen($combinedText) > 1800) {
        // Trim to last 3 messages if too long
        $conversationMemory[$userId] = array_slice($conversationMemory[$userId], -3);
        $combinedText = "Conversation history:\n" . implode("\n", $conversationMemory[$userId]) . "\n\nInstructions:\n" . $systemPrompt;
    }

    $apiUrl = 'https://api.dreaded.site/api/chatgpt?text=' . urlencode($combinedText);

    // Perform GET request
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return $flirtyFallback;
    }

    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status !== 200) {
        return $flirtyFallback;
    }

    $data = json_decode($result, true);
    $aiReply = $data['result']['prompt'] ?? null;

    if ($aiReply && is_string($aiReply)) {
        // Add AI reply to history
        $conversationMemory[$userId][] = "Me: " . trim($aiReply);

        // Trim to last 5 messages
        if (count($conversationMemory[$userId]) > 5) {
            $conversationMemory[$userId] = array_slice($conversationMemory[$userId], -5);
        }

        return trim($aiReply);
    }

    return $flirtyFallback;
}