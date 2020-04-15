<?php


namespace App;


class Docencia
{
    public $docencia;

    public function setDocencia($id_asignatura = null, $docente = null, $tipo = null, $aula = null, $dia_semana = null, $hora_inicio = null, $hora_fin = null){
        $this->docencia = array(
            'id_asignatura' => $id_asignatura,
            'docente' => $docente,
            'tipo' => $tipo,
            'aula' => $aula,
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin);
    }
}
