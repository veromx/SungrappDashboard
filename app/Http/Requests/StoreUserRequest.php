<?php

namespace Sungrapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name'	=> 'required|max:60',
			'email'			=> 'required|email|unique:users|max:45',
			'password'		=> array(	'required','min:8','max:20', 'confirmed',
										'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'),
			'password_confirmation' =>	'required|same:password',
			'user_type'		=> 'required|max:45'
        ];
    }

	public function withValidator($validator){
		$validator->after(function($validator){
			// store pass
			$password = $this->password;

			// flags
			$consecutive = false;
			$repeated = false;

			// loop over password
			for($i=0; $i<strlen($password)-1; $i++){
				$j = $password[$i];
				// check if next char is the next in alphabet or next number
				if(strtolower($password[$i+1]) === strtolower(++$j)){
					$consecutive = true;
					break;
				}
			}

			// or check if the next 2 characters are the same
			for($i=0; $i<strlen($password)-2; $i++){
				if($password[$i]  === $password[$i+1] AND $password[$i] === $password[$i+2]){
					$repeated = true;
					break;
				}
			}

			// if any of these flags were set to true
			if($consecutive){
				$validator->errors()->add('password', 'The password cannot have consecutive characters.');
			}
			if($repeated){
				$validator->errors()->add('password', 'The password cannot have repeated characters.');
			}
		});

	}
}
