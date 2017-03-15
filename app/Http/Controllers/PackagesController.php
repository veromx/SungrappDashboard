<?php

namespace Sungrapp\Http\Controllers;

use Illuminate\Http\Request;
use Sungrapp\Models\Package; 
use Sungrapp\Http\Requests\StorePackageRequest;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Package::all();
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
    public function store(StorePackageRequest $request)
    {
        // Create a Package 
        return Package::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return $package;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackageRequest $request, Package $package)
    {
		// Update with the request info
		$package->update($request->all());
		return $package;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deletes a Package
		Package::findOrFail($id)->delete();

        // returns all the active Packages
		return Package::all();
    }
}
