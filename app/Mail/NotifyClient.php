<?php

namespace App\Mail;

use App;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyClient extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;

    public $locale;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->locale = App::getLocale();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('translations.invoice_created'))
                ->view('mail.notifyClient');
    }
}
