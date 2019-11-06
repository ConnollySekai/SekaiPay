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
        $amount = bcmul((string)$price, (string)$quantity, 8);
      //  return $amount/ 1e8;
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
        return preg_replace('/(\.{1}0+)$|(?<=\d)0+$/', '', (string)$number);
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

if (!function_exists('format_mobile_number')) {

    /**
     * removes + and - in the phone number
     *
     * @param string $mobile_number
     * @return string
     */
    function format_mobile_number($mobile_number) {
        $pattern = '/[-]|[+]|[ ]/i';
        $replacement = '';
        return preg_replace($pattern, $replacement, $mobile_number);
    }
}

if (!function_exists('create_unique_id')) {

    /**
     * Generates a unique id
     *
     * @param $length
     * @return string
     */
    function create_unique_id($length) 
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
        }

        return $token.uniqid();
    }
}

if (!function_exists('crypto_rand_secure')) {

    /**
     * Generates random number
     *
     * @param $min
     * @param $max
     * @return int
     */
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
}
