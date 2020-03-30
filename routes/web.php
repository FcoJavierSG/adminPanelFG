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
})->name('inicio');

Route::get('login', function () {
    return view('login');
});

Route::get('docencia/{nombre?}', function ($nombre) {
    //Traemos un vector de las colecciones implicadas en la vista de manera dinamica
    $docencia = ['ABD','ED','MP'];
    //$asignatura = [];

    return view('docencia', compact('docencia'));
})->name('docencia');

Route::get('despacho', function () {
    return view('despacho');
})->name('despacho');

Route::get('informacion', function () {
    return view('informacion');
})->name('informacion');
