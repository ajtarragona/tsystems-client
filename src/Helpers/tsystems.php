<?php

if (! function_exists('ts_tercers')) {
	function ts_tercers($options=false){
		return new \Ajtarragona\TSystems\TSystemsTercersService($options);
	}
}
if (! function_exists('ts_vialer')) {
	function ts_vialer($options=false){
		return new \Ajtarragona\TSystems\TSystemsVialerService($options);
	}
}
if (! function_exists('ts_padro')) {
	function ts_padro($options=false){
		return new \Ajtarragona\TSystems\TSystemsPadroService($options);
	}
}