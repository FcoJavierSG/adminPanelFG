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

/*Ruta para la docencia que devuelve toda la docencia o una en concreto, como parámetro opcional permitiremos cadenas de caracteres alfabeticos
Route::get('docencia/{nombre?}', 'PagesController@docencia')->where('nombre', '[a-zA-Z]+')->name('docencia');

//Ruta para realizar gestiones en una docencia, como parámetro permitiremos cadenas de caracteres alfabeticos
Route::post('docencia/{nombre}', 'PagesController@docencia')->where('nombre', '[a-zA-Z]+');//->name('docencia');*/

/*
 * RUTAS PARA LAS PAGINAS DE DESPACHOS
 */

Route::resource('despacho', 'DespachoController');

/*Ruta para los despachos que devuelve todos ellos o uno en concreto, como parámetro opcional permitiremos tan solo digitos
Route::get('despacho/{numero?}', 'PagesController@despacho')->where('numero', '\d+')->name('despacho');

//Ruta para realizar gestiones en los despachos, como parámetro permitiremos tan solo digitos
Route::post('despacho/{numero}', 'PagesController@despacho')->where('numero', '\d+');//->name('despacho');*/

/*
 * RUTAS PARA LAS PAGINAS DE INFORMACIÓN
 */

/*Ruta para la información que devuelve todas ellas o un tipo en concreto, como parametro opcional permitiremos cadenas de caracteres alfabeticos
Route::get('informacion/{tipo?}', 'PagesController@informacion')->where('tipo','[a-zA-Z]+')->name('informacion');

//Ruta para realizar gestiones en información, como parametro permitiremos cadenas de caracteres alfabeticos
Route::post('informacion/{tipo}', 'PagesController@informacion')->where('tipo','[a-zA-Z]+');//->name('informacion');*/

Route::resource('informacion', 'InfoController');


//Ruta donde estamos probando Firebase
//Route::get('firebase','InfoController@index');
