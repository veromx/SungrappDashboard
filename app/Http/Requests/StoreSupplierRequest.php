<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'full_name'			=>'required|max:45',
			'rfc'				=>'max:13',
			'email'				=>'email|max:45',
			'project_name'		=>'max:45',
			'logo_file_name'	=>'max:45',
        ];
    }
}
