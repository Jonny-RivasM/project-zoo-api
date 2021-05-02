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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', 'App\Http\Controllers\UserController@login');
Route::post('register', 'App\Http\Controllers\UserController@store');
Route::group(['middleware' => 'auth:api'], function(){
    //Route::resource('users',\App\Http\Controllers\UserController::Class);
    Route::get('users','App\Http\Controllers\UserController@index');
    Route::put('details/{id}','App\Http\Controllers\UserController@update');
    Route::get('details/{id}','App\Http\Controllers\UserController@show');
});
