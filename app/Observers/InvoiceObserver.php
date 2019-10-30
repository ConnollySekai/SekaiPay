<?php

namespace App\Observers;

use stdClass;
use App\Invoice;
use App\Notifications\NofityUser;
use Illuminate\Support\Facades\Notification;

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

        /* $user = new stdClass();

        $user->email = $invoice->business_email;

        $client = new stdClass();

        $client->email = $invoice->client_email;

        Notification::locale(\App::getLocale())->send($user, new NofityUser()); */
    }
}
