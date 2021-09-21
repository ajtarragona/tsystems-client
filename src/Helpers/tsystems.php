<?php

if (! function_exists('ts_tercers')) {
	function ts_tercers($options=false){
		return new \Ajtarragona\Tsystems\TsystemsTercersService($options);
	}
}
if (! function_exists('ts_vialer')) {
	function ts_vialer($options=false){
		return new \Ajtarragona\Tsystems\TsystemsVialerService($options);
	}
}
if (! function_exists('ts_padro')) {
	function ts_padro($options=false){
		return new \Ajtarragona\Tsystems\TsystemsPadroService($options);
	}
}