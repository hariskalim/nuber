<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::POST('create-booking', 'BookingController@create_booking');
Route::POST('cancel-booking', 'BookingController@cancel_booking');
Route::get('list-booking', 'BookingController@list_booking');
Route::POST('accept-booking', 'BookingController@accept_booking');
