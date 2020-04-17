@extends('master')
@section('title', 'Añadir docencia | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de nueva docencia</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos obligatorios</h4>
                <form action="{{ url('docencia')}}" method="post" enctype="multipart/form-data" class="was-validated">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="docente">{{'Docente'}}</label>
                            <select class="custom-select form-control is-invalid" name="docente" id="docente" required>
                                <option value="">Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{$docente['dni']}}">
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
                                    <option value="{{$asignatura->id()}}" >{{$asignatura['siglas'] . ' | ' . $asignatura['nombre']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tipo">{{'Tipo'}}</label>
                            <select class="custom-select form-control is-invalid" name="tipo" id="tipo" required>
                                <option value="">Seleccione un tipo de docencia</option>
                                <option value="Teoría">Teoría</option>
                                <option value="Práctica">Práctica</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="aula">{{'Aula'}}</label>
                            <input type="number" class="form-control" name="aula" id="aula" min="1" max="50" placeholder="nº" value="" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="dia_semana">{{'Día de la semana'}}</label>
                            <select class="form-control" name="dia_semana" id="dia_semana" required>
                                <option value="">Seleccione un día de la semana</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                            </select>
                            <!--div- class="invalid-feedback">
                                    Rellene con información principal.
                            </div-->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_inicio">{{'Hora de inicio'}}</label>
                            <select class="form-control" name="hora_inicio" id="hora_inicio" required>
                                <option value="">Seleccione una hora de inicio</option>
                                <option value="15:30">15:30</option>
                                <option value="17:30">17:30</option>
                                <option value="19:30">19:30</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora_fin">{{'Hora de fin'}}</label>
                            <select class="form-control" name="hora_fin" id="hora_fin" required>
                                <option value="">Seleccione una hora de fin</option>
                                <option value="17:30">17:30</option>
                                <option value="19:30">19:30</option>
                                <option value="21:30">21:30</option>
                            </select>
                        </div>

                        <hr class="col-md-12 mb-2">
                        <button class="col-4 btn btn-danger" type="submit">Añadir docencia</button>
                        <hr class="mb-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



