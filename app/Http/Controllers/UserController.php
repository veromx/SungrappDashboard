<?php

namespace Sungrapp\Http\Controllers;

use Sungrapp\Models\User;
use Sungrapp\Models\Supplier;
use Sungrapp\Models\Lookup;
use Illuminate\Http\Request;
use Sungrapp\Http\Requests\StoreUserRequest;
use Sungrapp\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		//start with empty array for users
        $users = [];
		$by_supplier = false;	// get param init as false
		$supplier_id = $request->supplier;	// get param
        switch ($request->exists('option')){
            case 'by_supplier':
				$by_supplier = true;
				//make an array of suppliers
				$suppliers = Supplier::onlySuppliers()->get()->toArray();
				// get the non-admin users with supplier id
				$users = User::regulars()->withSupplier()
						->where('supplier_id', $supplier_id)->get()->toArray();
				return $request->expectsJson()?	$users
					:view('users.index', compact('users', 'suppliers', 'by_supplier', 'supplier_id'));
                break;

            default:
                // get the vertix users
                $users = User::regulars()->get()->toArray();

				// if request does not ask for json, give a view
                return $request->expectsJson()? $users
					:view('users.index', compact('users', 'by_supplier'));
        }

		return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$user_type = Lookup::userType()->get()->toArray();
        return view('users.register', compact('user_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
		// Encrypt password
		$input = $request->all();

		// TODO: implement Argon2 encryption
		$input['password'] = bcrypt($input['password']);

		// Creates a user
		$user = User::create($input);

		$request->session()->flash('success', 'Creado el usuario ' . $user->email);
		// returns the user details or a view
		return $request->expectsJson()?	$user
		: redirect()->route('admin');
	}

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// TODO: return an error if admin
		// We return all the other regular users with our regulars scope
		return User::regulars()->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->id===1){
			abort(403);
		}

		$user_type = Lookup::userType()->get()->toArray();
		return view('users.edit', compact('user', 'user_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
		// we cannot update the id 1
		if($id===1){
            // TODO: return an error message
			abort(403);
		}
		// We find or fail based on our supplied id
		$user = User::regulars()->findOrFail($id);
		// We update a discrete set of fields
		$user->update($request->except(['password']));
		// and return the updated user info
		$request->session()->flash('success', 'Datos de usuario actualizados');
		return $request->expectsJson()? $user
		: redirect()->action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
		// we find or fail the desired user by their id
		User::regulars()->findOrFail($id)->delete();

		// then we return the list of the regular users
		$request->session()->flash('info', 'Usuario ' . User::withTrashed()->find($id)->email . ' eliminado');
		return $request->expectsJson() ? User::regulars()->get()
		: redirect()->action('UserController@index');
    }

}
