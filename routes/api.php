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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');


Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('product', 'ProductController@index'); // Tampil product
    Route::post('/product', 'ProductController@store'); // Tambah Data
    Route::get('/product/{id}', 'ProductController@show'); // Tampilkan data dengan id
    Route::patch('/prodcuct/{id}', 'ProductController@update'); // Update data
    Route::delete('/product/{id}', 'ProductController@destroy'); // Hapus data 
    Route::get('profile', 'ProfileController@index');
});

