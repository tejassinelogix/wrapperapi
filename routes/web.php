<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/* Wrapper API Load Form View */
Route::get('/getshippinglinelist', 'HomeController@getshippinglinelist');
Route::get('/getcontainerlist', 'HomeController@getcontainerlist');
Route::get('/containerinfomap', 'HomeController@getcontainermaplist');

// Post Wrapper Tickets
Route::get('/postcontainerlist', 'HomeController@postcontainerlist');
Route::get('/postcustomcontainerlist', 'HomeController@postcustomcontainerlist');
// BI 
Route::get('/postcontainerbllist', 'HomeController@postcontainerbllist');
Route::get('/postcustomcontainerbllist', 'HomeController@postcustomcontainerbllist');
