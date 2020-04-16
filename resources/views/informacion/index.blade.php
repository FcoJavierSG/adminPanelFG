@extends('master')
@section('title', 'Información | FuturguideAR')
@section('seccion')
    <br>
    <h1 class="h2">Información</h1>
    <br>
    <h2 class="h3">Contenido</h2>
    <br>
    <form method="get" action="{{ url('informacion/create') }}">
        {{ csrf_field() }}
        {{ method_field('GET') }}
        <button type="submit" class="btn btn btn-secondary"> Nueva información </button>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#id</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Info. ppal.</th>
                <th>Foto ppal.</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($documentos as $info)
                <tr>
                    <td>{{$info->id()}}</td>
                    <td>{{$info['titulo']}}</td>
                    <td>{{$info['fecha']}}</td>
                    <td>{{$info['info_ppal']}}</td>
                    <td><img src="https://firebasestorage.googleapis.com/v0/b/futurguidear.appspot.com/o/{{$info['foto_ppal']}}?generation=1586550760215511&alt=media" width="150"></td>
                    <td>
                        <a href="{{ url('informacion/' . $info->id() . '/edit') }}" <button class="btn btn-sm btn-outline-secondary" >Editar</button></a>
                        <form method="post" action="{{ url('informacion/' . $info->id()) }}" style="float: right">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" onclick="return confirm('¿Estas seguro de que desea eliminar dicha entrada?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
