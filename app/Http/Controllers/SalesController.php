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
    public function index()
    {
		// Display the sales 
        return Sales::all();
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
    public function store(StoreSaleRequest $request)
    {
        // store a new sale
        return Sale::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
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
