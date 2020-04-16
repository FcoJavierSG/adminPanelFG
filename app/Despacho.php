<?php


namespace App;


class Despacho
{
    public $despacho;
    public $tutoria;


    public function setDespacho($docente = null, $info_despacho = null, $n_despacho = null){
        $this->despacho = array(
            'docente' => $docente,
            'info_despacho' => $info_despacho,
            'n_despacho' => $n_despacho);
    }

    public function setTutoria($docente = null, $semestre = null, $dia_semana = null, $hora_inicio = null, $hora_fin = null){
        $this->tutoria = array(
            'dni' => $docente,
            'semestre' => $semestre,
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin);
    }
}
