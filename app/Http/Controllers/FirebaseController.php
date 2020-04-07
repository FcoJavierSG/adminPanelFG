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
    //
    protected static $db;

    public function index(){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://futurguide.firebaseio.com/')->createFirestore();

        $db = $firebase->database();


        /* PRUEBAS
        $snapshot = $db->collection('info_miscela')->documents();

        foreach ($snapshot as $user) {
            if ($user->exists()) {
                printf('Document data for document %s:' . PHP_EOL, $user->id());
                print_r($user->data());
                printf(PHP_EOL);
            } else {
                printf('Document %s does not exist!' . PHP_EOL, $snapshot->id());
            }
        }

        echo '<pre>';*/
        return $db;
    }

    public function create($collection, $data){
        $docRef = self::$db->collection($collection);
        $docRef->add($data);
        printf('Creado nuevo documento en ' . $collection . PHP_EOL);
        return json_encode($docRef);
    }

    public function read($collection, $queryCondition = null){
            $docRef = self::$db->collection($collection);

            //Controlamos si añade condicion
            if(!isNull($queryCondition)) {
                $query = $docRef->where($queryCondition);
                $documents = $query->documents();
            } else {
                $documents = $docRef->documents();
            }

        return dd ($documents);
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
