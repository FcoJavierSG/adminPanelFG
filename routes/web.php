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

Route::get('/', 'PagesController@index')->name('inicio');

Route::get('login', function () {
    return view('login');
});

Route::get('docencia/{nombre?}', 'PagesController@docencia')->name('docencia');

Route::get('despacho', 'PagesController@despacho')->name('despacho');

Route::get('informacion', 'PagesController@informacion')->name('informacion');

Route::get('firebase','FirebaseController@index');
