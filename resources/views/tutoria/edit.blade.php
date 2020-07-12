@extends('master')
@section('title', 'Gestion de tutorías | FuturguideAR')
@section('seccion')
    <div class="container">
        <br>
        <h1 class="h2">{{'Tutorías de ' . $docente['nombre'] .' '. $docente['apellidos'][0] . ' '. $docente['apellidos'][1]}}</h1>
        <br>
        <form method="get" action="{{ url('tutoria/create') }}">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <input type="hidden" name="id" id="id" value="{{$docente->id()}}">
            <button type="submit" class="btn btn btn-secondary"> Añadir tutoría </button>
        </form>
        <br>
        <div class="row">
            @foreach($tutorias as $tutoria)
            <div class="col-md-12 order-md-1">
{{--                <h4 class="mb-3">{{'Semestre ' . $tutoria['semestre'].'º'}}</h4>--}}
                <form action="{{ url('tutoria/' . $tutoria->id()) }}" method="post" class="was-validated">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <input type="hidden" name="id" id="id" value="{{$docente->id()}}">
                    <input type="hidden" name="docID" id="docID" value="{{$tutoria->id()}}">
                    <input type="hidden" name="docente" id="docente" value="{{$docente['dni']}}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="semestre">{{'Semestre'}}</label>
                            <select class="custom-select form-control is-invalid" name="semestre" id="semestre" required>
                                <option value="">Seleccione un día de la semana</option>
                                <option value="1" @if($tutoria['semestre'] == '1') {{('selected="selected"')}} @endif >1er Semestre</option>
                                <option value="2" @if($tutoria['semestre'] == '2') {{('selected="selected"')}} @endif>2º Semestre</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="dia_semana">{{'Día de la semana'}}</label>
                            <select class="custom-select form-control is-invalid" name="dia_semana" id="dia_semana" required>
                                <option value="">Seleccione un día de la semana</option>
                                <option value="Lunes" @if($tutoria['dia_semana'] == 'Lunes') {{('selected="selected"')}} @endif>Lunes</option>
                                <option value="Martes" @if($tutoria['dia_semana'] == 'Martes') {{('selected="selected"')}} @endif>Martes</option>
                                <option value="Miércoles" @if($tutoria['dia_semana'] == 'Miércoles') {{('selected="selected"')}} @endif>Miércoles</option>
                                <option value="Jueves" @if($tutoria['dia_semana'] == 'Jueves') {{('selected="selected"')}} @endif>Jueves</option>
                                <option value="Viernes" @if($tutoria['dia_semana'] == 'Viernes') {{('selected="selected"')}} @endif>Viernes</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_inicio">{{'Hora inicio'}}</label>
                            <input type="text" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="Introduzca la hora con el formato 24h - hh:mm" value="{{$tutoria['hora_inicio']}}" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_fin">{{'Hora fin'}}</label>
                            <input type="text" class="form-control" name="hora_fin" id="hora_fin" placeholder="Introduzca la hora con el formato 24h - hh:mm" value="{{$tutoria['hora_fin']}}" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <hr class="col-md-3 mb-2">

                    </div>
                    <button class="btn btn-sm btn-secondary" type="submit" style="float: right;"><span class="fa fa-edit"></span></button>
                </form>
                <form class="col-1" method="post" action="{{ url('tutoria/' . $tutoria->id()) }}" style="float: right">
                    {{ csrf_field() }}
                    {{ method_field('DELETE')}}
                    <input type="hidden" name="borrar" id="borrar" value="borrar">
                    <button type="submit" onclick="return confirm('¿Estas seguro de que desea borrar dicha tutoría?')" class="btn btn-sm btn-danger" style="float: right"><span class="fa fa-trash-alt"></span></button>
                </form>
                <br>
                <br>
            </div>
            @endforeach
        </div>
    </div>
    @endsection
