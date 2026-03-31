<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test Telegram connectivity
$token = config('services.telegram.bot_token');
$chatId = config('services.telegram.chat_id');

echo "Testing Telegram Bot Configuration...\n\n";
echo "Bot Token: " . ($token ? substr($token, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Chat ID: " . ($chatId ?? 'NOT SET') . "\n\n";

if (!$token || !$chatId) {
    echo "❌ ERROR: Telegram credentials not configured properly!\n";
    echo "Please check your .env file for:\n";
    echo "TELEGRAM_BOT_TOKEN=your_bot_token_here\n";
    echo "TELEGRAM_CHAT_ID=your_chat_id_here\n\n";
    exit(1);
}

try {
    echo "🔄 Testing bot info...\n";
    $response = Http::timeout(30)->get("https://api.telegram.org/bot{$token}/getMe");
    
    if ($response->successful()) {
        $botInfo = $response->json();
        echo "✅ Bot Info: @{$botInfo['result']['username']} ({$botInfo['result']['first_name']})\n\n";
    } else {
        echo "❌ Failed to get bot info: " . $response->body() . "\n\n";
        exit(1);
    }

    echo "🔄 Sending test message...\n";
    $testMessage = "🧪 Test Message from Portfolio\n\nThis is a test to verify Telegram bot integration.\nTime: " . date('Y-m-d H:i:s');
    
    $response = Http::timeout(30)->post(
        "https://api.telegram.org/bot{$token}/sendMessage",
        [
            'chat_id' => $chatId,
            'text' => $testMessage,
        ]
    );

    if ($response->successful()) {
        echo "✅ Test message sent successfully!\n";
        echo "Response: " . json_encode($response->json(), JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "❌ Failed to send message: " . $response->status() . "\n";
        echo "Response: " . $response->body() . "\n\n";
        
        if (strpos($response->body(), 'chat not found') !== false) {
            echo "💡 SOLUTION: The chat_id is incorrect. Make sure you:\n";
            echo "1. Start a chat with your bot\n";
            echo "2. Send a message to the bot\n";
            echo "3. Get your chat_id from: https://api.telegram.org/bot{$token}/getUpdates\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    
    if ($e->getCode() === 28) {
        echo "\n💡 SOLUTION: Connection timeout. Try:\n";
        echo "1. Check your internet connection\n";
        echo "2. Verify Telegram API is accessible\n";
        echo "3. Try increasing timeout in the controller\n";
    }
}

echo "\n🔍 Debugging complete!\n";
