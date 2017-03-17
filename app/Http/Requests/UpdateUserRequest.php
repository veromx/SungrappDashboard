<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sungrapp\Models\User;

class UpdateUserRequest extends FormRequest
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
        return [	// TODO: forbid password change
			'first_name'	=>'max:60',
			'email'			=>'email|max:45|unique:users,email,'.$this->user,
			'user_type'		=>'max:45'
        ];
    }
}
