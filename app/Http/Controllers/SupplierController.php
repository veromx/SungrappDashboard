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
        $suppliers = Supplier::all();
		return $suppliers;
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
    public function store(StoreSupplierRequest $r)
    {
        $new_supplier = new Supplier([
			'full_name'			=>$r->full_name,
			'rfc'				=>$r->rfc,
			'email'				=>$r->email,
			'project_name'		=>$r->project_name,
			'logo_file_name'	=>$r->logo_file_name,
			'address_id'		=>$r->address_id
		]);
		$new_supplier->save();
		return $new_supplier;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        // return $supplier;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreSupplierRequest $supplier)
    {
		$supplier->full_name			=$supplier->:$r->full_name;
		$supplier->rfc					=is_null($r->rfc)?$supplier->:$r->rfc;
		$supplier->email				=is_null($r->email)?$supplier->:$r->email;
		$supplier->project_name			=is_null($r->project_name)?$supplier->:$r->project_name;
		$supplier->logo_file_name		=is_null($r->logo_file_name)?$supplier->:$r->logo_file_name;
		$supplier->address_id			=is_null($r->address_id)?$supplier->:$r->address_id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		Supplier::findOrFail($id)->delete();
		return Supplier::withTrashed()->find($id);
    }
}
