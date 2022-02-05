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
Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login');

Route::get('article', 'API\GeneralController@index');
Route::get('article/{id}', 'API\GeneralController@show');


Route::post('uploadImage', 'API\GeneralController@imageUploadPost');


   
Route::middleware('auth:api')->group( function () {
    Route::resource('user/article', 'API\ArticleController');
});

