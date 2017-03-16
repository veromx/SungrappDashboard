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
	Route::resource('packages', 'PackagesController');

	Route::resource('messages', 'MessageController', ['except'=>['create','store']]);

});


// TODO change to the middleware

// sales
Route::resource('sales', 'SalesController');

// packages
Route::resource('packages', 'PackagesController');

// messages
Route::get('contact', 'MessageController@create');
Route::resource('messages', 'MessageController', ['only'=>['store']]);
