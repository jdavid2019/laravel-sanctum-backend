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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/login', \App\Http\Controllers\Auth\LoginController::class);

Route::group(['middleware' => [],'prefix' => 'v1'], function () {
    Route::post('/login', 'App\Http\Controllers\Auth\UserController@login');
    Route::post('/register', 'App\Http\Controllers\Auth\UserController@register');
    Route::post('/logout', 'App\Http\Controllers\Auth\UserController@logout');
});


Route::group(['middleware' => ['auth:sanctum'],'prefix' => 'v1'], function () {
   // Route::post('/login', \App\Http\Controllers\Auth\LoginController::class);
});


