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
        $invoice = DB::transaction(function() use($request){
            $vendedor_id = $request->vendedor_id;
            $salida_id = $request->salida_id;

            // CFDI
            $params_factura = $this->setCfdi($vendedor_id, $salida_id);

            // crea un registro nuevo de la factura
            $invoice = Invoice::create($params_factura);
            /* todo enviar la factura por correo al cliente */

            // Actualizar el pedido con el id de la factura
            $sale = Sale::findOrFail($salida_id);
            $sale->fill(['factura_id'=>$factura->id]);
            $sale->save();

            // If succeed, send back the just-created invoice object
            return $invoice;
        });

        return $invoice;
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
		// Update with the request info
		$invoice->update($request->all());
		return $invoice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deletes a Invoice
		//Invoice::findOrFail($id)->delete();

        // returns all the active Invoices
		return Invoice::all();
    }
    
}
