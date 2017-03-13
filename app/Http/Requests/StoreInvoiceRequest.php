<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'sale_id' => 'required|integer',
            'status_invoice' => 'required|string',
            'folio' => 'required',
            'serie' => 'required',
            'folio_fiscal' => 'required'
        ];
    }
}
