<?php

namespace Sungrapp\Http\Controllers;

use Sungrapp\Models\Supplier;
use Illuminate\Http\Request;
use Sungrapp\Http\Requests\StoreSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Display the suppliers in the DB
        return Supplier::all();
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
    public function store(StoreSupplierRequest $request)
    {
        // Create a supplier with the information on the request
		// At this point it was entirely validated by the request and the values in the model
        return Supplier::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return $supplier;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSupplierRequest $request, Supplier $supplier)
    {
		// Update with the request info
		$supplier->update($request->all());
		return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deltes a supplier
		Supplier::findOrFail($id)->delete();

        // returns all the active suppliers
		return Supplier::all();
    }
}
