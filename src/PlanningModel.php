<?php

namespace App;

class PlanningModel
{
    public function __construct()
    {
    }

    /**
     * @param string $datetime
     * @return string
     */
    public function getPlanAction($datetime, $activity) {
        if (!isset($datetime->value)) {
            return "";
        }
        $value = str_replace("T", " ", $datetime->value);
        $datetime = date_create_from_format("Y-m-d G:i:s.ue", $value);

        if ($activity) {
            return "I set reminder on " . $datetime->format("j. n. Y G:i") . ": " . $activity . ". ";
        } else {
            return "I set reminder on " . $datetime->format("j. n. Y G:i") . ". ";
        }
    }

}