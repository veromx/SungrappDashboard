<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
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
            'package_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'total' => 'required|numeric',
            'iva' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'invoice' => 'boolean',
            'amount' => 'integer',
            'unit_price' => 'numeric|required',
            'payment_method' => 'string',
        ];
    }
}
