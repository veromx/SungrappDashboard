<?php

Route::get('/', function () {
	return view('home'); // "Sungrapp Dashboard API v1 ";
});

Route::auth();
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware'=>'auth'], function(){

	Route::resource('users','UserController');
	Route::resource('suppliers','SupplierController');

});
