<?php

namespace App\Services;

class Coinbase {

    /**
     * Get rates based on currency
     *
     * @param $ticker
     * @return Array
     */
    public function getRates($ticker)
    {
        $url = "https://api.coinbase.com/v2/exchange-rates?currency={$ticker}";

        $data = json_decode(file_get_contents($url), true);

        return $data['data']['rates'];
    }

    /**
     * Get spot price based on currency
     *
     * @param string $ticker
     * @return Array
     */
    public function getSpotPrice($ticker)
    {
        $url = "https://api.coinbase.com/v2/prices/spot?currency={$ticker}";

        $data = json_decode(file_get_contents($url), true);

        return $data['data']['amount'];
    }

    /**
     * Get equivalent btc of the given currency
     *
     * @param $ticker
     * @return string
     */
    public function getBtcRate($ticker)
    {
        $rates = self::getRates($ticker);

        return $rates['BTC'];
    }
}