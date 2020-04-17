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

        /* Comprobamos si existe un documento con mismo titulo, fecha e info_ppal
         * en cuyo caso no insertaremos */
        if ($this->exist($datosInfo['titulo'], $datosInfo['fecha'], $datosInfo['info_ppal'])) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE DICHA INFORMACION');
        } else {
            //Modificamos el contenido para pasar a guardar en Firebase la ruta del archivo y guardarla en local
            if($request->hasFile('foto_ppal') && $request->hasFile('foto')){
                $pathName = $request->file('foto_ppal')->getPathname();
                $fileName = $request->file('foto_ppal')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

                //Procedemos al guardado de la foto en Storage
                $storage = $this->storage;
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto_ppal'] = $fileName;

                //Ahora insertamos la foto adicional
                $pathName = $request->file('foto')->getPathname();
                $fileName = $request->file('foto')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto')->extension();

                //Procedemos al guardado de la foto en Storage
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto'] = $fileName;
            } else if($request->hasFile('foto_ppal')) {
                $pathName = $request->file('foto_ppal')->getPathname();
                $fileName = $request->file('foto_ppal')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

                //Procedemos al guardado de la foto en Storage
                $storage = $this->storage;
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto_ppal'] = $fileName;
                $datosInfo['foto'] = null;
            }else{
                $datosInfo['foto_ppal'] = null;
                $datosInfo['foto'] = null;
            }


            //Creamos un objeto de Info y lo vamos rellenando de las variables del formulario
            $infoData = $this->informacion;

            //Generamos el array asociativo que necesitamos
            $infoData->setInfo(null, $datosInfo['tipo'], $datosInfo['titulo'], $datosInfo['fecha'],
                $datosInfo['info_ppal'], $datosInfo['foto_ppal'], $datosInfo['info'], $datosInfo['foto'],null);

            //Llamamos al método de la clase que inserta los datos
            $db = $this->firebase;
            $docRef = $db->create('info_miscelanea', $infoData->info);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return redirect('informacion');
        }
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
     * Actualiza los datos de un documento con $id de la de coleccion 'info_miscelanea'
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Recogemos los datos del formulario sin token
        $datosInfo = request()->except(['_token', '_method']);

        $hayFotoPpal = $request->hasFile('foto_ppal');
        $hayFoto = $request->hasFile('foto');

        //Guardamos la instancia de Firebase
        $db = $this->firebase;
        //Recogemos el documento a actualizar para comprobar si tiene una foto insertada
        $documento = $db->read('info_miscelanea', $datosInfo['docID']);

        //Guardamos la instancia de Storage
        $storage = $this->storage;

        if ($this->exist($datosInfo['titulo'], $datosInfo['fecha'], $datosInfo['info_ppal']) || $this->equal($datosInfo, $documento) && !$hayFotoPpal && !$hayFoto) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE DICHA INFORMACION');
        } else {
            /*
             * En esta estructura if elseif elseif else lo que hacemos es cubrir las distintas casuisticas
             * de actualizacion de 'foto_ppal' y 'foto', para cada caso primeramente guardamos la ruta y nombre de archivo,
             * de ser necesario eliminamos el existente de Storage e insertamos la nueva guardando su nombre en Cloud Firestore.
             */
            if ($hayFotoPpal && $hayFoto) {
                //Guardamos la ruta temporal y el nombre temporal al que le agregamos la extension
                $pathName = $request->file('foto_ppal')->getPathname();
                $fileName = $request->file('foto_ppal')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

                //Borramos la foto existente del storage
                $storage->destroy('', $documento['foto_ppal']);
                //Subimos la nueva foto
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto_ppal'] = $fileName;

                //Guardamos la ruta temporal y el nombre temporal al que le agregamos la extension
                $pathName = $request->file('foto')->getPathname();
                $fileName = $request->file('foto')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto')->extension();

                //Borramos la foto existente del storage
                if (!is_null($documento['foto'])) $storage->destroy('', $documento['foto']);
                //Subimos la nueva foto
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto'] = $fileName;
            } else if ($hayFotoPpal) {
                //Guardamos la ruta temporal y el nombre temporal al que le agregamos la extension
                $pathName = $request->file('foto_ppal')->getPathname();
                $fileName = $request->file('foto_ppal')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto_ppal')->extension();

                //Borramos la foto existente del storage
                $storage->destroy('', $documento['foto_ppal']);
                //Subimos la nueva foto
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto_ppal'] = $fileName;

                if (!is_null($documento['foto'])) {
                    $datosInfo['foto'] = $documento['foto'];
                } else {
                    $datosInfo['foto'] = null;
                }

            } else if ($hayFoto) {
                //Guardamos la ruta temporal y el nombre temporal al que le agregamos la extension
                $pathName = $request->file('foto')->getPathname();
                $fileName = $request->file('foto')->getFilename();
                $fileName = $fileName . '.' . $request->file('foto')->extension();

                //Borramos la foto existente del storage
                if (!is_null($documento['foto'])) $storage->destroy('', $documento['foto']);
                //Subimos la nueva foto
                $storage->upload('', $pathName, $fileName);

                $datosInfo['foto'] = $fileName;
                $datosInfo['foto_ppal'] = $documento['foto_ppal'];
            } else {
                //Le paso la foto ya existente en caso de no rellenarse de nuevo
                $datosInfo['foto_ppal'] = $documento['foto_ppal'];

                if (!is_null($documento['foto'])) {
                    $datosInfo['foto'] = $documento['foto'];
                } else {
                    $datosInfo['foto'] = null;
                }
            }

            //Creamos un objeto de Info y lo vamos rellenando de las variables del formulario
            $infoData = $this->informacion;

            //Generamos el array asociativo que necesitamos
            $infoData->setInfo(null, $datosInfo['tipo'], $datosInfo['titulo'], $datosInfo['fecha'],
                $datosInfo['info_ppal'], $datosInfo['foto_ppal'], $datosInfo['info'], $datosInfo['foto'],null);

            //Llamamos al método de la clase que inserta los datos
            $repuesta = $db->update('info_miscelanea', $id, $infoData->info);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA EDICION
           // return redirect('informacion');
            return redirect('informacion');
        }
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

        if (!is_null($documento['foto_ppal'])) $storage->destroy('', $documento['foto_ppal']);
        if (!is_null($documento['foto'])) $storage->destroy('', $documento['foto']);

        //SERIA CONVENIENTE RETORNAR UNA CONFIRMACIÓN
        return redirect('informacion');
    }


    /**
     * Comprueba la existencia de una entrada en 'info_miscelanea'
     *
     * @param $titulo
     * @param $fecha
     * @param $info_ppal
     * @return bool
     */
    public function exist($titulo, $fecha, $info_ppal){
        $db = $this->firebase;
        $consulta = $db->collection('info_miscelanea')
            ->where('titulo', '=', $titulo)
            ->where('fecha', '=', $fecha)
            ->where('info_ppal', '=', $info_ppal);

        $documentos = $consulta->documents();

        $docExiste = false;
        foreach ($documentos as $documento){
            if ($documento->exists()) $docExiste = true;
        }

        return $docExiste;
    }

    /**
     * Comprueba si un documento existente y los datos pasados son iguales
     *
     * @param $titulo
     * @param $fecha
     * @param $info_ppal
     * @return bool
     */
    public function equal($datosInfo, $documento){

        $docExiste = false;

        if($datosInfo['tipo'] == $documento['tipo'] && $datosInfo['titulo'] == $documento['titulo'] &&
            $datosInfo['fecha'] == $documento['fecha'] && $datosInfo['info_ppal'] == $documento['info_ppal'] &&
            $datosInfo['info'] == $documento['info']) $docExiste = true;

        return $docExiste;
    }
}
