<?php

if (!function_exists('to_btc')) {
    /**
     * Converts from satoshi to bitcoin.
     *
     * @param int $satoshi
     *
     * @return string
     */
    function to_btc($satoshi) : string
    {
        return bcdiv((string) $satoshi, (string) 1e8,8);
    }
}

if (!function_exists('to_fixed')) {
    /**
     * Brings number to fixed precision without rounding.
     *
     * @param string $number
     * @param int    $precision
     *
     * @return string
     */
    function to_fixed(string $number, int $precision = 8) : string
    {
        $number = bcmul($number, (string) pow(10, $precision));
        return bcdiv($number, (string) pow(10, $precision), $precision);
    }
}

if (!function_exists('compute_amount')) {

    /**
     * Computes amount based on quantity and satoshi
     *
     * @param $price 
     * @oaran $quantity
     * @return string
     */
    function compute_amount($price, $quantity)
    {
        $amount = $price * $quantity;

        return to_btc($amount);
    }
}

if (!function_exists('format_number')) {

    /**
     * Removes trailing zeros from a number
     *
     * @param $number
     * @return 
     */
    function format_number($number)
    {
        return preg_replace('/(\.?0+)$/', '', (string)$number);
    }
}

if (!function_exists('trim_mobile_number')) {

    /**
     * Removes training dash in the mobile number 
     *
     * @param $mobile_number
     * @return string
     */
    function trim_mobile_number($mobile_number) 
    {
        return rtrim($mobile_number,'-');
    }
}