<?php

namespace App\Http\Controllers;

use DB;
use App\Invoice;
use App\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Creates a new invoice
     *
     * @param Illuminate\Http\Request;
     */
    public function store(InvoiceRequest $request)
    {

        $invoice = DB::transaction(function() use($request) {

            $created = Invoice::create([
                'contract_id' => md5(uniqid(rand(), true)),
                'business_name' => $request->input('business_name'),
                'business_email' => $request->input('business_email'),
                'business_mobile_number' => $request->input('business_mobile_number'),
                'btc_address' => $request->input('btc_address'),
                'client_name' => $request->input('client_name'),
                'client_email' => $request->input('client_email'),
                'client_mobile_number' => $request->input('client_mobile_number'),
                'notes' => $request->input('notes')
            ]);

            $items = $request->input('items');

            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $created->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'price_in_satoshi' => $item['price_in_satoshi']
                ]);
            }

            return $created;
        });

        if ($invoice) {

            return response()->json([
                'message' => 'success',
                'contract_id' => $invoice->contract_id
            ],200);
        }
    }

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

    /**
     * Get invoice data
     *
     * @return 
     */
    public function getData(Request $request)
    {
        $contract_id = $request->input('contract_id');

        $invoice = Invoice::with('items')
                    ->where('contract_id',$contract_id)
                    ->first();

        return response()->json([
            'message' => 'success',
            'invoice' => $invoice
        ]);
    }
}
//https://github.com/denpamusic/php-bitcoinrpc/blob/master/src/functions.php