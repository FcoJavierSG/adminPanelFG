<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class StorageController extends Controller
{
    /**
     * Variable donde se almacena una instancia de Storage
     */
    protected static $storage;

    /**
     * Constructor por defecto de la clase, en donde inicializamos $storage
     */
    public function __construct()
    {
        //Iniciamos una instancia de Storage con Firebase
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://futurguide.firebaseio.com/')->createStorage();
        //Guardamos dicha instancia de Storage
        static::$storage = $firebase;
    }

    /**
     * Sube a Cloud Storage un nuevo archivo recibiendo como parametros la ruta $filePath,
     * el nombre $fileName y si es necesario el bucket $bucketName donde se almacenará.
     *
     * Nota: $filePath y $fileName deberian ser del tipo $_FILES['imageToUpload']['tmp_name']
     * y $_FILES['imageToUpload']['name'] respectivamente.
     *
     * @param $bucketName
     * @param $filePath
     * @param $fileName
     */
    public function upload($bucketName, $filePath, $fileName) {
        $file = fopen($filePath, 'r');

        $deposito = static::$storage->getBucket($bucketName);
        $deposito->upload($file,
            [
                'name' => $fileName
                //En caso de querer visualizar las fotos de manera publica, añadir lo siguiente
                /*
                 'acl' => [],
                 'predefinedAcl' => 'PUBLICREAD'
                */
            ]
        );

        /* En caso de querer generar el link de descarga o visualizacion de otra forma,
           descomentar para devolver array con dicho contenido.
        $respuesta = $deposito->object($fileName)->info();

        return $respuesta;*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //PRUEBAS STORAGE

        //Iniciamos una instancia de Storage con Firebase
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createStorage();
        //Guardamos dicha instancia de Storage
        $storage = $firebase->getBucket()->object('prueba.jpeg')->info();

       /* $file = file_get_contents('/Applications/MAMP/htdocs/laravel/adminPanelFG/storage/app/public/uploads/informacion/KBuM9gJ0JJOen2yR87e6J1TKEuwuKsRSu46eGPe7.jpeg');

        //$deposito = $storage->bucket('info_miscelanea');

       $uploadRef = $storage->upload($file,
                [
                    'name' => 'prueba.jpeg',
                    'acl' => [],
                    'predefinedAcl' => 'PUBLICREAD'
                ]
            );
*/

        return var_dump($storage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fileName)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Elimina un archivo con nombre $fileName y almacenado en el bucket $bucketName
     *
     * @param string $bucketName
     * @param string $fileName
     */
    public function destroy($bucketName, $fileName)
    {
        $deposito = static::$storage->getBucket($bucketName);

        $objeto = $deposito->object($fileName);
        $objeto->delete();
    }
}
