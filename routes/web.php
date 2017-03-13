<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return "Sungrapp Dashboard API v1 ";
});

Route::auth();
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware'=>'auth'], function(){

Route::resource('users','UserController');
Route::resource('suppliers','SupplierController');

});


// Route::get('login', 'Auth\LoginController@login')->name('login');
// Route::get('register', 'Auth\LoginController@register')->name('register');
