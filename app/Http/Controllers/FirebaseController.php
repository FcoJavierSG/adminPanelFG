<?php

/*
 |  Controlador para la BD de Firebase Cloud Firestore
 |-------------------------------------------------------
 |  Los metodos de los que disponemos son:
 |
 |  create($collection, $data) --> Para la creación de nuevos documentos
 |  read($collection, $queryCondition) --> Para la lectura de documentos
 |  update($collection, $id, $data) --> Para la actualizacion de documentos
 |  delete($collection, $id) --> Para la eliminacion de documentos
 |-------------------------------------------------------
 |
 |
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Firestore;

class FirebaseController extends Controller
{
   /**
    * Variable donde almacenaremos la instancia de Firestore
    */
    protected static $db;

    /**
     * Constructor por defecto de la clase, en el inicializamos $db
     */
    //Constructor por defecto de la clase
    public function __construct() {
        //Iniciamos una instancia con la BD
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://futurguide.firebaseio.com/')->createFirestore();
        //Guardamos dicha instancia
        static::$db = $firebase->database();

    }


    /*public function index(){
        //PRUEBAS
        $snapshot = static::$db;

        var_dump($snapshot);
        //Devolvemos la instancia de Firestore
        //return static::$db;
    }*/

    /**
     * Crea una nueva entrada en Cloud Firestore en la coleccion
     * y con los datos pasados como parámetros
     *
     * - Devuelve una confirmación de inserccion
     */
    public function create($collection, $data){
        $docRef = self::$db->collection($collection);
        $docRef->add($data);
       // printf('Creado nuevo documento en ' . $collection . PHP_EOL);
        return json_encode($docRef);
    }

    /**
     * Lee de Cloud Firestore, bien una coleccion entera, bien
     * un documento a partir de su id
     *
     * - Devuelve una lista de documentos o documento
     */
    public function read($collection, $id = null){
            $docRef = self::$db->collection($collection);

            //Controlamos si añade condicion
            if(!is_null($id)) {
                $docRef = $docRef->document($id);
                $documents = $docRef->snapshot();

            } else {
                $documents = $docRef->documents();
            }

        return $documents;
    }

    /**
     * Actualiza un documento de una coleccion de Cloud Firestore
     * con los datos pasados y que se corresponda con el id dado
     */
    public function update($collection, $id, $data){
        $docRef = self::$db->collection($collection)->document($id);
        $docRef->set($data);
        //printf('Editado de la coleccion ' . $collection . ' el documento con id: ' . $id . PHP_EOL);
    }

    /**
     * Elimina de Cloud Firestore un documento de una coleccion
     * determinada y con el id dado
     */
    public function delete($collection, $id){
        $docRef = self::$db->collection($collection)->document($id);
        $docRef->delete();
       // printf('Eliminado  de la coleccion ' . $collection . ' el documento con id ' . $id . PHP_EOL);
    }

    /**
     * Devuelve una coleccion determinada para poder operar
     */
    public function collection($collection){
        return self::$db->collection($collection);
    }
}
