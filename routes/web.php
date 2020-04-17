<?php

use Illuminate\Support\Facades\Route;

/*
 * RUTAS PARA LAS PAGINAS PRINCIPALES, LOGIN Y LOGOUT
 */

Route::get('/', function (){
    return view('login');
})->name('inicio');

Route::post('login', 'AuthController@login')->name('login');

Route::get('logout', 'AuthController@logout')->name('logout');

Route::get('inicio', function (){
    return view('inicio');
})->name('inicio');

/*
 * RUTAS PARA LAS PAGINAS DE DOCENCIA
 */
Route::resource('docencia', 'DocenciaController');


/*
 * RUTAS PARA LAS PAGINAS DE DESPACHOS Y TUTORIAS
 */
Route::resource('despacho', 'DespachoController');

Route::resource('tutoria', 'TutoriaController');


/*
 * RUTAS PARA LAS PAGINAS DE INFORMACIÓN
 */
Route::resource('informacion', 'InfoController');
