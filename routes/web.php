<?php

Route::get('/', function () {
	return view('welcome'); // "Sungrapp Dashboard API v1 ";
});

Route::auth();
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware'=>'auth'], function(){

	Route::get('admin', function(){
		return view('admin');
	})->name('admin');

	Route::resource('users','UserController');
	Route::resource('suppliers','SupplierController');

});


// TODO change to the middleware

// sales 
Route::resource('sales', 'SalesController'); 

// messages
Route::resource('messages', 'MessageController',['only'=>['store']]);
