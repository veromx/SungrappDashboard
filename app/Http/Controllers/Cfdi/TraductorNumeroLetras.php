<?php
/**
 * Clase que implementa un coversor de números 
 * a letras. 
 * 
 * Soporte para PHP >= 5.4
 * Para soportar PHP 5.3, declare los arreglos
 * con la función array. 
 * 
 * @author AxiaCore S.A.S
 * @author Daniel B. Lopez
 *
 */

namespace App\Http\Controllers\Cfdi;

class TraductorNumeroLetras 
{
	private static $UNIDADES = [
		'',
		'UN ',
		'DOS ',
		'TRES ',
		'CUATRO ',
		'CINCO ',
		'SEIS ',
		'SIETE ',
		'OCHO ',
		'NUEVE ',
		'DIEZ ',
		'ONCE ',
		'DOCE ',
		'TRECE ',
		'CATORCE ',
		'QUINCE ',
		'DIECISEIS ',
		'DIECISIETE ',
		'DIECIOCHO ',
		'DIECINUEVE ',
		'VEINTE '
	];

	private static $DECENAS = [
		'VENTI',
		'TREINTA ',
		'CUARENTA ',
		'CINCUENTA ',
		'SESENTA ',
		'SETENTA ',
		'OCHENTA ',
		'NOVENTA ',
		'CIEN '
	];

	private static $CENTENAS = [
		'CIENTO ',
		'DOSCIENTOS ',
		'TRESCIENTOS ',
		'CUATROCIENTOS ',
		'QUINIENTOS ',
		'SEISCIENTOS ',
		'SETECIENTOS ',
		'OCHOCIENTOS ',
		'NOVECIENTOS '
	];

	private static $MONEDAS = [
		['country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$'],
		['country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'DÓLAR', 'plural' => 'DÓLARES', 'symbol', 'US$'],
		['country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS', 'symbol', '€'],
		['country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$'],
		['country' => 'Perú', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES', 'symbol', 'S/'],
		['country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS', 'symbol', '£']
	];
	
	private static $SUFIJOS_DECIMALES = [
		'MXN' => '/100 M.N.'
	];


	public static function traducir($number, $miMoneda = null)
	{   
		if (!is_float($number)) {
			$number = floatval($number);
		}
		
		if ($miMoneda !== null) {
			try {
				
				$moneda = array_filter(static::$MONEDAS, function($m) use ($miMoneda) {
					return ($m['currency'] == $miMoneda);
				});

				$moneda = array_values($moneda);

				if (count($moneda) <= 0) {
					throw new Exception("Tipo de moneda inválido");
					return;
				}

				if ($number < 2) {
					$moneda = $moneda[0]['singular'];
				} else {
					$moneda = $moneda[0]['plural'];
				}
			} catch (Exception $e) {
				echo $e->getMessage();
				return;
			}
		} else {
			$moneda = " ";
		}

		$converted = '';
		
		if (($number < 0) || ($number > 999999999)) {
			return 'No es posible convertir el numero a letras';
		}

		$numberStr = (string) $number;
		if (strpos($numberStr, '.') !== false) {
			$numberParts = explode('.', $numberStr);
			$numberStr = $numberParts[0];
			$numberDecimals = $numberParts[1];
		}
		
		$numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
		$millones = substr($numberStrFill, 0, 3);
		$miles = substr($numberStrFill, 3, 3);
		$cientos = substr($numberStrFill, 6);

		if (intval($millones) > 0) {
			if ($millones == '001') {
				$converted .= 'UN MILLON ';
			} else if (intval($millones) > 0) {
				$converted .= sprintf('%sMILLONES ', static::convertGroup($millones));
			}
		}
		
		if (intval($miles) > 0) {
			if ($miles == '001') {
				$converted .= 'MIL ';
			} else if (intval($miles) > 0) {
				$converted .= sprintf('%sMIL ', static::convertGroup($miles));
			}
		}

		if (intval($cientos) > 0) {
			if ($cientos == '001') {
				$converted .= 'UN ';
			} else if (intval($cientos) > 0) {
				$converted .= sprintf('%s ', static::convertGroup($cientos));
			}
		}

		$converted .= $moneda;
		$sufijoDecimal = static::$SUFIJOS_DECIMALES[$miMoneda];
		if (!empty($sufijoDecimal)) {
			$decimales = empty($numberDecimals) ? '0' : $numberDecimals;
			$converted .= " {$decimales}{$sufijoDecimal}";
		}

		return $converted;
	}


	private static function convertGroup($n)
	{
		$output = '';

		if ($n == '100') {
			$output = "CIEN ";
		} else if ($n[0] !== '0') {
			$output = static::$CENTENAS[$n[0] - 1];   
		}

		$k = intval(substr($n,1));

		if ($k <= 20) {
			$output .= static::$UNIDADES[$k];
		} else {
			if(($k > 30) && ($n[2] !== '0')) {
				$output .= sprintf('%sY %s', static::$DECENAS[intval($n[1]) - 2], static::$UNIDADES[intval($n[2])]);
			} else {
				$output .= sprintf('%s%s', static::$DECENAS[intval($n[1]) - 2], static::$UNIDADES[intval($n[2])]);
			}
		}
	  
		return $output;
	}
}
