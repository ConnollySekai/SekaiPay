<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display Invoice 
     *
     * @param 
     * @return 
     */
    public function show(Request $request, Invoice $invoice)
    {
        return view('invoice')->with([
            'invoice' => $invoice
        ]);
    }
}
