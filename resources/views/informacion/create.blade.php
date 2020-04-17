@extends('master')
@section('title', 'Insertar información | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de nueva información</h2>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos obligatorios</h4>
                <form action="{{ url('informacion') }}" method="post" enctype="multipart/form-data" class="was-validated">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="titulo">{{'Titulo'}}</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Introduzca un título" value="" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha">{{'Fecha'}}</label>
                            <input type="text" class="form-control" name="fecha" id="fecha" placeholder="Utilize el formato 'día/mes/año' para introducir la fecha" required>
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="info_ppal">{{'Informacion principal'}}</label>
                            <input type="text" class="form-control" name="info_ppal" id="info_ppal" placeholder="Introduzca la informacíon principal de la entrada" value="" required>
                            <!--div- class="invalid-feedback">
                                    Rellene con información principal.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tipo">{{'Tipo de información'}}</label>
                            <select class="custom-select form-control is-invalid" name="tipo" id="tipo" required>
                                <option value="">Seleccione un tipo de información</option>
                                <option value="0">Histórica</option>
                                <option value="1">Campus</option>
                                <option value="2">Evento</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="foto_ppal">{{'Foto principal'}}</label>
                            <input type="file" class="form-control" name="foto_ppal" id="foto_ppal" placeholder="" required>
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
                            <textarea class="form-control" name="info" id="info" rows="2" placeholder="Aquí puede incluir información adicional para su entrada"></textarea>
                            <!--div- class="invalid-feedback">
                                    Rellene con información adic.
                            </div-->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="foto">{{'Foto adicional (opcional)'}}</label>
                            <input type="file" class="form-control" name="foto" id="foto" placeholder="" >
                            <!--div class="invalid-feedback">
                                    Seleccione una foto principal.
                            </div-->
                        </div>
                        <hr class="col-md-12 mb-4">
                        <button class="btn btn-block btn-danger" type="submit">Insertar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
