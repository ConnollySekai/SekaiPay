<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Displays Homepage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @return 
     */
    public function index(Request $request)
    {
        $contract_id = $request->input('contract_id'); 

        $invoice = Invoice::getByContractId($contract_id)->first();

        return view('home')->with([
            'invoice' => $invoice
        ]);
    }
}
