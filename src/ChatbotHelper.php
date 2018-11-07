<?php

namespace App;


use Dotenv\Dotenv;

class ChatbotHelper
{

    protected $chatbotAI;
    protected $facebookSend;
    private $accessToken;
    public $config;

    /**
     * ChatbotHelper constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $dotenv = new Dotenv(dirname(__FILE__, 2));
        $dotenv->load();
        $this->accessToken = getenv("PAGE_ACCESS_TOKEN");
        $this->config = include("config.php");
        $this->chatbotAI = new ChatbotAI($this->config);
        $this->facebookSend = new FacebookSend();
    }

    /**
     * Get the sender id of the message
     * @param $input
     * @return mixed
     */
    public function getSenderId($input)
    {
        return $input["entry"][0]["messaging"][0]["sender"]["id"];
    }

    /**
     * Get the user's message from input
     * @param $input
     * @return mixed
     */
    public function getMessage($input)
    {
        $text = $input["entry"][0]["messaging"][0]["message"]["text"];

        $text = str_replace(" ", "%20", $text);
        $text = str_replace(":", "%3A", $text);

        return $text;
    }

    /**
     * Check if the callback is a user message
     * @param $input
     * @return bool
     */
    public function isMessage($input)
    {
        return isset($input["entry"][0]["messaging"][0]["message"]["text"]) && !isset
        ($input["entry"][0]["messaging"][0]["message"]["is_echo"]);

    }

    /**
     * Get the answer to a given user's message
     * @param string $message
     * @return string
     */
    public function getAnswer($message)
    {
        return $this->chatbotAI->getAnswer($message, "wit");
    }

    /**
     * Send a reply back to Facebook chat
     * @param $senderId
     * @param $replyMessage
     */
    public function send($senderId, string $replyMessage)
    {
        return $this->facebookSend->send($this->accessToken, $senderId, $replyMessage);
    }

    /**
     * Verify Facebook webhook
     * This is only needed when you setup or change the webhook
     * @param $request
     * @return mixed
     */
    public function verifyWebhook($request)
    {
        if (!isset($request["hub_challenge"])) {
            return false;
        };

        $hubVerifyToken = null;
        $hubVerifyToken = $request["hub_verify_token"];
        $hubChallenge = $request["hub_challenge"];

        if (isset($hubChallenge) && $hubVerifyToken == $this->config["webhook_verify_token"]) {

            echo $hubChallenge;
        }

    }
}