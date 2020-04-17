<?php

namespace App\Http\Controllers;

use App\Despacho;
use Illuminate\Http\Request;

class DespachoController extends Controller
{
    protected $despacho;
    protected $firebase;

    /**
     * Construtor por defecto de la clase, donde se inicializan las
     * principales variables.
     */
    function __construct(){
        $this->despacho = new Despacho();
        $this->firebase = new FirebaseController();
    }

    /**
     * Lee de Cloud Firestore todos los documentos de 'despacho'
     * y los devuelve junto con la vista principal de despacho
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

        return view('despacho.index', compact('documentos', 'tutorias','docentes'));
    }

    /**
     * Devuelve la vista al formulario de creación .
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $db = $this->firebase;

        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('despacho.create', compact('docentes'));
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
        $datosDespacho = request()->except('_token');

        /* Comprobamos si existe un documento con mismo id_asignatura, dia_semana y tipo
         * en cuyo caso no insertaremos */
        //IMP COMPROBAR SI EXISTE UN DOCENTE ASIGNADO A OTRO DESPACHO
        if ($this->exist($datosDespacho['n_despacho']) || $this->docenteAsignado($datosDespacho['n_despacho'],$datosDespacho['1erDocente']) ||
            $this->docenteAsignado($datosDespacho['n_despacho'],$datosDespacho['2oDocente']) || $this->docenteAsignado($datosDespacho['n_despacho'],$datosDespacho['3erDocente'])){
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE ESTE DESPACHO O ALGUNOS DE LOS DOCENTES YA ESTÁN ASIGNADOS A OTRO');
        } else {
            $despachoData = $this->despacho;

            $docentesData = array($datosDespacho['1erDocente'], $datosDespacho['2oDocente'], $datosDespacho['3erDocente']);

            $despachoData->setDespacho($docentesData, $datosDespacho['info_despacho'], $datosDespacho['n_despacho']);

            //Llamamos al método de la clase que inserta los datos
            $db = $this->firebase;
            $docRef = $db->create('despacho', $despachoData->despacho);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return redirect('despacho');
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

        $documento = $db->read('despacho', $id);

        //Cargamos los usuarios que sean docentes
        $docentes = $db->collection('usuario')->where('rol', '=' , 1);
        $docentes = $docentes->documents();

        return view('despacho.edit', compact('documento', 'docentes'));
    }


    /**
     * Actualiza un documento de la coleccion 'despacho' con dicho id
     * a partir de los datos de un formulario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Recogemos los datos del formulario sin token
        $datosDespacho = request()->except(['_token', '_method']);

        $db = $this->firebase;

        $documento = $db->read('despacho', $datosDespacho['docID']);


        //REVISAR CONDICION YA QUE SI SE MODIFICA EL NUMERO Y LOS DATOS NO DEBERIA DEJARNOS INSERTAR
        // EN CASO QUE CONCUERDE CON OTRO DESPACHO
        if ($this->exist($datosDespacho['n_despacho']) && $this->equal($datosDespacho, $documento)) {
            //DEBERIAMOS DEVOLVER UNA VISTA CON LA RESPUESTA
            printf('YA EXISTE ESTE DESPACHO O ALGUNOS DE LOS DOCENTES YA ESTÁN ASIGNADOS A OTRO');
        } else if ($this->docenteAsignado($datosDespacho['n_despacho'], $datosDespacho['1erDocente']) ||
            $this->docenteAsignado($datosDespacho['n_despacho'], $datosDespacho['2oDocente']) ||
            $this->docenteAsignado($datosDespacho['n_despacho'], $datosDespacho['3erDocente'])) {
            printf('ALGUNOS DE LOS DOCENTES YA ESTÁN ASIGNADOS A OTRO DESPACHO');
        }else{
            $despachoData = $this->despacho;

            $docentesData = array($datosDespacho['1erDocente'], $datosDespacho['2oDocente'], $datosDespacho['3erDocente']);

            $despachoData->setDespacho($docentesData, $datosDespacho['info_despacho'], $datosDespacho['n_despacho']);

            //Llamamos al método de la clase que inserta los datos
            $db = $this->firebase;
            $docRef = $db->update('despacho', $id, $despachoData->despacho);

            //DEBEMOS CAMBIAR ESTA RESPUESTA POR UNA VISTA DONDE SE CONFIRME LA INSERCCION
            return redirect('despacho');
        }
    }

    /**
     * Elimina el documento con dicho id de la coleción 'despacho' de Cloud Firestore
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $db = $this->firebase;

        $db->delete('despacho', $id);

        //IMPORTANTE ¿TENER EN CUENTA LA ELIMINACION DE TODAS LAS TUTORIAS ASOCIADAS A LOS DOCENTES?

        //SERIA CONVENIENTE RETORNAR UNA CONFIRMACIÓN
        return redirect('despacho');
    }

    /**
     * Comprueba la existencia de una entrada en 'despacho'
     *
     * @param $idAsignatura
     * @param $diaSemana
     * @param $tipo
     * @return bool
     */
    public function exist($nDespacho){
        $db = $this->firebase;
        $consulta = $db->collection('despacho')
            ->where('n_despacho', '=', $nDespacho);

        $documentos = $consulta->documents();

        $docExiste = false;
        foreach ($documentos as $documento){
            if ($documento->exists()) $docExiste = true;
        }

        return $docExiste;
    }

    /**
     * Comprueba la existencia de una entrada en 'despacho'
     *
     * @param $idAsignatura
     * @param $diaSemana
     * @param $tipo
     * @return bool
     */
    public function docenteAsignado($nDespacho ,$docente){
        $db = $this->firebase;
        $consulta = $db->collection('despacho');

        $documentos = $consulta->documents();

        $docenteAsignado = false;
        foreach ($documentos as $documento){
            if ($documento->exists() && $documento['n_despacho'] != $nDespacho && !is_null($docente) &&
                ($docente == $documento['docente'][0] || $docente == $documento['docente'][1] ||
                    $docente == $documento['docente'][2]) ) $docenteAsignado = true;
        }

        return $docenteAsignado;
    }

    /**
     * Comprueba la existencia de una entrada igual en 'despacho'
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
