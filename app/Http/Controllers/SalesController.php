<?php

namespace Sungrapp\Http\Controllers;

use Illuminate\Http\Request;
use Sungrapp\Models\Sale;
use Sungrapp\Request\StoreSaleRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = []; 
        switch ($request->exists('option')){
            case 'expired_accounts':
                // get the expired accounts
                $sales = Sale::get(); 


                break; 

            default:
                $sales = Sale::all();
                break; 
        }

		return $sales; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        // store a new sale
        return Sale::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::with('supplier')->findOrFail($id); 

        return $sale;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSaleRequest $request, Sale $sale)
    {
		// Update with the request info
		$sale->update($request->all());
		return $sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deltes a sale
		//Sale::findOrFail($id)->delete();

        // returns all the active sales
		return Sale::all();
    }
}
