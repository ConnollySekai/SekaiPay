<?php

namespace App\Console\Commands;

use App\invoice;
use App\Mail\BackupDB;
use App\Exports\InvoicesExport;
use Illuminate\Console\Command;
use App\Exports\InvoiceItemsExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class MailExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:mail-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an excel file and send to email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            $invoice_filename = "invoice-backup-".time();

            $invoice_items_filename = "invoice-items-backup-".time();

            Excel::store(new InvoicesExport(), 'backup/'.$invoice_filename.'.xlsx');

            Excel::store(new InvoiceItemsExport(), 'backup/'.$invoice_items_filename.'.xlsx');

            Mail::to(env('MAIL_BACKUP_TO'))
            ->send(new BackupDB($invoice_filename.".xlsx",$invoice_items_filename.".xlsx"));

        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
}
