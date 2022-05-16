<?php

return [
	
	'debug' => env('TSYSTEMS_DEBUG',false),
	"ws_url" => env('TSYSTEMS_WS_URL', ""), 
	"ws_user"=> env('TSYSTEMSAPI_WS_USER', ""),
	"ws_password"=> env('TSYSTEMS_WS_PASSWORD', ""),
	"oidparins"=> env('TSYSTEMS_ID_INSTITUCION', ""),
	"country_spain"=> 108,
	"provincia_tarragona" => 43,
	"municipio_tarragona" => 148,
	"backend" => env('TSYSTEMS_BACKEND',true),
];

