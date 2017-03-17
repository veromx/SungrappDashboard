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
    public function index(Request $request)
    {
		$suppliers = [];
        // switch ($request->exists('option')){
        //     case 'messages':
        //         // get a potencial supplier and messages
        //         $suppliers = Supplier::with('messages')
        //             ->potentialSuppliers()
        //             ->get();
        //         break;
		//
        //     case 'potencial_suppliers':
        //         // get potencial suppliers
        //         $suppliers = Supplier::potentialSuppliers()->get();
        //         break;
		//
        //     default:
                // get all suppliers
                $suppliers = Supplier::with('project')->onlySuppliers()->get();
                // break;
        // }

		return view('suppliers.index',compact('suppliers'));
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
        // Create a supplier
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
		return view('suppliers.edit', compact('supplier'));
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
		$request->session()->flash('success', 'Proveedor modificado correctamente');
		return $request->expectsJson() ? $supplier
		: redirect()->action('SupplierController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deletes a supplier
		Supplier::findOrFail($id)->delete();

        // returns all the active suppliers
		return Supplier::all();
    }
}
