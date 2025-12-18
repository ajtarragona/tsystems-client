<?php


if (! function_exists('ts_tercers')) {
	function ts_tercers($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsTercersService($options);
	}
}
if (! function_exists('ts_vialer')) {
	function ts_vialer($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsVialerService($options);
	}
}
if (! function_exists('ts_padro')) {
	function ts_padro($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsPadroService($options);
	}
}

if (! function_exists('ts_expedients')) {
	function ts_expedients($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsExpedientsService($options);
	}
}

if (! function_exists('ts_rdpost')) {
	function ts_rdpost($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsRdpostService($options);
	}
}

if (! function_exists('ts_registre')) {
	function ts_registre($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsRegistreService($options);
	}
}


if (! function_exists('ts_formatdate')) {
	function ts_formatdate($date){
		if (!$date) return null;
		$date = preg_replace('/[^0-9]/', '', $date);
		if (strlen($date) !== 8) return null;
		return substr($date, 6, 2) . '/' . substr($date, 4, 2) . '/' . substr($date, 0, 4);
	}
}
