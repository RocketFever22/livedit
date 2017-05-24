<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::post('/livedit/publish', 'Ricks\livedit\LiveditController@push');
	Route::get('/livedit/ask/{resource_type}', 'Ricks\livedit\LiveditController@ask');
});