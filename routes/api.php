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
    // Route::get('/product/{id}', 'ProductController@show'); // Tampilkan data dengan id
    Route::patch('product/{id}', 'ProductController@update'); // Update data
    Route::delete('/product/{id}', 'ProductController@destroy'); // Hapus data
    Route::post('product/search', 'ProductController@search'); // Hapus data
    Route::get('user/product/{id}', 'ProductController@show'); // tampilkan data yg jual
    Route::get('product/watch/{id}', 'ProductController@watch');

    Route::get('profile', 'ProfileController@index'); // profile

    Route::post('order/{id}', 'OrderController@order'); // check in
    Route::get('checkout', 'OrderController@checkout'); // check out
    Route::delete('checkout/{id}', 'OrderController@delete');
    Route::post('konfirmasi', 'OrderController@konfirmasi'); // konfirmasi check out
    
    Route::get('history', 'HistoryController@index');
    Route::get('history/{id}', 'HistoryController@detail');

    Route::get('contact', 'MessagesController@index');
    Route::get('message/{id}', 'MessagesController@getMessage');
    Route::post('message/{id}', 'MessagesController@sendMessage');
});

