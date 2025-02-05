<?php

// AI

function chatWithGPT($userMessage)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $apiKey = "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"; // Replace with your API key
    $apiUrl = "https://api.openai.com/v1/chat/completions";

    $data = [
        "model" => "gpt-3.5-turbo", // You can use gpt-4 if available
        "messages" => [
            ["role" => "system", "content" => "You are a helpful chatbot."],
            ["role" => "user", "content" => $userMessage]
        ],
        "max_tokens" => 150
    ];

    $headers = [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);

    if (!$response) {
        die("Error: " . curl_error($ch));
    }

    curl_close($ch);

    $decoded = json_decode($response, true);
    print_r($decoded);
    // return $decoded["choices"][0]["message"]["content"] ?? "No response from AI.";
}

// Example usage
if (isset($_POST['message'])) {
    echo chatWithGPT($_POST['message']);
}

?>