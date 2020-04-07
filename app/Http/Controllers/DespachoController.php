<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DespachoController extends Controller
{
    /*  IMP: DEBEMOS CONTROLAR Y FILTRAR LOS DATOS PARA QUE SE CUMPLAN LOS REQUISITOS

        A REALIZAR:

        FUNCIÓN PARA LEER TODOS LOS DESPACHOS
        FUNCIÓN PARA LEER UN DESPACHO EN CONCRETO
        FUNCIÓN PARA CREAR NUEVO DESPACHO
        FUNCIÓN PARA EDITAR DESPACHO
        FUNCIÓN PARA ELIMINAR DESPACHO

     */

    /* Función para leer la coleccion de información desde firebase y devolver
        un array asociativo con los campos correspondientes */
    public function readInfo($database){

    }

    /* Función para leer un documento de información desde firebase y devolver
        un array asociativo con los campos correspondientes */
    public function readDocInfo($database, $id){

    }
}
