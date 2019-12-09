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

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@store');

    Route::group(['middleware' => ['auth']], function () {
    
        Route::ApiResource('users', 'UserController');
        Route::ApiResource('categories', 'CategoryController');
        Route::ApiResource('passwords', 'PasswordController');
        Route::get('show_all_passwords_and_categories', 'CategoryController@show_all_passwords_and_categories');
   
});
