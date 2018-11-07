<?php

require_once __DIR__ . "/vendor/autoload.php";
use App\ChatbotHelper;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $chatbotHelper->getSenderId($input);

if ($senderId && $chatbotHelper->isMessage($input)) {

    // Get the user's message
    $message = $chatbotHelper->getMessage($input);

    // Get a message back
    $replyMessage = $chatbotHelper->getAnswer($message);

    // Send the answer back to the Facebook chat
    $chatbotHelper->send($senderId, $replyMessage);

}
