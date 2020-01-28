<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupDB extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice_filename;

    public $invoice_items_filename;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice_filename, $invoice_items_filename)
    {
        $this->invoice_filename = $invoice_filename;

        $this->invoice_items_filename = $invoice_items_filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice Backup')
                ->attachFromStorage("/backup/{$this->invoice_filename}")
                ->attachFromStorage("/backup/{$this->invoice_items_filename}")
                ->view('mail.backup');
    }
}
