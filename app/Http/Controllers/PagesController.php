<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FirebaseController;

class PagesController extends Controller
{
    public function index(){
        return view('welcome');
    }

    //Funcion para controlar la página de despacho
    public function despacho($numero = null){


        return view('despacho');
    }

    public function docencia($nombre = null){
        //Traemos un vector de las colecciones implicadas en la vista de manera dinamica
        $docencia = ['ABD','ED','MP'];
        //$asignatura = [];

        return view('docencia', compact('docencia', 'nombre'));
    }

    public function informacion($tipo = null){
        // Si no es nulo llamamos a
        //if(!isNull($tipo))

        return view('informacion');
    }
}
