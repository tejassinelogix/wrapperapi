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

/* JWT Token Verification for ShipsGo Send Request and Receive Response */
Route::group(['middleware' => ['jwt.verify']], function () {
    // ShipsGo Get Requests
    Route::post('shipsgo/shippinglinelist', 'Api\ShipsGo\ShipsGoWrapperApiController@get_shippingline_list');
    Route::post('shipsgo/containerinfo', 'Api\ShipsGo\ShipsGoWrapperApiController@get_container_info');
    Route::post('shipsgo/containerinfomap', 'Api\ShipsGo\ShipsGoWrapperApiController@get_containermap_info');

    // ShipsGo Post Requests Container Info
    Route::post('shipsgo/postcontainerinfo', 'Api\ShipsGo\ShipsGoWrapperApiController@post_container_info');
    Route::post('shipsgo/postcustomcontainerinfo', 'Api\ShipsGo\ShipsGoWrapperApiController@post_customcontainer_info');

    // ShipsGo Post Requests Container Info with BI
    Route::post('shipsgo/postcontainerinfobl', 'Api\ShipsGo\ShipsGoWrapperApiController@post_containerinfo_bl');
    Route::post('shipsgo/postcustomcontainerinfobl', 'Api\ShipsGo\ShipsGoWrapperApiController@post_customcontainerinfo_bl');
});

/* JWT Token Verification for Transferwise Send Request and Receive Response */
Route::group(['middleware' => ['jwt.verify']], function () {
    // TransferWise Quote Requests
    Route::post('transferwise/profiles', 'Api\Transferwise\TransferwiseWrapperApiController@get_profile_info');
    Route::post('transferwise/createquotes', 'Api\Transferwise\TransferwiseWrapperApiController@create_quotes');
    Route::post('transferwise/getquotes', 'Api\Transferwise\TransferwiseWrapperApiController@get_quoteby_id');
    Route::post('transferwise/getquotespayinmethod', 'Api\Transferwise\TransferwiseWrapperApiController@get_quote_payinmethod');
    Route::post('transferwise/gettempquotes', 'Api\Transferwise\TransferwiseWrapperApiController@get_temporary_quote');
    // TransferWise Quote Requests Ends

    // TransferWise Create Recipient Accounts
    Route::post('transferwise/createrecipientaccount', 'Api\Transferwise\TransferwiseWrapperApiController@create_recipient_accounts');
    Route::post('transferwise/createrecipientemail', 'Api\Transferwise\TransferwiseWrapperApiController@create_recipient_email');
    // TransferWise Create Recipient Accounts Ends
});
