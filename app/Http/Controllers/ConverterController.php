<?php

namespace App\Http\Controllers;

use App\Services\Coinbase;

use Illuminate\Http\Request;

class ConverterController extends Controller
{
    private $coinbase;
    
    /**
     * Constructor
     *
     * @param \App\Services\Coinbase $coinbase;
     * @return void
     */
    public function __construct(Coinbase $coinbase)
    {
        $this->coinbase = $coinbase;
    }

    /**
     * Get rate based on currency
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function convert(Request $request)
    {
        $from = $request->input('from');

        $to = $request->input('to');

        $amount = ($request->input('amount')) ?? '1';

        $ticker = ($from === 'BTC') ? $to : $from;

        $rate = ($from === 'BTC') ? $this->coinbase->getSpotPrice($ticker) : $this->coinbase->getBtcRate($ticker);

        $total = $this->computeAmount($amount, $rate);

        return response()->json([
            'base_currency' => $from,
            'quoted_currency' => $to,
            'total' => format_number(number_format($total,8,'.','')),
            'rate' => format_number(number_format($rate,8,'.',''))
        ],200);
    }

    /**
     * Compute the total amount based on rate
     *
     * @param string $amount
     * @param string $rate
     * @return string
     */
    private function computeAmount($amount, $rate)
    {
        $total = bcmul($amount, $rate, 8);
       
        return format_number($total);
    }
}
