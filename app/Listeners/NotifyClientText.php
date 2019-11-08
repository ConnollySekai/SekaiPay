<?php

namespace App\Listeners;

use Nexmo;
use App\Events\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyClientText implements ShouldQueue
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
       if ($event->invoice->client_mobile_number !== null) {
        
            $client_number = format_mobile_number($event->invoice->client_mobile_number);

            $locale = $event->locale;

            Nexmo::message()->send([
                'type' => 'unicode',
                'to'   => $client_number,
                'from' => env('NEXMO_SMS_FROM'),
                'text' => trans('translations.client_text_message',['business_name' => $event->invoice->business_name,'contract_id' => $event->invoice->contract_id], $locale)
            ]);
       }
       
    }
}
