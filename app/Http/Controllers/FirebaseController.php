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
    //Variable static donde se guardará la instancia de Firestore
    protected static $db;

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

    public function index(){
        //PRUEBAS
        $snapshot = static::$db->collection('users')->documents();

        foreach ($snapshot as $user) {
            if ($user->exists()) {
                printf('Document data for document %s:' . PHP_EOL, $user->id());
                print_r($user->data());
                printf(PHP_EOL);
            } else {
                printf('Document %s does not exist!' . PHP_EOL, $snapshot->id());
            }
        }

        echo '<pre>';

        //Devolvemos la instancia de Firestore
        //return static::$db;
    }

    public function create($collection, $data){
        $docRef = self::$db->collection($collection);
        $docRef->add($data);
        printf('Creado nuevo documento en ' . $collection . PHP_EOL);
        return json_encode($docRef);
    }

    public function read($collection, $id = null){
            $docRef = self::$db->collection($collection);

            //Controlamos si añade condicion
            if(!is_null($id)) {
                $documents = $docRef->document($id);
            } else {
                $documents = $docRef->documents();
            }

        return $documents;
    }

    public function update($collection, $id, $data){
        $docRef = self::$db->collection($collection)->document($id);
        $docRef->set($data);
        printf('Editado de la coleccion ' . $collection . ' el documento con id: ' . $id . PHP_EOL);
    }

    public function delete($collection, $id){
        $docRef = self::$db->collection($collection)->document($id);
        $docRef->delete();
        printf('Eliminado  de la coleccion ' . $collection . ' el documento con id ' . $id . PHP_EOL);
    }
}
