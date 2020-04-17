@extends('master')
@section('title', 'Editar docencia | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de edición</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos obligatorios</h4>
                <form action="{{ url('docencia/' . $documento->id()) }}" method="post" enctype="multipart/form-data" class="was-validated">
                    {{ csrf_field() }}
                    {{ method_field('PATCH')  }}
                    <input type="hidden" name="docID" id="docID" value="{{$documento->id()}}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="docente">{{'Docente'}}</label>
                            <select class="custom-select form-control is-invalid" name="docente" id="docente" required>
                                <option value="">Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{$docente['dni']}}" @if($documento['docente'] == $docente['dni']) {{('selected="selected"')}} @endif>
                                        {{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' . $docente['apellidos'][1] . ' (' . $docente['correo'] . ')'}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_asignatura">{{'Asignatura'}}</label>
                            <select class="custom-select form-control is-invalid" name="id_asignatura" id="id_asignatura" required>
                                <option value="">Seleccione una asignatura</option>
                                @foreach($asignaturas as $asignatura)
                                <option value="{{$asignatura->id()}}" @if($documento['id_asignatura'] == $asignatura->id()) {{('selected="selected"')}} @endif>{{$asignatura['siglas'] . ' | ' . $asignatura['nombre']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tipo">{{'Tipo'}}</label>
                            <select class="custom-select form-control is-invalid" name="tipo" id="tipo" required>
                                <option value="">Seleccione un tipo de docencia</option>
                                <option value="Teoría" @if($documento['tipo'] == 'Teoría') {{('selected="selected"')}} @endif>Teoría</option>
                                <option value="Práctica" @if($documento['tipo'] == 'Práctica') {{('selected="selected"')}} @endif>Práctica</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="aula">{{'Aula'}}</label>
                            <input type="number" class="form-control" name="aula" id="aula" min="1" max="50" placeholder="nº" value="{{$documento['aula']}}" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="dia_semana">{{'Día de la semana'}}</label>
                            <select class="custom-select form-control is-invalid" name="dia_semana" id="dia_semana" required>
                                <option value="">Seleccione un día de la semana</option>
                                <option value="Lunes" @if($documento['dia_semana'] == 'Lunes') {{('selected="selected"')}} @endif>Lunes</option>
                                <option value="Martes" @if($documento['dia_semana'] == 'Martes') {{('selected="selected"')}} @endif>Martes</option>
                                <option value="Miércoles" @if($documento['dia_semana'] == 'Miércoles') {{('selected="selected"')}} @endif>Miércoles</option>
                                <option value="Jueves" @if($documento['dia_semana'] == 'Jueves') {{('selected="selected"')}} @endif>Jueves</option>
                                <option value="Viernes" @if($documento['dia_semana'] == 'Viernes') {{('selected="selected"')}} @endif>Viernes</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_inicio">{{'Hora de inicio'}}</label>
                            <select class="custom-select form-control is-invalid" name="hora_inicio" id="hora_inicio" required>
                                <option value="">Seleccione una hora de inicio</option>
                                <option value="15:30" @if($documento['hora_inicio'] == '15:30') {{('selected="selected"')}} @endif>15:30</option>
                                <option value="17:30" @if($documento['hora_inicio'] == '17:30') {{('selected="selected"')}} @endif>17:30</option>
                                <option value="19:30" @if($documento['hora_inicio'] == '19:30') {{('selected="selected"')}} @endif>19:30</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_fin">{{'Hora de fin'}}</label>
                            <select class="custom-select form-control is-invalid" name="hora_fin" id="hora_fin" required>
                                <option value="">Seleccione una hora de fin</option>
                                <option value="17:30" @if($documento['hora_fin'] == '17:30') {{('selected="selected"')}} @endif>17:30</option>
                                <option value="19:30" @if($documento['hora_fin'] == '19:30') {{('selected="selected"')}} @endif>19:30</option>
                                <option value="21:30" @if($documento['hora_fin'] == '21:30') {{('selected="selected"')}} @endif>21:30</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <hr class="col-md-12 mb-2">
                        <button class="col-4 btn btn-danger" type="submit">Editar docencia</button>
                        <hr class="mb-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


