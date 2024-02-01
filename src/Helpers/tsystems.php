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
