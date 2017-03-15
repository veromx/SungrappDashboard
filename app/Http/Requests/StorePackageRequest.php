<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'name' => 'required|string',
            'active_time' => 'required|string',
            'time_period_type' => 'required|string',
            'num_users' => 'numeric',
            'num_customers' => 'numeric',
            'email' => 'required|boolean',
            'cost' => 'required|numeric'
        ];
    }
}
