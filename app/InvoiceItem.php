<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'price_in_satoshi'
    ];

    /**
     * Invoice relationship
     *
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    /**
     * Converts satoshi to btc
     *
     * @return string
     */
    public function getPriceInBtcAttribute()
    {
        return to_btc((string)$this->price_in_satoshi);
    }

}
