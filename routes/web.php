<?php

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

// Main
Route::get('/', 'MainController@index')->name('index');

// Torrent
Route::post('torrents', 'TorrentController@store')->name('torrents.store');
Route::get('torrents/{hash}', 'TorrentController@show')->name('torrents.show');

// Administration
Route::group(['middleware' => ['auth']], function () {
    Route::get('torrents', 'TorrentController@index')->name('torrents.index');
});

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');