<?php

namespace Sungrapp\Http\Controllers\Auth;

use Sungrapp\Models\User;
use Sungrapp\Http\Requests\StoreUserRequest;
use Sungrapp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('guest');
    }

	public function showRegistrationForm(){
        return view('auth.register');
    }

	public function register(StoreUserRequest $request){

		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		event(new Registered($user = User::create($input)));

		$this->guard()->login($user);

		return $this->registered($request, $user)
						?: redirect($this->redirectPath());
	}

	protected function guard()
	{
		return Auth::guard();
	}

	protected function registered(StoreUserRequest $request, $user)
    {
        //
    }

}
