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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'user'

], function ($router) {
    Route::get('/get_ps', 'App\Http\Controllers\UserController@GetPs');
    Route::post('/create_directory', 'App\Http\Controllers\UserController@CreateDirectory');
    Route::post('/create_file', 'App\Http\Controllers\UserController@CreateFile');
    Route::get('/list_directory', 'App\Http\Controllers\UserController@ListDirectory');
    Route::get('/list_file', 'App\Http\Controllers\UserController@ListFile');
});
