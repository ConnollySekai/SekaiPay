<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'contract_id',
        'business_name',
        'business_email',
        'business_contact_number',
        'btc_address',
        'client_name',
        'client_email',
        'client_contact_number',
        'notes'
    ];

    /**
     * Get invoice by contract ID
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param string $contract_id
     * @return 
     */
    public function scopeGetByContractId($query, $contract_id)
    {
        return $query->where('contract_id',$contract_id);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'contract_id';
    }
}

