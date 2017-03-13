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

    /**
     * @param $vendedor_id
     * @param $salida_id
     * @return mixed
     */
    public function setCfdi($vendedor_id, $salida_id){

        $factura = DB::transaction(function() use($vendedor_id, $salida_id){
            // obtener la venta y su detalle
            $venta = $this->getPedido($salida_id);

            // obtiene el vendedor y su direccion de facturacion
            $seller_obj = new SellersController();
            $cliente = $this->getCliente($vendedor_id, $seller_obj);

            // get credentials and other useful info for the CFDI
            $credentials = Config::get('acl.invoiceInfo');

            // obtiene el emisor y de factura y direccion
            $emisor = $seller_obj->show(1, 'factura');

            // crear el arreglo del CFDI
            $data_cfdi = $this->setDataIntoArray($cliente, $cliente->addresses->first(), $venta, $emisor, $credentials['no_certificado']);

            // creacion de CFDI
            $cfdi_obj = new Cfdi\Cfdi2XmlController($data_cfdi);
            $cfdi_obj->sellar( $credentials['cadenaOriginal'], $credentials['keyPem'], $credentials['certPem']);

            // save the request for the stamp
            $cfdi_obj->guardarXml(storage_path('invoices/'. 'cfdi_request_'.date('Ymd').'_'.$venta->id.'.xml'));

            // Timbrado de Cfdi
            $client = new \SoapClient($credentials['StampService']);
            $paramsTimbrado = array(
                'xml' => $cfdi_obj->obtenerTextoXml(),
                'username' => $credentials['user'],
                'password' => $credentials['password']
            );
            $respuestaTimbrado = $client->__soapCall("stamp", array($paramsTimbrado));

            // save the response
            $cfdi_response = new \DOMDocument("1.0","UTF-8");
            $cfdi_response->loadXML($respuestaTimbrado->stampResult->xml);
            $cfdi_response->save(storage_path('invoices/'. 'cfdi_response_'.date('Ymd').'_'.$venta->id.'.xml' ));

            // Procesar errores en el timbrado (si los hubiera)
            if (!isset($respuestaTimbrado->stampResult) || isset($respuestaTimbrado->stampResult->Incidencias->Incidencia)) {
                $mensajesErrorTimbrado = array();
                $incidenciaTimbrado = $respuestaTimbrado->stampResult->Incidencias->Incidencia;
                if (!is_array($incidenciaTimbrado)) {
                    $incidenciaTimbrado = array($incidenciaTimbrado);
                }
                foreach ($incidenciaTimbrado as $incidencia) {
                    $mensajesErrorTimbrado[] = "({$incidencia->CodigoError}) {$incidencia->MensajeIncidencia}";
                }
                abort(503, 'Error en el timbrado del CFDi: ' . implode('; ', $mensajesErrorTimbrado));
            }

            // Procesar documento xml del cfdi timbrado
            $params_factura = $this->setXmlToPDF($respuestaTimbrado, $venta, $cfdi_obj, $data_cfdi);

            return $params_factura;
        });

        return $factura;

    }

    /**
     * @param $cliente
     * @param $cliente_dir
     * @param $cliente_compra
     * @param $emisor
     * @return array
     */
    private function setDataIntoArray($cliente, $cliente_dir, $cliente_compra, $emisor, $no_certificado){

        $fecha = strtotime("-1 day");
        $fecha = date('Y-m-d\TH:i:s', $fecha);

        $emisor_dir = $emisor->addresses->toArray();
        $datosCfdi = array(
            'serie' => $cliente_compra->id,
            'folio' => $cliente_compra->id,
            'fecha' => $fecha,
            'formaDePago' => 'Pago en una sola exhibición',
            'noCertificado' => $no_certificado, //'20001000000200000293',
            'subTotal' => $cliente_compra->subtotal,
            'descuento' => '',
            'total' => $cliente_compra->total,
            'tipoDeComprobante' => 'ingreso',
            'metodoDePago' => 'Tarjeta de crédito o débito',
            'LugarExpedicion' => 'San Luis Potosí, San Luis Potosí',
            'Emisor' => [
                'rfc' => $emisor->rfc,
                'nombre' => $emisor->razon_social,
                'DomicilioFiscal' => [
                    'calle' => $emisor_dir[0]['direccion'],
                    'noExterior' => $emisor_dir[0]['num_ext'],
                    'noInterior' => $emisor_dir[0]['num_int'],
                    'colonia' => $emisor_dir[0]['colonia'],
                    'municipio' => $emisor_dir[0]['ciudad'],
                    'estado' => $emisor_dir[0]['estado'],
                    'pais' => $emisor_dir[0]['pais'],
                    'codigoPostal' => $emisor_dir[0]['codigo_postal'],
                ],
                'Regimen' => $emisor->tipo_fiscal,
            ],
            'Receptor' => [
                'rfc' => $cliente->rfc,
                'nombre' => $cliente->nombre_completo,
                'Domicilio' => [
                    'calle' => $cliente_dir->direccion,
                    'noExterior' => $cliente_dir->num_ext,
                    'noInterior' => $cliente_dir->num_int,
                    'colonia' => $cliente_dir->colonia,
                    'municipio' => $cliente_dir->ciudad,
                    'estado' => $cliente_dir->estado,
                    'pais' => $cliente_dir->pais,
                    'codigoPostal' => $cliente_dir->codigo_postal,
                ],
            ],
            'Conceptos' => [],
            'Impuestos' => [
                'Traslados' => [
                    'Translado' => [
                        'impuesto' => '0',
                        'tasa' => '0',
                        'importe' => '0'
                    ],
                    'Translado' => [
                        'importe' => '0.00',
                        'tasa' => '0.00',
                        'impuesto' => 'IEPS'
                    ],
                ],
                'Retenciones' => [
                    'Retencion' => [
                        'importe' => '0.00',
                        'tasa' => '16.00',
                        'impuesto' => 'IVA'
                    ],

                ]
            ]
        );

        // agregar el concepto de productos
        foreach ( $cliente_compra['detalle'] as $detalle ) {

            $producto = Product::findOrFail($detalle->producto_id);
            //print_r($producto);dd();
            $temp = array(
                'cantidad' => $detalle->cantidad,
                'unidad' => $producto->tipo_presentacion,
                'descripcion' => $producto->nombre,
                'valorUnitario' => $detalle->precio,
                'importe' => ($detalle->cantidad * $detalle->precio),
            );
            array_push($datosCfdi['Conceptos'], $temp);
        }
        // agregar el costo de envio
        $temp = array(
            'cantidad' => 1,
            'unidad' => 'unidad',
            'descripcion' => 'Costo de envío',
            'valorUnitario' => $cliente_compra->costo_envio,
            'importe' => $cliente_compra->costo_envio,
        );
        array_push($datosCfdi['Conceptos'], $temp);

        // impuestos
        $datosCfdi['Impuestos']['Traslados']['Traslado']['importe'] = number_format($cliente_compra->iva, 2, '.', '');
        $datosCfdi['Impuestos']['Traslados']['Traslado']['tasa'] = number_format(16,2);
        $datosCfdi['Impuestos']['Traslados']['Traslado']['impuesto'] = 'IVA';

        return $datosCfdi;
    }

    /**
     * @param $respuestaTimbrado
     * @param $venta
     * @param $cfdi_obj
     * @param $data_cfdi
     * @return array
     */
    private function setXmlToPDF($respuestaTimbrado, $venta, $cfdi_obj, $data_cfdi){

        //file name
        $xml_name = 'factura_xml_'.date('Ymd').'_'.$venta->id.'.xml';
        $pdf_name = 'factura_xml_'.date('Ymd').'_'.$venta->id.'.pdf';

        // Procesar documento xml del cfdi timbrado
        $cfdiTimbrado = new \DOMDocument("1.0","UTF-8");
        $cfdiTimbrado->loadXML($respuestaTimbrado->stampResult->xml);
        $selloSAT = $respuestaTimbrado->stampResult->SatSeal;
        $folio_fiscal = $respuestaTimbrado->stampResult->UUID;

        // Almacenar documento xml del cfdi (ya timbrado)
        $cfdiTimbrado->save(storage_path('invoices/'. $xml_name ));

        // Traducir el total de la factura a letras
        $totalLetras = TraductorNumeroLetras::traducir($data_cfdi['total'],'MXN');

        // obtener el iva
        $iva = Lookup::where('type', '=', 'impuestos')->where('key', '=', 'iva')->first();

        // datos del cfdi
        $params_cfdi = array(
            'sello' => $this->htmlString($cfdi_obj->obtenerSello(), 100),
            'sello_sat' => $this->htmlString($selloSAT, 100),
            'folio_fiscal' => $folio_fiscal,
            'cadena_original' => $cfdi_obj->obtenerCadenaOriginal(),
            'certificado_sat' => $respuestaTimbrado->stampResult->NoCertificadoSAT,
            'fecha_timbrado' => $respuestaTimbrado->stampResult->Fecha,
            'total_letra' => $totalLetras,
            'iva' => ($iva->costo*100),
        );

        // view for the PDF
        $view = view('factura/cfdi_pdf', compact('data_cfdi', 'params_cfdi', 'venta'));
        $path_file = storage_path('invoices/'. $pdf_name );
        \PDF::loadHTML($view)->save($path_file);

        // datos para el registro de la factura
        $return_res = array(
            'folio_fiscal' => $folio_fiscal,
            'xml' => $xml_name,
            'pdf' => $pdf_name,
        );

        return $return_res;
    }

    /**
     * @param $salida_id
     * @return mixed
     */
    private function getPedido($salida_id){

        $venta = Sale::with('sale_details')->whereId($salida_id)->first();
        if ( count($venta) == 0 ) abort(503, "NO existe la venta solicitada");

        // termina si no ha solicitado factura
        if ( !$venta->factura) abort(503, 'No ha requerido facturacion');

        // Validar que la fecha del ticket este dentro del periodo actual
		if (strtotime($venta->fecha_pedido) <= strtotime('last day of last month')) {
			abort(503, 'Error: La fecha del pedido esta fuera del periodo de facturación actual ');
		}

		// Validar que el ticket no ha sido facturado
		if ( empty($venta->factura_id) == false ) {
            abort(503, 'Error: La factura ya ha sido procesada' );
		}

        return $venta;
    }

    /**
     * @param $vendedor_id
     * @return \Illuminate\Http\Response
     */
    private function getCliente($vendedor_id, $seller_obj){

        $cliente = $seller_obj->show($vendedor_id, 'factura');

        // termina su no cuenta con direccion de facturacion
        $cliente_dir_factura = $cliente->addresses;
        if ( count($cliente_dir_factura) == 0 ){
            abort(503, 'Error: El cliente no cuenta con direccion de facturacion');
        }

        return $cliente;
    }

    /**
     * @param $factura_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFacturaPdf($factura_id){
        $factura = Invoice::find($factura_id);

        $pathFile = storage_path('invoices/'. $factura->pdf );

        return response()->download($pathFile);
    }

    /**
     * @param $string
     * @return string
     */
    public function htmlString($string, $longtud){
        //echo $string."\n\n";
        $no_rows = strlen($string) / $longtud;
        $no_rows = ceil($no_rows);
        $subtr = "";
        $old = "";
        $contador = 0;
        $string_lines = '';

        for( $i=0; $i<$no_rows; $i++){
            if($i==0){
                $subtr = $this->getStringComplete($string,$longtud);

                $string_lines .= $subtr;
                $contador = $longtud;
            }else {
                $old .= $subtr;
                $nueva = str_replace($old, "", $string);
                $subtr = $this->getStringComplete($nueva,$longtud);

                $string_lines .= "\n".$subtr;
                $contador += $longtud;
            }
        }
        $string_lines .= '';
        return $string_lines;
    }

    /**
     * @param $texto
     * @return string
     */
    public function getStringComplete($texto, $longitud){

        $texto_size=$longitud;
        if (strlen($texto)>$longitud){
            $texto = substr($texto, 0,$texto_size);
        }
        return  $texto;
    }
}
