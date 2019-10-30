<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business_name' => ['required', 'string', 'max:191'],
            'business_email' => ['required', 'string', 'email', 'max:191'],
            'business_calling_code' => ['required_with:business_mobile_number','not_in:+'],
            'business_mobile_number' => ['required_with:business_calling_code','sometimes', 'max:191'],
            'btc_address' => ['required', 'string', 'confirmed', 'max:191'],
            'client_name' => ['required', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'email', 'max:191'],
            'client_calling_code' => ['required_with:client_mobile_number','not_in:+'],
            'client_mobile_number' => ['required_with:client_calling_code','sometimes', 'max:191'],
            'items.*.description' => ['required'],
            'items.*.quantity' => ['required'],
            'items.*.price_in_satoshi' => ['required','not_in:0']
        ];
    }
}
