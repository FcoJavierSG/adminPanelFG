<?php

namespace App\Http\Controllers;

use App\Despacho;
use Illuminate\Http\Request;

class TutoriaController extends Controller
{
    protected $tutoria;
    protected $firebase;

    /**
     * Construtor por defecto de la clase, donde se inicializan las
     * principales variables.
     */
    function __construct(){
        $this->tutoria = new Despacho();
        $this->firebase = new FirebaseController();
    }

    /**
     * Lee de Cloud Firestore todos los documentos de 'tutoria'
     * y los devuelve junto con la vista principal de docencia
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $db = $this->firebase;

        $documentos = $db->read('despacho');

        $tutorias = $db->read('tutoria');

        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('tutoria.index', compact('documentos', 'tutorias','docentes'));
    }

    /**
     * Devuelve la vista al formulario de creación .
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $db = $this->firebase;

        $docente = request()->except('_token');

        if (isset($docente['id'])){
            //Cargamos los usuarios que sean docentes
            $docente = $db->read('usuario', $docente['id']);
            return view('tutoria.create', compact('docente'));
        }
    }

    /**
     * Almacena en Cloud Firestore un documento con los datos rellenos
     * en el formulario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Recogemos los datos del formulario sin token
        $datosTutoria = request()->except('_token');

        //Llamamos al método de la clase que inserta los datos
        $db = $this->firebase;

        /* Comprobamos si existe un documento con mismo id_asignatura, dia_semana y tipo
         * en cuyo caso no insertaremos */
        if ($this->exist($datosTutoria)) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE ESTA TUTORIA');
        } else {
            $tutoriaData = $this->tutoria;

            $tutoriaData->setTutoria($datosTutoria['docente'], $datosTutoria['semestre'], $datosTutoria['dia_semana'],
                $datosTutoria['hora_inicio'], $datosTutoria['hora_fin']);

            $db->create('tutoria', $tutoriaData->tutoria);


            $docente = $db->read('usuario', $datosTutoria['id']);
            $tutorias = $db->collection('tutoria')->where('dni', '=', $datosTutoria['docente']);
            $tutorias = $tutorias->documents();

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return view('tutoria.edit', compact('docente','tutorias'));
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
        //
    }

    /**
     * Devuelve la vista con el formulario de edicion relleno
     * con los datos del documento con dicho id de Cloud Firebase.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $db = $this->firebase;

        $docente = $db->read('usuario', $id);

        //Cargamos los usuarios que sean docentes
        $tutorias = $db->collection('tutoria')->where('dni', '=', $docente['dni']);
        $tutorias = $tutorias->documents();

        foreach ($tutorias as $tutoria){
            if ($tutoria->exists()){
                return view('tutoria.edit', compact('docente','tutorias'));
            }
        }

        return view('tutoria.create', compact('docente'));
    }


    /**
     * Actualiza un documento de la coleccion 'tutoria' con dicho id
     * a partir de los datos de un formulario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Recogemos los datos del formulario sin token
        $datosTutoria = request()->except('_token');

        $db = $this->firebase;

        $docente = $db->read('usuario', $datosTutoria['id']);

        //---

        /* Comprobamos si existe un documento con mismo id_asignatura, dia_semana y tipo
         * en cuyo caso no insertaremos */
        if ($this->exist($datosTutoria)) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE ESTA TUTORIA');
        } else {
            $tutoriaData = $this->tutoria;

            $tutoriaData->setTutoria($datosTutoria['docente'], $datosTutoria['semestre'], $datosTutoria['dia_semana'],
                $datosTutoria['hora_inicio'], $datosTutoria['hora_fin']);

            $docRef = $db->update('tutoria', $id, $tutoriaData->tutoria);

            $tutorias = $db->collection('tutoria')->where('dni', '=', $datosTutoria['docente']);
            $tutorias = $tutorias->documents();


            return view('tutoria.edit', compact('docente','tutorias'));
        }
    }

    /**
     * Elimina el docuemento con dicho id de la colección 'tutoria' de Cloud Firestore
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $db = $this->firebase;

        $db->delete('tutoria', $id);

        //SERIA CONVENIENTE RETORNAR UNA CONFIRMACIÓN
        return redirect('despacho');
    }

    /**
     * Comprueba la existencia de una entrada en 'tutoria'
     *
     * @param $idAsignatura
     * @param $diaSemana
     * @param $tipo
     * @return bool
     */
    public function exist($datosTutoria){
        $db = $this->firebase;
        $consulta = $db->collection('tutoria')
            ->where('docente', '=', $datosTutoria['docente'])
            ->where('dia_semana', '=', $datosTutoria['dia_semana'])
            ->where('semestre', '=', $datosTutoria['semestre'])
            ->where('hora_inicio', '=', $datosTutoria['hora_inicio'])
            ->where('hora_fin', '=', $datosTutoria['hora_fin']);

        $documentos = $consulta->documents();

        $docExiste = false;
        foreach ($documentos as $documento){
            if ($documento->exists()) $docExiste = true;
        }

        return $docExiste;
    }

    /**
     * Comprueba la existencia de una entrada en 'tutoria'
     *
     * @param $titulo
     * @param $fecha
     * @param $info_ppal
     * @return bool
     */
    public function equal($datosDespacho, $documento){

        $docEqual = false;

        if($datosDespacho['1erDocente'] == $documento['docente'][0] && $datosDespacho['2oDocente'] == $documento['docente'][1] &&
            $datosDespacho['3erDocente'] == $documento['docente'][2] && $datosDespacho['info_despacho'] == $documento['info_despacho']
            && $datosDespacho['n_despacho'] == $documento['n_despacho']) $docEqual = true;

        return $docEqual;
    }
}
