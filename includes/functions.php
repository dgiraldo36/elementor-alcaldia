<?php
function ea_pluging_procesar_fecha( $fecha = false ) {
	if ( ! $fecha ) {
		return false;
	}

	$fecha = strtolower( str_replace('.', '', $fecha) );
	$fecha = str_replace('a m', 'am', $fecha );
	$fecha = str_replace('p m', 'pm', $fecha );

	$meses = array(
		'enero' => 'January',
		'febrero' => 'February',
		'marzo' => 'March',
		'abril' => 'April',
		'mayo' => 'May',
		'junio' => 'June',
		'julio' => 'July',
		'agosto' => 'August',
		'septiembre' => 'September',
		'octubre' => 'October',
		'noviembre' => 'November',
		'diciembre' => 'December'
	);

	foreach ( $meses as $mes_esp => $mes_ing ) {
		if ( strpos( $fecha, $mes_esp ) !== false ) {
			return str_replace($mes_esp, $mes_ing, $fecha);
		}
	}

	return $fecha;
}