<?php

namespace App\Http\Controllers;

use App\Docencia;
use Illuminate\Http\Request;

class DocenciaController extends Controller
{
    protected $docencia;
    protected $firebase;

    /**
     * Construtor por defecto de la clase, donde se inicializan las
     * principales variables.
     */
    function __construct(){
        $this->docencia = new Docencia();
        $this->firebase = new FirebaseController();
        $this->storage = new StorageController();
    }

    /**
     * Lee de Cloud Firestore todos los documentos de 'docencia'
     * y los devuelve junto con la vista principal de docencia
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $db = $this->firebase;

        $documentos = $db->read('docencia');

        //Cargamos las asignaturas disponibles
        $asignaturas = $db->read('asignatura');
        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('docencia.index', compact('documentos', 'asignaturas', 'docentes'));
    }

    /**
     * Devuelve la vista al formulario de creación .
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $db = $this->firebase;

        //Cargamos las asignaturas disponibles
        $asignaturas = $db->read('asignatura');
        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('docencia.create', compact('asignaturas', 'docentes'));
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
        $datosDocencia = request()->except('_token');

        /* Comprobamos si existe un documento con mismo id_asignatura, dia_semana y tipo
         * en cuyo caso no insertaremos */
        if ($this->exist($datosDocencia['aula'], $datosDocencia['dia_semana'], $datosDocencia['hora_inicio'])) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE DOCENCIA');
        } else {
            $docenciaData = $this->docencia;

            $docenciaData->setDocencia($datosDocencia['id_asignatura'], $datosDocencia['docente'], $datosDocencia['tipo'],
                                    $datosDocencia['aula'], $datosDocencia['dia_semana'],
                                    $datosDocencia['hora_inicio'], $datosDocencia['hora_fin']);

            //Llamamos al método de la clase que inserta los datos
            $db = $this->firebase;
            $docRef = $db->create('docencia', $docenciaData->docencia);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return redirect('docencia');
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

        $documento = $db->read('docencia', $id);

        //Cargamos las asignaturas disponibles
        $asignaturas = $db->read('asignatura');
        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('docencia.edit', compact('documento','asignaturas', 'docentes'));
    }


    /**
     * Actualiza un documento de la coleccion 'docencia' con dicho id
     * a partir de los datos de un formulario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Recogemos los datos del formulario sin token
        $datosDocencia = request()->except(['_token', '_method']);

        $db = $this->firebase;

        $documento = $db->read('docencia', $datosDocencia['docID']);

        if ($this->exist($datosDocencia['aula'], $datosDocencia['dia_semana'], $datosDocencia['hora_inicio']) || $this->equal($datosDocencia, $documento)) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE DICHA DOCENCIA');
        } else {
            $docenciaData = $this->docencia;

            var_dump($datosDocencia);

            $docenciaData->setDocencia($datosDocencia['id_asignatura'], $datosDocencia['docente'], $datosDocencia['tipo'],
                $datosDocencia['aula'], $datosDocencia['dia_semana'],
                $datosDocencia['hora_inicio'], $datosDocencia['hora_fin']);

            //Llamamos al método de la clase que inserta los datos
            $docRef = $db->update('docencia', $id,$docenciaData->docencia);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return redirect('docencia');
        }
    }

    /**
     * Elimina el docuemento con dicho id de la coleción 'docencia' de Cloud Firestore
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $db = $this->firebase;

        $db->delete('docencia', $id);

        //SERIA CONVENIENTE RETORNAR UNA CONFIRMACIÓN
        return redirect('docencia');
    }

    /**
     * Comprueba la existencia de una entrada en 'docencia'
     *
     * @param $aula
     * @param $diaSemana
     * @param $horaInicio
     * @return bool
     */
    public function exist($aula, $diaSemana, $horaInicio){
        $db = $this->firebase;
        $consulta = $db->collection('docencia')
            ->where('aula', '=', $aula)
            ->where('dia_semana', '=', $diaSemana)
            ->where('hora_inicio', '=', $horaInicio);

        $documentos = $consulta->documents();

        $docExiste = false;
        foreach ($documentos as $documento){
            if ($documento->exists()) $docExiste = true;
        }

        return $docExiste;
    }

    /**
     * Comprueba la existencia de una entrada igual en 'docencia'
     *
     * @param $datosDocencia
     * @param $documento
     *
     * @return bool
     */
    public function equal($datosDocencia, $documento){

        $docEqual = false;

        if($datosDocencia['id_asignatura'] == $documento['id_asignatura'] && $datosDocencia['docente'] == $documento['docente'] &&
            $datosDocencia['tipo'] == $documento['tipo'] && $datosDocencia['aula'] == $documento['aula'] &&
            $datosDocencia['dia_semana'] == $documento['dia_semana'] && $datosDocencia['hora_inicio'] == $documento['hora_inicio'] &&
            $datosDocencia['hora_fin'] == $documento['hora_fin']  ) $docEqual = true;

        return $docEqual;
    }
}
