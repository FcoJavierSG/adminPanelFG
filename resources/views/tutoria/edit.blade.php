@extends('master')
@section('title', 'Gestion de tutorías | FuturguideAR')
@section('seccion')
    <br>
    <h1 class="h2">{{'Tutorías de ' . $docente['nombre'] .' '. $docente['apellidos'][0] . ' '. $docente['apellidos'][1]}}</h1>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-md-1">
                @foreach($tutorias as $tutoria)
                <h4 class="mb-3">{{'Semestre ' . $tutoria['semestre'].'º'}}</h4>
                <form action="{{ url('tutoria/' . $tutoria->id()) }}" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <input type="hidden" name="docID" id="docID" value="{{$tutoria->id()}}">
                    <input type="hidden" name="dni" id="dni" value="{{$docente['dni']}}">
                    <input type="hidden" name="semestre" id="semestre" value="{{$tutoria['semestre']}}}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="dia_semana">{{'Día de la semana'}}</label>
                            <select class="form-control" name="dia_semana" id="dia_semana" required>
                                <option>Seleccione un día de la semana</option>
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
                        <button class="col-2 btn btn-secondary" type="submit">Editar</button>
                        <form method="post" action="{{ url('tutoria/' . $tutoria->id()) }}" style="float: right">
                            {{ csrf_field() }}
                            {{ method_field('PATCH')}}
                            <input type="hidden" name="borrar" id="borra" value="borrar">
                            <button type="submit" onclick="return confirm('¿Estas seguro de que desea borrar dicha tutoría?')" class="col-2 btn btn-danger">Borrar</button>
                        </form>
                        <hr class="mb-4">
                    </div>
                </form>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    @endsection
