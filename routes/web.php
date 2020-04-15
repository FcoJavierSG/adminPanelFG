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

/*  NOTAS IMP: PODEMOS UTILIZAR CUALQUIER TIPO DE 'VERBO' HTTP PARA LA CREACION DE RUTAS,
 *  DE IGUAL MANERA PODREMOS UTILIZAR UNA MISMA RUTA PARA DIFERENTES FINES LEER (GET), INSERTAR (POST)...
 * */

//Ruta para la página de inicio
//IMP: DEBEREMOS REDIGIR EN EL FUTURO DESDE ESTA RUTA A LA DE LOGIN SI NO EXISTE UN SESION ACTIVA
Route::get('/', 'PagesController@index')->name('inicio');

//Ruta para el login
Route::get('login', function () {
    return view('login');
});

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
Route::get('storage','FirebaseController@index');
