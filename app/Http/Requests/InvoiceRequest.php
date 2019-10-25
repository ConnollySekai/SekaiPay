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
            'business_mobile_number' => ['sometimes', 'max:191'],
            'btc_address' => ['required', 'string', 'confirmed', 'max:191'],
            'client_name' => ['required', 'string', 'max:191'],
            'client_email' => ['required', 'string', 'email', 'max:191'],
            'client_mobile_number' => ['sometimes', 'max:191']
        ];
    }
}
