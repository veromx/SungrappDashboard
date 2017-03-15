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

});


// TODO change to the middleware
Route::resource('suppliers','SupplierController');

// sales
Route::resource('sales', 'SalesController');

// packages
Route::resource('packages', 'PackagesController');

// messages
Route::resource('messages', 'MessageController',['only'=>['index','store']]);
