@extends('master')
@section('title', 'Insertar información | FuturguideAR')
@section('seccion')
    <div class="container">
        <div class="py-5 text-center">
            <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="72" height="72">
            <h2>Formulario de información</h2>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Datos</h4>
                <form action="{{ url('informacion') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="titulo">{{'Titulo'}}</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" value="" required>
                            <!--div class="invalid-feedback">
                                Introduzca un título válido.
                            </div-->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha">{{'Fecha'}}</label>
                            <input type="text" class="form-control" name="fecha" id="fecha" placeholder="" >
                            <!--div class="invalid-feedback">
                                Seleccione una fecha correcta.
                            </div-->
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="info_ppal">{{'Informacion principal'}}</label>
                        <input type="text" class="form-control" name="info_ppal" id="info_ppal" placeholder="" value="" required>
                        <!--div- class="invalid-feedback">
                                Rellene con información principal.
                        </div-->
                    </div>
                    <div class="mb-3">
                        <label for="foto_ppal">{{'Foto principal'}}</label>
                        <input type="file" class="form-control" name="foto_ppal" id="foto_ppal" placeholder="" >
                        <!--div class="invalid-feedback">
                                Seleccione una foto principal.
                        </div-->
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-danger" type="submit">Insertar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
