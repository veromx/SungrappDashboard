<?php

namespace Sungrapp\Http\Controllers;

use Sungrapp\Models\User;
use Sungrapp\Models\Supplier;
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
        // Some view to create
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
		return User::create($input);
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
        //	Some view to edit
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
		// we find or fail the desired user by their id
		User::regulars()->findOrFail($id)->delete();

		// then we return the list of the regular users with our regular users scope
		return User::regulars()->get();
    }

}
