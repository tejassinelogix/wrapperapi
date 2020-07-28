<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Comment This Code After JWT Auth Integrated */
/* Route::middleware('auth:api')->get('/user', function (Request $request) {
     return $request->user();
});*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Api\ApiAuthController@login');
    Route::post('logout', 'Api\ApiAuthController@logout');
    Route::post('refresh', 'Api\ApiAuthController@refresh');
    Route::post('me', 'Api\ApiAuthController@me');
});

/* JWT Token Verification for Send Request and Receive Response */
Route::group(['middleware' => ['jwt.verify']], function () {
    // ShipsGo Get Requests
    Route::post('shipsgo/shippinglinelist', 'Api\WrapperApiController@get_shippingline_list');
    Route::post('shipsgo/containerinfo', 'Api\WrapperApiController@get_container_info');

    // ShipsGo Post Requests Container Info
    Route::post('shipsgo/postcontainerinfo', 'Api\WrapperApiController@post_container_info');
    Route::post('shipsgo/postcustomcontainerinfo', 'Api\WrapperApiController@post_customcontainer_info');

    // ShipsGo Post Requests Container Info with BI
    Route::post('shipsgo/postcontainerinfobi', 'Api\WrapperApiController@post_containerinfo_bi');
    Route::post('shipsgo/postcustomcontainerinfobi', 'Api\WrapperApiController@post_customcontainerinfo_bi');
});
