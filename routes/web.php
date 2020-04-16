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

Route::get('/', function (){
    return view('login');
})->name('inicio');
//Ruta para el login
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


//Ruta donde estamos probando Firebase
Route::get('auth','AuthController@index');
