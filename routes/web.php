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
Route::get('/show/{id}', 'HomeController@show')->name('show');

Route::prefix('album')->middleware('auth')->name('album.')->group(function(){
    Route::post('/store', 'AlbumController@store')->name('store');
    Route::post('/delete', 'AlbumController@destroy')->name('delete');
    Route::post('/move', 'AlbumController@move')->name('move');
    Route::get('/index', 'AlbumController@index')->name('index');
});

Route::prefix('file')->middleware('auth')->name('file.')->group(function(){
    Route::post('/store', 'AlbumController@fileStore')->name('store');
    Route::post('/delete', 'AlbumController@fileDelete')->name('delete');
    Route::post('/getall/{id}', 'AlbumController@getAllFiles')->name('getall');
});
