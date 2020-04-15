<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Info
{
    //JSON que contiene la informacion lista para usar
    public $info;

    //Funcion para rellenar JSON con la informacion del documento
    public function setInfo($codInfo = null, $tipo = null, $titulo = null,
                            $fecha = null, $info_ppal = null, $foto_ppal = null,
                            $infor = null, $foto = null, $estado = null){
        $this->info = array(
            'cod_info' => $codInfo,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'fecha' => $fecha,
            'info_ppal' => $info_ppal,
            'foto_ppal' => $foto_ppal,
            'info' => $infor,
            'foto' => $foto,
            'estado' => $estado);
    }

    //Funcion para devolver JSON de la info
    public function getInfo(){
        return \Response::json($this->info);
    }
}
