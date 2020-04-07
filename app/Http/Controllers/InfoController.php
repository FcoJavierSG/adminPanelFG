<?php

namespace App\Http\Controllers;


use App\User;
use App\Info;
use Illuminate\Http\Request;
use App\Http\Controllers\FirebaseController;


class InfoController extends Controller
{
    //  CONTROLADOR PARA TODAS LAS VISTAS DE INFORMACIÓN
    /*
     *  CADA FUNCIÓN DEBERIA RETORNAR LA VISTA CORRESPONDIENTE
     *  Y PROPORCIONAR LOS DATOS NECESARIOS A DICHA VISTA
     *
     * */

    //Variable que contiene un objeto de la clase Info
    protected $informacion;
    protected $firebase;
    protected $db;

    //Constructor de la clase
    function __construct(){
        $this->informacion = new Info();
        $this->firebase = new FirebaseController();
    }

    /*
     *  Función para leer la coleccion de información desde firebase y devolver
        un array asociativo con los campos correspondientes */
    public function readInfo(){
        /*  PASOS:
         * 1. Comprobar que se ha iniciado sesión o el rol
         * 2. Abrir una instancia con la base de datos y perdir la coleccion
         * 3. Meter toda la coleccion en un array y devolverlo junto a la vista para montar alli la tabla
         */

        $database = $this->firebase;
        $documentos = $database->read('info_miscelanea');

        //Devolvemos la vista junto con la lista de documentos a 'pintar'
        return view('informacion')->with('documentos', $documentos);
    }

    /* Función para leer un documento de información desde firebase y devolver
        un array asociativo con los campos correspondientes */
    public function readDocInfo($database, $queryCondition){
        /*  PASOS:
         * 1. Verificar sesión o el rol
         * 2. Abrir una instancia con la base de datos y consultar documento
         * 3. Meter el documento en un array y devolverlo junto a la vista para montar alli la tabla
         *
         */
    }

    /* Función para crear un documento de información desde firebase y devolver
        id */
    public function createDocInfo($database, $informacion){
        /*  PASOS:
         * 1. Verificar la sesión o el rol
         * 2. Abrir una instancia con la base de datos
         * 3. Comprobar si existe un documento con dicha información
         * 4. Rellenar el objeto
         * 5. Insertar la informacion
         * 6. Devolver id
         *
         */
    }

    /* Función para actualizar un documento de información de firebase */
    public function updateDocInfo($database, $id, $informacion){

    }

    /* Función para eliminar un documento de información de firebase */
    public function deleteDocInfo($database, $id){

    }
}
