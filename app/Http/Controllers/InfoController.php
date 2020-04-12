<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    protected $informacion;
    protected $firebase;
    protected $storage;
    protected static $db;

    /**
     * Construtor por defecto de la clase, donde se inicializan las
     * principales variables.
     */
    function __construct(){
        $this->informacion = new Info();
        $this->firebase = new FirebaseController();
        $this->storage = new StorageController();
    }

    /**
     * Lee de Cloud Firestore todos los documentos de 'info_miscelanea'
     * y los devuelve junto con la vista principal de información
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $db = $this->firebase;

        $documentos = $db->read('info_miscelanea');

        //IMP AL LEER SERÍA INTERESANTE MOSTRAR O OBTENER LAS IMAGENES PARA MOSTRARLAS

        return view('informacion.index')->with('documentos', $documentos);
    }

    /**
     * Devuelve la vista al formulario de creación .
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('informacion.create');
    }

    /**
     * Almacena en la coleccion 'info_miscelanea' de Cloud Firestore
     * un nuevo documento con los datos del formulario, la imagen
     * la subimos a Cloud Storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Recogemos los datos del formulario sin token
        $datosInfo = request()->except('_token');

        /*  DEBERIAMOS:
            - COMPROBAR SI YA EXISTE UNA ENTRADA IGUAL EN FIRABASE
        */

        //Modificamos el contenido para pasar a guardar en Firebase la ruta del archivo y guardarla en local
        if($request->hasFile('foto_ppal')){
            //$datosInfo['foto_ppal'] = $request->file('foto_ppal')->store('uploads/informacion', 'public');
            $pathName = $request->file('foto_ppal')->getPathname();
            $fileName = $request->file('foto_ppal')->getFilename();
            $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

            //AQUI DEBERIA GUARDAR LA FOTO EN STORAGE
            $storage = $this->storage;

            $storage->upload('', $pathName, $fileName);

            $datosInfo['foto_ppal'] = $fileName;
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
     * Devuelve la vista con el formulario de edicion relleno
     * con los datos del docuemento con dicho id de Cloud Firebase.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $db = $this->firebase;

        $documento = $db->read('info_miscelanea', $id);

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

        //Guardamos la instancia de Firebase
        $db = $this->firebase;
        //Recogemos el documento a actualizar para comprobaciones
        $documento = $db->read('info_miscelanea', $datosInfo['docID']);

        //Modificamos el contenido para pasar a guardar en Firebase la ruta del archivo y guardarla en local
        if($request->hasFile('foto_ppal')){
            //Guardamos la ruta temporal y el nombre temporal al que le agregamos la extension
            $pathName = $request->file('foto_ppal')->getPathname();
            $fileName = $request->file('foto_ppal')->getFilename();
            $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

            //Guardamos la instancia de Storage
            $storage = $this->storage;

            //Borramos la foto existente del storage
            $storage->destroy('',$documento['foto_ppal']);
            //Subimos la nueva foto
            $storage->upload('', $pathName, $fileName);

            $datosInfo['foto_ppal'] = $fileName;
        } else {
            //Le paso la foto ya existente en caso de no rellenarse de nuevo
            $datosInfo['foto_ppal'] = $documento['foto_ppal'];
        }

        //Creamos un objeto de Info y lo vamos rellenando de las variables del formulario
        $infoData = $this->informacion;
        $infoData->titulo = $datosInfo['titulo'];
        $infoData->fecha = $datosInfo['fecha'];
        $infoData->info_ppal = $datosInfo['info_ppal'];
        if(!is_null($datosInfo['foto_ppal'])){
            $infoData->foto_ppal = $datosInfo['foto_ppal'];
        }

        // EN ESTE PUNTO DEBERIAMOS COMPROBAR CON ANTERIORIDAD LA CORRECTITUD DE LOS DATOS¿?

        //Generamos el array asociativo que necesitamos
        $infoData->setInfo();

        //Llamamos al método de la clase que inserta los datos
        $repuesta = $db->update('info_miscelanea', $id, $infoData->info);

        //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA EDICION
        return redirect('informacion');
    }

    /**
     * Elimina el docuemento con dicho id de la coleción 'info_miscelanea'
     * de Cloud Firestore, tambien elimina la foto de Cloud Storage
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $db = $this->firebase;
        $storage = $this->storage;

        $documento = $db->read('info_miscelanea', $id);

        $db->delete('info_miscelanea', $id);

        $storage->destroy('', $documento['foto_ppal']);


        //SERIA CONVENIENTE RETORNAR UNA CONFIRMACIÓN
        return redirect('informacion');
    }
}
