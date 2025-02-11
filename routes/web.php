<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('admin', function(){
    return view('main');
});
Route::resource('category', 'CategoryController')->except('create', 'show');

Route::resource('produk', 'ProductWebController');

Route::resource('profile', 'ProfileWebController');
Route::patch('profile/update/{id}', 'ProfileWebController@update');
Route::get('profile/search', 'ProfileWebController@search');

Route::resource('docs', 'DocsController');
Route::get('loginadmin', 'DocsController@loginAdmin');