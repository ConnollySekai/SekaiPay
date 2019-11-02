<?php

namespace App\Observers;

use App\Invoice;
use App\Mail\NotifyUser;
use App\Mail\NotifyClient;
use App\Events\InvoiceCreated;
use Illuminate\Support\Facades\Mail;

class InvoiceObserver
{
    /**
     * Handle the invoice "created" event.
     *
     * @param  \App\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $business_email = $invoice->business_email;

        $client_email = $invoice->client_email;

        /* Send Email to User */
        Mail::to($business_email)
            ->locale(\App::getLocale())
            ->send(new NotifyUser($invoice));

        /* Send Email to Client */
        Mail::to($client_email)
            ->locale(\App::getLocale())
            ->send(new NotifyClient($invoice));

        event(new InvoiceCreated($invoice));
    }
}
