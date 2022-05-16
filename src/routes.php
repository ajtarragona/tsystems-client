<?php


Route::group(['prefix' => 'ajtarragona/tsystems','middleware' => ['tsystems-backend','web','auth','language']	], function () {
	Route::get('/', 'Ajtarragona\Tsystems\Controllers\TsystemsController@home')->name('tsystems.home');
	
	Route::get('/tercers', 'Ajtarragona\Tsystems\Controllers\TsystemsTercersController@home')->name('tsystems.tercers.home');
	Route::post('/tercers', 'Ajtarragona\Tsystems\Controllers\TsystemsTercersController@search')->name('tsystems.tercers.search');
	Route::get('/tercers/{dboid}', 'Ajtarragona\Tsystems\Controllers\TsystemsTercersController@show')->name('tsystems.tercers.show');
	

	
	Route::get('/padro', 'Ajtarragona\Tsystems\Controllers\TsystemsPadroController@home')->name('tsystems.padro.home');
	Route::post('/padro', 'Ajtarragona\Tsystems\Controllers\TsystemsPadroController@search')->name('tsystems.padro.search');
	Route::get('/padro/{dni}', 'Ajtarragona\Tsystems\Controllers\TsystemsPadroController@show')->name('tsystems.padro.show');
	
	Route::get('/vialer', 'Ajtarragona\Tsystems\Controllers\TsystemsVialerController@home')->name('tsystems.vialer.home');
	Route::post('/vialer', 'Ajtarragona\Tsystems\Controllers\TsystemsVialerController@search')->name('tsystems.vialer.search');
	Route::get('/vialer/combo', 'Ajtarragona\Tsystems\Controllers\TsystemsVialerController@combo')->name('tsystems.vialer.combo');
	

	Route::get('/expedients', 'Ajtarragona\Tsystems\Controllers\TsystemsExpedientsController@home')->name('tsystems.expedients.home');
	Route::post('/expedients', 'Ajtarragona\Tsystems\Controllers\TsystemsExpedientsController@search')->name('tsystems.expedients.search');
	Route::get('/expedients/{id}', 'Ajtarragona\Tsystems\Controllers\TsystemsExpedientsController@show')->name('tsystems.expedients.show');
	
	Route::get('/registre', 'Ajtarragona\Tsystems\Controllers\TsystemsRegistreController@home')->name('tsystems.registre.home');
});

