@extends('master')
@section('title', 'Editar información | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de edición</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos obligatorios</h4>
                <form action="{{ url('informacion/' . $documento->id()) }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    {{ method_field('PATCH')  }}
                    <input type="hidden" name="docID" id="docID" value="{{$documento->id()}}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="titulo">{{'Titulo'}}</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" value="{{$documento['titulo']}}" required>
                            <!--div class="invalid-feedback">
                                Introduzca un título válido.
                            </div-->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha">{{'Fecha'}}</label>
                            <input type="text" class="form-control" name="fecha" id="fecha" placeholder="" value="{{$documento['fecha']}}">
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="info_ppal">{{'Informacion principal'}}</label>
                            <input type="text" class="form-control" name="info_ppal" id="info_ppal" placeholder="" value="{{$documento['info_ppal']}}" required>
                            <!--div- class="invalid-feedback">
                                    Rellene con información principal.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tipo">{{'Tipo de información'}}</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option>Seleccione un tipo de información</option>
                                <option value="0" @if($documento['tipo'] == 0) {{('selected="selected"')}} @endif>Histórica</option>
                                <option value="1" @if($documento['tipo'] == 1) {{('selected="selected"')}} @endif>Campus</option>
                                <option value="2" @if($documento['tipo'] == 2) {{('selected="selected"')}} @endif>Evento</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="foto_ppal">{{'Foto principal'}}</label>
                            <br>
                            <img src="https://firebasestorage.googleapis.com/v0/b/futurguidear.appspot.com/o/{{$documento['foto_ppal']}}?generation=1586550760215511&alt=media" width="150">
                            <input type="file" class="form-control" name="foto_ppal" id="foto_ppal" placeholder="" value="{{$documento['foto_ppal']}}" >
                            <!--div class="invalid-feedback">
                                    Seleccione una foto principal.
                            </div-->
                        </div>
                        <!--div class="col-md-4 mb-3">
                            <label for="estado" >{{'Estado'}}</label>
                            <br>
                            <input type="checkbox" class="form-control" value="1" name="estado" id="estado" checked data-toggle="toggle" data-on="Público" data-off="Privado" data-onstyle="danger" >
                        </div-->
                        <hr class="col-md-12 mb-4">
                        <div class="col-md-12 mb-3">
                            <h4 class="h4">Opcional</h4>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="info">{{'Informacion adicional (opcional)'}}</label>
                            <textarea class="form-control" name="info" id="info" rows="2" placeholder="">{{$documento['info']}}</textarea>
                            <!--div- class="invalid-feedback">
                                    Rellene con información adic.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="foto">{{'Foto adicional (opcional)'}}</label>
                            <br>
                            <img src="https://firebasestorage.googleapis.com/v0/b/futurguidear.appspot.com/o/{{$documento['foto']}}?generation=1586550760215511&alt=media" width="150">
                            <input type="file" class="form-control" name="foto" id="foto" placeholder="" >
                            <!--div class="invalid-feedback">
                                    Seleccione una foto principal.
                            </div-->
                        </div>
                        <hr class="col-md-12 mb-2">
                        <button class="col-4 btn btn-danger" type="submit">Editar</button>
                        <hr class="mb-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

