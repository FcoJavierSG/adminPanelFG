<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Http\Request;

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
    protected static $db;

    //Constructor de la clase
    //
    function __construct(){
        $this->informacion = new Info();
        $this->firebase = new FirebaseController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Funcion para leer y cargar de Firestore la tabla de información al completo
    public function index()
    {
        /*  PASOS:
         * 1. Verificar la sesión o el rol
         * 2. Abrir una instancia con la base de datos
         * 3. Leer coleccion
         * 4. Devolver vista con los documentos de dicha coleccion
         */

        $db = $this->firebase;

        $documentos = $db->read('info_miscelanea');

        //return var_dump($documentos);
        return view('informacion.index')->with('documentos', $documentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Funcion que controla la creación de una nueva entrada de información
    public function create()
    {
        /*  PASOS:
         * 1. Verificar la sesión o el rol
         * 2. Devolver vista con el formulario
         */
        return view('informacion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*  PASOS:
         * 0. Recoger datos del formulario
         * 1. Verificar la sesión o el rol
         * 2. Abrir una instancia con la base de datos
         * 3. Comprobar si existe un documento con dicha información
         * 4. Rellenar el objeto
         * 5. Insertar la informacion
         * 6. Devolver vista que confirme la inserccion
         */

        //$datosInfo = request()->all();

        //Recogemos los datos del formulario sin token
        $datosInfo = request()->except('_token');

        //Modificamos el contenido para pasar a guardar en Firebase la ruta del archivo y guardarla en local
        if($request->hasFile('foto_ppal')){
            $datosInfo['foto_ppal'] = $request->file('foto_ppal')->store('uploads/informacion', 'public');
        } else {
            $datosInfo['foto_ppal'] = null;
        }

        //Creamos un objeto de Info y lo vamos rellenando de las variables del formulario
        $infoData = $this->informacion;
        $infoData->titulo = $datosInfo['titulo'];
        $infoData->fecha = $datosInfo['fecha'];
        $infoData->info_ppal = $datosInfo['info_ppal'];
        if(!is_null($datosInfo['foto_ppal'])){
            $infoData->foto_ppal = $datosInfo['foto_ppal'];
        }

        /*  EN ESTE PUNTO DEBERIAMOS:
            - COMPROBAR QUE HAY UNA SESION ACTIVA Y TIENE ROL DE ADMIN DICHO USUARIO
            - COMPROBAR SI YA EXISTE UNA ENTRADA IGUAL EN FIRABASE
            - COMPROBAR CON ANTERIORIDAD LA CORRECTITUD DE LOS DATOS
        */

        //Generamos el array asociativo que necesitamos
        $infoData->setInfo();

        //Guardamos la instancia de Firebase
        $db = $this->firebase;
        //Llamamos al método de la clase que inserta los datos
        $docRef = $db->create('info_miscelanea', $infoData->info);

        //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
        return var_dump($docRef);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*  PASOS:
         * 1. Verificar sesión o el rol
         * 2. Abrir una instancia con la base de datos y consultar documento
         * 3. Meter el documento en un array y devolverlo junto a la vista para montar alli la tabla
         *
         */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*  PASOS:
         * 1. Verificar la sesión o el rol
         * 2. Abrir una instancia con la base de datos
         * 3. Leer de la coleccion el docuemnto
         * 4. Devolver vista con los datos de dicho documento rellanos
         */

        $db = $this->firebase;

        $documento = $db->read('info_miscelanea', $id);

        //$respuesta = $db->update()

        //return var_dump($documento);
        return view('informacion.edit', compact('documento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Recogemos los datos del formulario sin token
        $datosInfo = request()->except(['_token', '_method']);

        //Modificamos el contenido para pasar a guardar en Firebase la ruta del archivo y guardarla en local
        if($request->hasFile('foto_ppal')){
            $datosInfo['foto_ppal'] = $request->file('foto_ppal')->store('uploads/informacion', 'public');
        } else {
            $datosInfo['foto_ppal'] = null;
        }

        //Creamos un objeto de Info y lo vamos rellenando de las variables del formulario
        $infoData = $this->informacion;
        $infoData->titulo = $datosInfo['titulo'];
        $infoData->fecha = $datosInfo['fecha'];
        $infoData->info_ppal = $datosInfo['info_ppal'];
        if(!is_null($datosInfo['foto_ppal'])){
            $infoData->foto_ppal = $datosInfo['foto_ppal'];
        }

        /*  EN ESTE PUNTO DEBERIAMOS:
            - COMPROBAR QUE HAY UNA SESION ACTIVA Y TIENE ROL DE ADMIN DICHO USUARIO
            - COMPROBAR SI YA EXISTE UNA ENTRADA IGUAL EN FIRABASE
            - COMPROBAR CON ANTERIORIDAD LA CORRECTITUD DE LOS DATOS
        */

        //Generamos el array asociativo que necesitamos
        $infoData->setInfo();

        //Guardamos la instancia de Firebase
        $db = $this->firebase;
        //Llamamos al método de la clase que inserta los datos
        $docRef = $db->update('info_miscelanea', $id, $infoData->info);

        //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA EDICION
        return var_dump($docRef);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $db = $this->firebase;

        $documento = $db->delete('info_miscelanea', $id);

        //DEBEMOS BORRAR O MOVER LA FOTO DE 'uploads/informacion'

        //return var_dump($documento);
        return redirect('informacion');
    }
}
