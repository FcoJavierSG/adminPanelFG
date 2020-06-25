@extends('master')
@section('title', 'Despacho | FuturguideAR')
@section('seccion')
    <br>
    <div class="py-3 container">
        <h1 class="h2">Despachos</h1>
        <br>
        <form method="get" action="{{ url('despacho/create') }}">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn btn-secondary"> Añadir despacho </button>
        </form>
    </div>
    <br>
    <div class="container table-responsive">
    @foreach($documentos as $despacho)
        <h3 class="h4"><span style="float: left; margin-right: 10px">{{'nº ' . $despacho['n_despacho'] }}</span>
            <a href="{{ route('qrcode', ['collection'=>'despacho', 'id'=>$despacho->id()]) }}" target="_blank"><button  class="btn btn-sm btn-secondary" style="float: left; margin-right: 5px"><span class="fa fa-qrcode"></span></button></a>
            <a href="{{ url('despacho/' . $despacho->id() . '/edit') }}"><button  class="btn btn-sm btn-secondary" style="float: left; margin-right: 5px"><span class="fa fa-edit"></span></button></a>
            <form method="post" action="{{ url('despacho/' . $despacho->id()) }}" style="float: left;">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" onclick="return confirm('¿Estas seguro de que desea eliminar dicho despacho?')" class="btn btn-sm btn-danger"><span class="fa fa-trash-alt"></span></button>
            </form>
        </h3>
        <br /><br />
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <!--th>#id</th-->
                <th>Departamento</th>
                <th>Docente</th>
                <th>Correo</th>
{{--                <th>1er Semestre</th>--}}
{{--                <th>2º Semestre</th>--}}
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($docentes as $docente)
                @if($docente['dni'] == $despacho['docente'][0])
                    <tr>
                        <td>{{$docente['departamento']}}</td>
                        <td>{{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' .$docente['apellidos'][1]}}</td>
                        <td>{{$docente['correo']}}</td>
{{--                        @foreach($tutorias as $tutoria)--}}
{{--                            @if($tutoria->exists())--}}
{{--                                @if($docente['dni'] == $tutoria['dni'] && $tutoria['semestre'] == 1)--}}
{{--                                        <td>{{$tutoria['dia_semana'] . ': ' . $tutoria['hora_inicio'] . '-' . $tutoria['hora_fin']}}</td>--}}
{{--                                @elseif($docente['dni'] == $tutoria['dni'] && $tutoria['semestre'] == 2)--}}
{{--                                        <td>{{$tutoria['dia_semana'] . ': ' . $tutoria['hora_inicio'] . '-' . $tutoria['hora_fin']}}</td>--}}
{{--                               --}}{{-- @elseif()--}}
{{--                                    <td>{{'No existe tutoria'}}</td>--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
                        <td style="text-align: right">
                            <a href="{{ url('tutoria/' . $docente->id() . '/edit') }}"><button  class="btn btn-sm btn-secondary">Gestionar tutorías</button></a>
                        </td>
                    </tr>
                @endif
                @if($docente['dni'] == $despacho['docente'][1])
                    <tr>
                        <td>{{$docente['departamento']}}</td>
                        <td>{{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' .$docente['apellidos'][1]}}</td>
                        <td>{{$docente['correo']}}</td>
                        <td style="text-align: right">
                            <a href="{{ url('tutoria/' . $docente->id() . '/edit') }}"><button  class="btn btn-sm btn-secondary">Gestionar tutorías</button></a>
                        </td>
                    </tr>
                @endif
                @if($docente['dni'] == $despacho['docente'][2])
                    <tr>
                        <td>{{$docente['departamento']}}</td>
                        <td>{{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' .$docente['apellidos'][1]}}</td>
                        <td>{{$docente['correo']}}</td>
                        <td style="text-align: right">
                            <a href="{{ url('tutoria/' . $docente->id() . '/edit') }}"><button  class="btn btn-sm btn-secondary">Gestionar tutorías</button></a>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <hr class="col-md-6 mb-4">
        @endforeach
    </div>
@endsection
