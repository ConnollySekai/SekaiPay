<?php

namespace App\Providers;

use App\Events\InvoiceCreated;
use App\Listeners\NotifyUserText;
use App\Listeners\NotifyClientText;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        InvoiceCreated::class => [
            NotifyUserText::class,
            NotifyClientText::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
