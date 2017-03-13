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
            'name' => 'required|string',
            'active_time' => 'required|string',
            'num_users' => 'required|numeric',
            'email' => 'required|boolean',
            'cost' => 'required|numeric'
        ];
    }
}
