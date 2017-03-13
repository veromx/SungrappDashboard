<?php namespace App\Http\Controllers\Cfdi;


/**
 * Cfdi
 *
 * @author Daniel Barro <daniel.barro@digital14.mx>
 * Based on the code from Fernando Ortiz <fortiz@lacorona.com.mx> at http://www.lacorona.com.mx/fortiz/sat/xml.php
 */


use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class Cfdi2XmlController
{

    const XMLNS_CFDI = 'http://www.sat.gob.mx/cfd/3';
    const XMLNS_XSI = 'http://www.w3.org/2001/XMLSchema-instance';
    const XMLNS_TFD = 'http://www.sat.gob.mx/TimbreFiscalDigital';
    const XSI_SCHEMALOCATION = 'http://www.sat.gob.mx/cfd/3  http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd';
    const CFDI_VERSION = '3.2';

    /**
     * @var Array $datosCfdi Los datos del Cfdi
     */
    protected $datosCfdi;

    /**
     * @var \DOMDocument $xml El documento xml del Cfdi
     */
    protected $xml;

    /**
     * @var \DOMNode $xmlRoot La raiz del documento xml del Cfdi
     */
    protected $xmlRoot;

    /**
     * @var String $cadenaOriginal La cadena original del Cfdi
     */
    protected $cadenaOriginal;

    /**
     * @var String $sello El sello del Cfdi
     */
    protected $sello;


    /**
     * Constructor de la clase
     *
     * @param Array $datosCfdi Un arreglo asociativo con todos los datos del Cfdi
     */
    public function __construct($datosCfdi) {
        $this->xml = new \DOMDocument("1.0", "UTF-8");
        $this->xml->formatOutput = true;
        $this->datosCfdi = $datosCfdi;
        $this->establecerDatosGenerales($datosCfdi);
        $this->establecerEmisor($datosCfdi['Emisor']);
        $this->establecerReceptor($datosCfdi['Receptor']);
        $this->establecerConceptos($datosCfdi['Conceptos']);
        $this->establecerImpuestos($datosCfdi['Impuestos']);
    }


    /**
     * Funcion para agregar un atributo a un nodo del documento Xml del Cfdi
     *
     * @param \DOMNode $nodo El nodo del Cfdi
     * @param Array $atributos Los atributos del nodo del Cfdi
     */
    protected function agregarAtributos(&$nodo, $atributos) {
        $quitar = array('sello'=>1,'noCertificado'=>1,'certificado'=>1);
        foreach ($atributos as $key => $val) {
            // DISABLED:
            // for ($i=0; $i < strlen($val); $i++) {
            //	$a = substr($val, $i, 1);
            //	if ($a > chr(127) && $a !== chr(219) && $a !== chr(211) && $a !== chr(209)) {
            //		$val = substr_replace($val, ".", $i, 1);
            //	}
            // }
            $val = preg_replace('/\s\s+/', ' ', $val);   			// Regla 5a y 5c
            $val = trim($val);                           			// Regla 5b
            if (strlen($val) > 0) {   								// Regla 6
                $val = str_replace(array('"','>','<'), "'", $val);  // &...;
                $val = str_replace("|", "/", $val); 	// Regla 1
                $nodo->setAttribute($key,$val);
            }
        }
    }


    /**
     * Funcion para establecer los datos generales del Cfdi
     *
     * @param Array $datosGenerales Los datos generales del Cfdi
     */
    protected function establecerDatosGenerales($datosGenerales, $addenda=null) {
        $this->datosCfdi = array_merge($this->datosCfdi, $datosGenerales);
        $this->xmlRoot = $this->xml->createElement('cfdi:Comprobante');
        $this->xmlRoot = $this->xml->appendChild($this->xmlRoot);

        // TODO: switch ($addenda) {}
        // Segun la addenda es como se deben de escribir los datos de xmlns y schemaLocation
        // Implementar cuando se necesite
        $this->agregarAtributos($this->xmlRoot, array(
            'xmlns:cfdi' => static::XMLNS_CFDI,
            'xmlns:xsi' => static::XMLNS_XSI,
            'xsi:schemaLocation' => static::XSI_SCHEMALOCATION,
            'version' => static::CFDI_VERSION
        ));

        $this->agregarAtributos($this->xmlRoot, array(
            'serie' => $datosGenerales['serie'],
            'folio' => $datosGenerales['folio'],
            'fecha' => $datosGenerales['fecha'],
            'formaDePago' => $datosGenerales['formaDePago'],
            'noCertificado' => $datosGenerales['noCertificado'],
            'certificado' => '@',
            //'cadenaOriginal' => '@',
            'sello' => '@',
            'subTotal' => $datosGenerales['subTotal'],
            'descuento' => $datosGenerales['descuento'],
            'total' => $datosGenerales['total'],
            'tipoDeComprobante' => $datosGenerales['tipoDeComprobante'],
            'metodoDePago' => $datosGenerales['metodoDePago'],
            'LugarExpedicion' => $datosGenerales['LugarExpedicion']
        ));
    }


    /**
     * Funcion para establecer los datos del emisor del Cfdi
     *
     * @param Array $datosEmisor Los datos del emisor del Cfdi
     */
    protected function establecerEmisor($datosEmisor) {
        $this->datosCfdi['Emisor'] = $datosEmisor;
        $emisor = $this->xml->createElement('cfdi:Emisor');
        $emisor = $this->xmlRoot->appendChild($emisor);
        $this->agregarAtributos($emisor, array(
            'rfc' => $datosEmisor['rfc'],
            'nombre' => $datosEmisor['nombre']
        ));
        $domFiscal = $this->xml->createElement("cfdi:DomicilioFiscal");
        $domFiscal = $emisor->appendChild($domFiscal);
        $this->agregarAtributos($domFiscal, array(
            'calle' => $datosEmisor['DomicilioFiscal']['calle'],
            'noExterior' => $datosEmisor['DomicilioFiscal']['noExterior'],
            'colonia' => $datosEmisor['DomicilioFiscal']['colonia'],
            'municipio' => $datosEmisor['DomicilioFiscal']['municipio'],
            'estado' => $datosEmisor['DomicilioFiscal']['estado'],
            'pais' => $datosEmisor['DomicilioFiscal']['pais'],
            'codigoPostal' => $datosEmisor['DomicilioFiscal']['codigoPostal']
        ));
        if (isset($datosEmisor['DomicilioFiscal']['noInterior'])) {
            $this->agregarAtributos($domFiscal, array(
                'noInterior' => $datosEmisor['DomicilioFiscal']['noInterior']
            ));
        }
        $regimen = $this->xml->createElement('cfdi:RegimenFiscal');
        $regimen = $emisor->appendChild($regimen);
        $this->agregarAtributos($regimen, array(
            'Regimen' => $datosEmisor['Regimen']
        ));
    }


    /**
     * Funcion para establecer los datos del receptor del Cfdi
     *
     * @param Array $datosReceptor Los datos del receptor del Cfdi
     */
    protected function establecerReceptor($datosReceptor) {
        $this->datosCfdi['Receptor'] = $datosReceptor;
        $receptor = $this->xml->createElement('cfdi:Receptor');
        $receptor = $this->xmlRoot->appendChild($receptor);
        $this->agregarAtributos($receptor, array(
            'rfc' => $datosReceptor['rfc'],
            'nombre' => $datosReceptor['nombre']
        ));
        $domicilio = $this->xml->createElement("cfdi:Domicilio");
        $domicilio = $receptor->appendChild($domicilio);
        $this->agregarAtributos($domicilio, array(
            'calle' => $datosReceptor['Domicilio']['calle'],
            'noExterior' => $datosReceptor['Domicilio']['noExterior'],
            'colonia' => $datosReceptor['Domicilio']['colonia'],
            'municipio' => $datosReceptor['Domicilio']['municipio'],
            'estado' => $datosReceptor['Domicilio']['estado'],
            'pais' => $datosReceptor['Domicilio']['pais'],
            'codigoPostal' => $datosReceptor['Domicilio']['codigoPostal']
        ));
        if (isset($datosReceptor['Domicilio']['noInterior'])) {
            $this->agregarAtributos($domicilio, array(
                'noInterior' => $datosReceptor['Domicilio']['noInterior']
            ));
        }
    }


    /**
     * Funcion para establecer los conceptos del Cfdi
     *
     * @param Array $datosConceptos Los conceptos del Cfdi
     */
    protected function establecerConceptos($datosConceptos) {
        $this->datosCfdi['Conceptos'] = $datosConceptos;
        $conceptos = $this->xml->createElement('cfdi:Conceptos');
        $conceptos = $this->xmlRoot->appendChild($conceptos);
        for ($i=0; $i < sizeof($datosConceptos); $i++) {
            $concepto = $this->xml->createElement('cfdi:Concepto');
            $concepto = $conceptos->appendChild($concepto);
            $this->agregarAtributos($concepto, array(
                'cantidad' => $datosConceptos[$i]['cantidad'],
                'unidad' => $datosConceptos[$i]['unidad'],
                'descripcion' => $datosConceptos[$i]['descripcion'],
                'valorUnitario' => $datosConceptos[$i]['valorUnitario'],
                'importe' => $datosConceptos[$i]['importe'],
            ));
        }
    }


    /**
     * Funcion para establecer los impuestos del Cfdi
     *
     * @param Array $traslados Los impuestos trasladados del Cfdi
     * @param Array $retenciones Los impuestos retenidos del Cfdi
     */
    protected function establecerImpuestos($datosImpuestos) {
        $this->datosCfdi['Impuestos'] = $datosImpuestos;
        $datosTraslados = isset($datosImpuestos['Traslados']) ? $datosImpuestos['Traslados'] : null;
        $datosRetenciones = isset($datosImpuestos['Retenciones']) ? $datosImpuestos['Retenciones'] : null;

        $impuestos = $this->xml->createElement('cfdi:Impuestos');
        $impuestos = $this->xmlRoot->appendChild($impuestos);

        $totalImpuestosRetenidos = 0;
        if (!empty($datosRetenciones)) {
            $retenciones = $this->xml->createElement('cfdi:Retenciones');
            $retenciones = $impuestos->appendChild($retenciones);
            foreach ($datosRetenciones as $r) {
                if (isset($r['importe'])) {
                    $retencion = $this->xml->createElement('cfdi:Retencion');
                    $retencion = $retenciones->appendChild($retencion);
                    $this->agregarAtributos($retencion, array(
                        'impuesto' => $r['impuesto'],
                        //'tasa' => $r['tasa'],
                        'importe' => $r['importe']
                    ));
                    $totalImpuestosRetenidos+= $r['importe'];
                }
            }
            $impuestos->SetAttribute('totalImpuestosRetenidos',$totalImpuestosRetenidos);
        }

        $totalImpuestosTrasladados = 0;
        if (!empty($datosTraslados)) {
            $traslados = $this->xml->createElement('cfdi:Traslados');
            $traslados = $impuestos->appendChild($traslados);
            foreach ($datosTraslados as $t) {
                if (isset($t['importe'])) {
                    $traslado = $this->xml->createElement('cfdi:Traslado');
                    $traslado = $traslados->appendChild($traslado);
                    $this->agregarAtributos($traslado, array(
                        'impuesto' => $t['impuesto'],
                        'tasa' => $t['tasa'],
                        'importe' => $t['importe']
                    ));
                    $totalImpuestosTrasladados+= $t['importe'];
                }
            }
            $impuestos->SetAttribute('totalImpuestosTrasladados',$totalImpuestosTrasladados);
        }


    }


    /**
     * Funcion para validar el documento XML del Cfdi
     *
     * @param String $xsdFile El archivo Xsd contra el cual se validara el documento Xml del Cfdi
     * @return Boolean Si el documento Xml del Cfdi es valido o no
     */
    public function validar($xsdFile) {
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $cadenaXml = $this->obtenerXml();
        $validador = new \DOMDocument("1.0","UTF-8");
        $validador->loadXML($cadenaXml);
        return $validador->schemaValidate($xsdFile);
    }


    /**
     * Funcion para obtener los errores al validar el documento XML del Cfdi
     *
     * @return Array Los errores de validacion del document Xml del Cfdi si los hubiera
     */
    public function obtenerErroresValidacion() {
        $errores = libxml_get_errors();
        libxml_clear_errors();
        return $errores;
    }


    /**
     * Funcion para generar la Cadena Original del Cfdi
     *
     * @param String $xsltCadenaOriginal La ruta al archivo Xslt para generar la Cadena Original del Cfdi
     * @return string
     */
    protected function calcularCadenaOriginal($xsltCadenaOriginal) {
        $xmlCfdi = new \DOMDocument("1.0","UTF-8");
        $xmlCfdi->loadXML($this->obtenerTextoXml());
        $xsl = new \DOMDocument("1.0","UTF-8");
        $xsl->load($xsltCadenaOriginal);
        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl);
        $cadenaOriginal = $proc->transformToXML($xmlCfdi);
        return $cadenaOriginal;
    }


    /**
     * Funcion para generar el Sello del Cfdi
     *
     * @param String $xsltCadenaOriginal La ruta al archivo Xslt para generar la Cadena Original del Cfdi
     */
    public function sellar($xsltCadenaOriginal, $keyFile, $certFile) {
        if (empty($this->datosCfdi)) {
            return;
        }

        $this->cadenaOriginal = $this->calcularCadenaOriginal($xsltCadenaOriginal);
        // $this->xmlRoot->setAttribute('cadenaOriginal', $this->cadenaOriginal);

        $noCertificado = $this->datosCfdi['noCertificado'];
        $privKey = openssl_get_privatekey(file_get_contents($keyFile));
        openssl_sign($this->cadenaOriginal, $firma, $privKey, OPENSSL_ALGO_SHA1);
        openssl_free_key($privKey);
        $this->sello = base64_encode($firma);      // lo codifica en formato base64
        $this->xmlRoot->setAttribute('sello', $this->sello);

        $certificado = null;
        $carga=false;
        $datosCert = file($certFile);
        for ($i=0; $i<sizeof($datosCert); $i++) {
            if (strstr($datosCert[$i],"END CERTIFICATE")) $carga=false;
            if ($carga) $certificado .= trim($datosCert[$i]);
            if (strstr($datosCert[$i],"BEGIN CERTIFICATE")) $carga=true;
        }
        $this->xmlRoot->setAttribute('certificado', $certificado);
    }


    /**
     * Funcion para obtener la cadena original del Cfdi
     */
    public function obtenerCadenaOriginal() {
        return $this->cadenaOriginal;
    }


    /**
     * Funcion para obtener el sello del Cfdi
     */
    public function obtenerSello() {
        return $this->sello;
    }


    /**
     * Funcion para obtener el documento XML del Cfdi
     */
    public function obtenerXml() {
        return $this->xml;
    }


    /**
     * Funcion para obtener el texto XML del Cfdi
     */
    public function obtenerTextoXml() {
        return $this->xml->saveXML();
    }


    /**
     * Funcion para guardar el texto XML del Cfdi
     *
     * @param String $filePath La ruta a donde es escribira el archivo XML
     * @param $filePath
     * @return int
     */
    public function guardarXml($filePath) {
        return $this->xml->save($filePath);
    }



    /****************************/

    public function test_timbrado(){
        // Username and Password, assigned by FINKOK
        $credentials = Config::get('acl.InvoiceCredentials');

        // leer el archvio xml
        $invoice_path = storage_path('invoices/factura_xml_'.date('Ymd').'.xml');

        // get the xslt file
        $file_xslt = storage_path('sat/cadenaoriginal_3_2.xslt');
        $this->cadenaOriginal =  $this->calcularCadenaOriginal($file_xslt);

        // poner sello
        $noCertificado = $this->datosCfdi['noCertificado'];
        $privKey = openssl_get_privatekey(file_get_contents(storage_path('invoices/testing/aad990814bp7.key.pem')));
        openssl_sign($this->cadenaOriginal, $firma, $privKey, OPENSSL_ALGO_SHA1);
        openssl_free_key($privKey);
        $sello = base64_encode($firma);      // lo codifica en formato base64
        $this->xmlRoot->setAttribute('sello', $sello);

        //poner certificado
        $certificado = null;
        $carga=false;
        $datosCert = file(storage_path('invoices/testing/aad990814bp7.cer.pem'));
        for ($i=0; $i<sizeof($datosCert); $i++) {
            if (strstr($datosCert[$i],"END CERTIFICATE")) $carga=false;
            if ($carga) $certificado .= trim($datosCert[$i]);
            if (strstr($datosCert[$i],"BEGIN CERTIFICATE")) $carga=true;
        }
        $this->xmlRoot->setAttribute('certificado', $certificado);

        // save the cfdi object as xml file con sello y certificado
        $this->guardarXml($invoice_path);


        // obtener el xml como string
        $xml_content = '';
        foreach(file($invoice_path) as $line) {
            $xml_content .= $line;
        }

        /*
        // envelop
        $params = array(
            "xml" => $xml_content,  //$xml_content_b64,  //
            "username" => $credentials['user'],
            "password" => $credentials['password']
        );
        $client = new \SoapClient("http://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl", array('trace' => 1));
        $result = $client->__soapCall("stamp", array($params));
        echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
        print_r($result);
        dd();
           */

        // set datos del proveedor de timbrado
        $username = $credentials['user'];
        $password = $credentials['password'];
        $url = "http://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl";
        $client = new \SoapClient($url);

        //timbrado
        $params = array(
            "xml" => $xml_content,  //$xml_content_b64,
            "username" => $username,
            "password" => $password
        );
        $response = $client->__soapCall("stamp", array($params));
        return $response;

    }
}
