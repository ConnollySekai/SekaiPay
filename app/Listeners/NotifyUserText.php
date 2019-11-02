<?php

namespace App\Listeners;

use Nexmo;
use App\Events\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserText implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        if ($event->invoice->business_mobile_number !== null) {
        
            $user_number = format_mobile_number($event->invoice->business_mobile_number);

            Nexmo::message()->send([
                'to'   => $user_number,
                'from' => env('NEXMO_SMS_FROM'),
                'text' => trans('translations.business_text_message',['client_email' => $event->invoice->client_email,'contract_id' => $event->invoice->contract_id])
            ]);
       }
    }
}
