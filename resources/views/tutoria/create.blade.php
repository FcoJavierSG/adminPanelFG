@extends('master')
@section('title', 'Gestion de tutorías | FuturguideAR')
@section('seccion')
    <br>
    <h1 class="h2">{{'Crear tutoría para ' . $docente['nombre'] .' '. $docente['apellidos'][0] . ' '. $docente['apellidos'][1]}}</h1>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-md-1">
                    <form action="{{ url('tutoria')}}" method="post" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="docente" id="docente" value="{{$docente['dni']}}">
                        <input type="hidden" name="id" id="id" value="{{$docente->id()}}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="semestre">{{'Semestre'}}</label>
                                <select class="form-control" name="semestre" id="semestre" required>
                                    <option>Seleccione un día de la semana</option>
                                    <option value="1">1er Semestre</option>
                                    <option value="2">2º Semestre</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dia_semana">{{'Día de la semana'}}</label>
                                <select class="form-control" name="dia_semana" id="dia_semana" required>
                                    <option>Seleccione un día de la semana</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="hora_inicio">{{'Hora inicio'}}</label>
                                <input type="text" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="Introduzca de la forma - hh:mm" value="" required>
                                <!--div class="invalid-feedback">
                                    Seleccione una fecha correcta.
                                </div-->
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="hora_fin">{{'Hora fin'}}</label>
                                <input type="text" class="form-control" name="hora_fin" id="hora_fin" placeholder="Introduzca de la forma - hh:mm" value="" required>
                                <!--div class="invalid-feedback">
                                    Seleccione una fecha correcta.
                                </div-->
                            </div>
                            <hr class="col-md-3 mb-2">
                            <button class="col-2 btn btn-secondary" type="submit">Añadir</button>
                            <hr class="mb-4">
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
