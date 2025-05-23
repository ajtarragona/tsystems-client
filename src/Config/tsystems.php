<?php

return [
	
	'debug' => env('TSYSTEMS_DEBUG',false),
	"ws_url" => env('TSYSTEMS_WS_URL', ""), 
	"ws_user"=> env('TSYSTEMSAPI_WS_USER', ""),
	"ws_password"=> env('TSYSTEMS_WS_PASSWORD', ""),
	"oidparins"=> env('TSYSTEMS_ID_INSTITUCION', ""),
	"default_pais_dboid"=> env('TSYSTEMS_DEFAULT_PAIS_DBOID', "102000000000002600001"),
	"default_provincia_dboid"=> env('TSYSTEMS_DEFAULT_PROVINCIA_DBOID', "101901200000040900069"),
	"default_municipi_dboid"=> env('TSYSTEMS_DEFAULT_MUNICIPI_DBOID', "101700200000651500001"),
	"country_spain"=> 108,
	"provincia_tarragona" => 43,
	"municipio_tarragona" => 148,
	"excluded_municipios" => [999],
	"backend" => env('TSYSTEMS_BACKEND',true),
	'book_in_id' => env('TSYSTEMS_BOOK_IN',  '980000000000383388888'),
	'book_out_id' => env('TSYSTEMS_BOOK_OUT','980000000000383588888'),
	'STATECODE'=>env('TSYSTEMS_STATECODE',  'ANOT'),
	'REGOFF'=>env('TSYSTEMS_REGOFF',  '9'),
	'SOURCECODE'=>env('TSYSTEMS_SOURCECODE',  '7'),
	'JUSTIFCODE' =>env('TSYSTEMS_JUSTIFCODE',  'RegistroAJT'),
	'codigo_justif_out' =>env('CODIGO_JUSTIF_OUT',  'Tipo_dat_Just')
];

