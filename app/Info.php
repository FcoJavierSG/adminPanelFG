<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Info /*extends Model*/
{
    //JSON que contiene la informacion lista para usar
    public $info;

    //Variables que puede contener cualquier información
    public $codInfo = null;
    public $tipo = null;
    public $titulo = null;
    public $fecha = null;
    public $info_ppal = null;
    public $foto_ppal = null;
    public $infor = array(null);
    public $foto = array(null);
    public $estado = null;

    //Funcion para rellenar JSON con la informacion del documento
    public function setInfo(){
        $this->info = array(
            'cod_info' => $this->codInfo,
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'info_ppal' => $this->info_ppal,
            'foto_ppal' => $this->foto_ppal,
            'info' => $this->infor,
            'foto' => $this->foto,
            'estado' => $this->estado );
    }

    //Funcion para devolver JSON de la info
    public function getInfo(){
        return \Response::json($this->info);
    }
}
