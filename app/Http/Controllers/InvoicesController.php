<?php

namespace Sungrapp\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Controllers\Cfdi\TraductorNumeroLetras;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Display the Invoices in the DB
        return Invoice::all();
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return $invoice;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInvoiceRequest $request, Invoice $invoice)
    {
		// 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
    
}
