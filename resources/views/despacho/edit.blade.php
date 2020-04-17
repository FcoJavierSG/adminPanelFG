@extends('master')
@section('title', 'Editar despacho | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de edición</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos despacho</h4>
                <form action="{{ url('despacho/' . $documento->id()) }}" method="post" enctype="multipart/form-data" class="was-validated">
                    {{ csrf_field() }}
                    {{ method_field('PATCH')  }}
                    <input type="hidden" name="docID" id="docID" value="{{$documento->id()}}">
                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <label for="n_despacho">{{'Nº'}}</label>
                            <input type="number" class="form-control" name="n_despacho" id="n_despacho" min="1" max="50" placeholder="" value="{{$documento['n_despacho']}}" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-11 mb-3">
                            <label for="info_despacho">{{'Información'}}</label>
                            <input type="text" class="form-control" name="info_despacho" id="info_despacho" placeholder="Puede incluir aquí información sobre el despacho" value="{{$documento['info_despacho']}}">
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="1erDocente">{{'1er Docente'}}</label>
                            <select class="custom-select form-control is-invalid" name="1erDocente" id="1erDocente" required>
                                <option value="">Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{$docente['dni']}}" @if($documento['docente'][0] == $docente['dni']) {{('selected="selected"')}} @endif>
                                        {{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' . $docente['apellidos'][1] . ' (' . $docente['correo'] . ')'}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="2oDocente">{{'2º Docente (Opcional)'}}</label>
                            <select class="form-control" name="2oDocente" id="2oDocente" >
                                <option value="">Ningun docente seleccionado</option>
                                @foreach($docentes as $docente)
                                    <option value="{{$docente['dni']}}" @if($documento['docente'][1] == $docente['dni']) {{('selected="selected"')}} @endif>
                                        {{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' . $docente['apellidos'][1] . ' (' . $docente['correo'] . ')'}}</option>
                                @endforeach
                            </select>
                            <!--div class="invalid-feedback">
                                Introduzca un título válido.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="3erDocente">{{'3er Docente (Opcional)'}}</label>
                            <select class="form-control" name="3erDocente" id="3erDocente" >
                                <option value="">Ningun docente seleccionado</option>
                                @foreach($docentes as $docente)
                                    <option value="{{$docente['dni']}}" @if($documento['docente'][2] == $docente['dni']) {{('selected="selected"')}} @endif>
                                        {{$docente['nombre'] . ' ' . $docente['apellidos'][0] . ' ' . $docente['apellidos'][1] . ' (' . $docente['correo'] . ')'}}</option>
                                @endforeach
                            </select>
                            <!--div class="invalid-feedback">
                                Introduzca un título válido.
                            </div-->
                        </div>
                        <hr class="col-md-12 mb-2">
                        <button class="btn btn-block btn-danger" type="submit">Editar despacho</button>
                        <hr class="mb-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


