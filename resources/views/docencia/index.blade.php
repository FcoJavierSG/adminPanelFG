@extends('master')
@section('title', 'Docencia | FuturguideAR')
@section('seccion')
    <br>
    <h1 class="h2">Docencia</h1>
    <br>
    <h2 class="h3">Contenido</h2>
    <br>
    <form method="get" action="{{ url('docencia/create') }}">
        {{ csrf_field() }}
        {{ method_field('GET') }}
        <button type="submit" class="btn btn btn-danger"> Añadir docencia </button>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <!--th>#id</th-->
                <th>Titulación</th>
                <th>Asignatura</th>
                <th>Curso</th>
                <th>Semestre</th>
                <th>Docente</th>
                <th>Aula</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Tipo</th>
                <th>Acciones</th>
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
                    <td>{{$docencia['hora_inicio'] . '-' . $docencia['hora_fin']}}</td>>
                    <td>{{$docencia['tipo']}}</td>
                    <td>
                        <a href="{{ url('docencia/' . $docencia->id() . '/edit') }}" class="btn btn-sm">Editar</a>
                        <form method="post" action="{{ url('docencia/' . $docencia->id()) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" onclick="return confirm('¿Estas seguro de que desea eliminar dicha entrada?')" class="btn btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
