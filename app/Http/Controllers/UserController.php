<?php

namespace Sungrapp\Http\Controllers;

use Sungrapp\Models\User;
use Illuminate\Http\Request;
use Sungrapp\Http\Requests\StoreUserRequest;
use Sungrapp\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->except(1);
		return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Some view to create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $r)
    {
		$new_user = new User([	'first_name'	=>$r->first_name,
								'last_name'		=>$r->last_name,
								'email'			=>$r->email,
								'password'		=>bcrypt($r->password),
								'user_type'		=>$r->user_type,
							]);
		$new_user->save();
		return $new_user;
	}

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->id===1){
			abort(404);
		}
		return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //	Some view to edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $r, User $user)
    {
		if($user->id===1){
            // hay que hacer un return enviar un mensaje de error 
			abort(403);
		}

        $user->first_name = is_null($r->first_name)?$user->first_name:$r->first_name;
        $user->last_name = is_null($r->last_name)?$user->last_name:$r->last_name;
        $user->email = is_null($r->email)?$user->email:$r->email;
		$user->user_type = is_null($r->user_type)?$user->user_type:$r->user_type;

		$user->save();
		return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id!==1){
			User::findOrFail($id)->delete();
		}
		return User::withTrashed()->find($id);
    }
}
