<?php

namespace App;

class WitApi
{
    /** @var string*/
    protected $authorizationKey;

    /** @var  PriceModel */
    protected $priceModel;

    /** @var  PlanningModel */
    protected $planningModel;

    /**
     * WitApi constructor.
     *
     * @param string $authorizationKey
     */
    public function __construct($authorizationKey)
    {
        $this->authorizationKey = $authorizationKey;
        $this->priceModel = new PriceModel();
        $this->planningModel = new PlanningModel();
    }

    /**
     * Get answer
     * @param string $message
     * @return string
     */
    public function getAnswer($message) {
        $output = $this->getServerOutput($message);

        $answer = "";

        //if question is about price
        if (isset($output->entities->intent[0]) && $output->entities->intent[0]->value == "valuation") {
            if (isset($output->entities->item)) {
                foreach ($output->entities->item as $item) {
                    $answer .= $this->priceModel->getPrice($item);
                }
            }
        }

        //if question is about planning
        if (isset($output->entities->intent[0]) && $output->entities->intent[0]->value == "planning") {
            $activity = "";
            if (isset($output->entities->activity[0]->value)) {
                $activity = $output->entities->activity[0]->value;
            }
            foreach ($output->entities->datetime[0]->values as $value) {
                $answer .= $this->planningModel->getPlanAction($value, $activity);
                break;
            }
        }

        return $answer ?: "Sorry, I don´t understand.";
    }

    /**
     * connect to wit
     * @param string $message
     * @return string
     */
    private function getServerOutput($message) {
        $ch = curl_init();
        $header = array();
        $header[] = "Authorization: Bearer " . $this->authorizationKey;
        $witVersion = date("Ynd");
        $witURL = "https://api.wit.ai/message?v=" . $witVersion . "&q=" . $message;

        curl_setopt($ch, CURLOPT_URL, $witURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $serverOutput = curl_exec ($ch);

        curl_close ($ch);

        return json_decode($serverOutput);
    }

}