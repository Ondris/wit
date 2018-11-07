<?php

namespace App;

class PriceModel
{
    private $priceConfig;

    /**
     * PriceModel constructor.
     *
     */
    public function __construct()
    {
        $this->priceConfig = include('price_config.php');
    }

    /**
     * @param string $item
     * @return string
     */
    public function getPrice($item) {
        if (isset($this->priceConfig[$item->value])) {
            return $item->value . " cost ". $this->priceConfig[$item->value] . " crowns. ";
        } else {
            return "For " . $item->value . " the price was not listed. ";
        }
    }

}