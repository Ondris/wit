<?php

namespace App;

class ChatbotAI
{
    /** @var  */
    protected $config;

    /** @var  WitApi */
    protected $witApi;

    /**
     * ChatbotAI constructor.
     *
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->witApi = new WitApi($this->config['authorization_key']);
    }

    /**
     * Get the answer to the user's message
     *
     * @param $message
     * @return string
     */
    public function getAnswer(string $message, $type)
    {
        if ($type == "wit") {
            return $this->witApi->getAnswer($message);
        } else {
            return "Return simple message " . $message;
        }
    }

}