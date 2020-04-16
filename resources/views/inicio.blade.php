@extends('master')
@section('title', 'Inicio | FuturguideAR')
@section('seccion')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <br>
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4 ">Bienvenido al Panel de administración de FuturGuideAR</h1>
            <p>En este panel podrá gestionar la información de la que dispondrá nuestra app de iOS FuturGuideAR.
                A continuación se detallan los contenido y funciones de las distintas vistas.</p>
        </div>
    </div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-4">
                <h2 class="font-weight-normal">Despacho</h2>
                <p>En la pestaña 'Despacho' se pueden visualizar y gestionar los distintos despachos de los docentes.
                   Entre las gestiones se incluyen la de crear, editar y eliminar despachos. Así mismo, para cada docente
                    puede gestionar la totalidad sus tutorias.
                </p>
                <p><a class="btn btn-secondary" href="{{ route('despacho.index') }}" role="button">Ir a Despacho &raquo;</a></p>
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-normal">Docencia</h2>
                <p>En la pestaña 'Docencias' se pueden visualizar y gestionar las distintas docencias de los docentes.
                    Es posible crear, editar y eliminar docencias.</p>
                <p><a class="btn btn-secondary" href="{{ route('docencia.index') }}" role="button">Ir a la vista de docencia &raquo;</a></p>
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-normal">Información</h2>
                <p>En la pestaña 'Informacion' se pueden visualizar y gestionar las distintos informaciones disponibles.
                    Además se pueden crear, editar y eliminar informaciones. </p>
                <p><a class="btn btn-secondary" href="{{ route('informacion.index') }}" role="button">Ir a la vista de información &raquo;</a></p>
            </div>
        </div>

        <hr>

    </div> <!-- /container -->

@endsection
