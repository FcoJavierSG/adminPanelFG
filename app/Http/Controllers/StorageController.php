<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class StorageController extends Controller
{
    protected static $storage;
    protected static $bucket;

    public function __construct()
    {
        //Iniciamos una instancia de Storage con Firebase
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://futurguide.firebaseio.com/')->createStorage();
        //Guardamos dicha instancia de Storage
        static::$storage = $firebase;

        //ESTA SENTENCIA LA DEBEMOS UTILIZAR PARA SELECCIONAR LA CARPETA DETERMINADA
        //$storage->getBucket($bucketName);
    }

    //Funcion para subir un archivo a Storage y que devuelva la referencia
    //IMP:
    // $filePath deberia contener un $_FILES['imageToUpload]['tmp_name']
    // $filenaName deberia contener un $_FILES['imageToUpload]['name']
    public function upload($bucketName, $filePath, $fileName) {
        $file = fopen($filePath, 'r');

        $deposito = static::$storage->getBucket($bucketName);
        $deposito->upload($file,
            [
                'name' => $fileName
                //En caso de querer visualizar las fotos de manera publica añadir lo siguiente
                /*
                 'acl' => [],
                 'predefinedAcl' => 'PUBLICREAD'
                */
            ]
        );

        //IMP DE MOMENTO DEVOLVEMOS EL 'mediaLink' o link de descarga
        $respuesta = $deposito->object($fileName)->info();

        return $respuesta;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bucketName, $fileName, $options = [])
    {
        $deposito = static::$storage->getBucket($bucketName);

        $objeto = $deposito->object($fileName);
        $objeto->delete();
    }
}
