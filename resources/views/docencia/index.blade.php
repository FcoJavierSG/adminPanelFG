@extends('master')
@section('title', 'Docencia | FuturguideAR')
@section('seccion')
    <br>
    <h1 class="h2">Docencia</h1>
    <br>
    <form method="get" action="{{ url('docencia/create') }}">
        {{ csrf_field() }}
        {{ method_field('GET') }}
        <button type="submit" class="btn btn-secondary"> Añadir docencia </button>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Titulación</th>
                <th>Asignatura</th>
                <th>Curso</th>
                <th>Semestre</th>
                <th>Docente</th>
                <th>Aula</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Tipo</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($documentos as $docencia)
                <tr>
                    @foreach($asignaturas as $asignatura)
                        @if($asignatura->id() == $docencia['id_asignatura'])
                            <td>{{$asignatura['titulacion']}}</td>
                            <td>{{$asignatura['siglas'] . ' | ' . $asignatura['nombre']}}</td>
                            <td>{{$asignatura['curso']}}</td>
                            <td>{{$asignatura['semestre']}}</td>
                        @endif
                    @endforeach
                    @foreach($docentes as $docente)
                            @if($docente['dni'] == $docencia['docente'])
                                <td>{{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' .$docente['apellidos'][1] . ' (' . $docente['correo'] . ')'}}</td>
                            @endif
                        @endforeach
                    <td>{{$docencia['aula']}}</td>
                    <td>{{$docencia['dia_semana']}}</td>
                    <td>{{$docencia['hora_inicio'] . '-' . $docencia['hora_fin']}}</td>
                    <td>{{$docencia['tipo']}}</td>
                    <td>
                        <form method="post" action="{{ url('docencia/' . $docencia->id()) }}" style="float: right">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" onclick="return confirm('¿Estas seguro de que desea eliminar dicha entrada?')" class="btn btn-sm btn-danger" style="float: right; margin-left: 5px"><span class="fa fa-trash-alt"></span></button>
                        </form>
                        <a href="{{ url('docencia/' . $docencia->id() . '/edit') }}" ><button class="btn btn-sm btn-secondary" style="float: right; margin-left: 5px"><span class="fa fa-edit"></span></button></a>
                        <a href="{{ route('qrcode', ['collection'=>'aula', 'id'=>$docencia['aula']]) }}" target="_blank"><button  class="btn btn-sm btn-secondary" style="float: right;"><span class="fa fa-qrcode"></span></button></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
