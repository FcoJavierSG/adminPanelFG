@extends('master')
@section('title', 'Información | FuturguideAR')
@section('seccion')

    <div class="container table-responsive">
        <br>
        <h1 class="h2">Información</h1>
        <br>
        <form method="get" action="{{ url('informacion/create') }}">
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn btn-secondary"> Añadir información </button>
        </form>
        <br>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <!--th>#id</th-->
                <th width="250">Título</th>
                <th>Fecha</th>
                <th width="500">Info. ppal.</th>
                <th>Foto ppal.</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($documentos as $info)
                <tr>
                    <!--td>{//$info->id()}}</td-->
                    <td>{{$info['titulo']}}</td>
                    <td>{{$info['fecha']}}</td>
                    <td>{{$info['info_ppal']}}</td>
                    <td><img src="https://firebasestorage.googleapis.com/v0/b/futurguidear.appspot.com/o/{{$info['foto_ppal']}}?generation=1586550760215511&alt=media" width="150"></td>
                    <td>
                        <form method="post" action="{{ url('informacion/' . $info->id()) }}" style="float: right">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" onclick="return confirm('¿Estas seguro de que desea eliminar dicha entrada?')" class="btn btn-sm btn-danger" style="float: right; margin-left: 5px"><span class="fa fa-trash-alt"></span></button>
                        </form>
                        <a href="{{ url('informacion/' . $info->id() . '/edit') }}"> <button class="btn btn-sm btn-secondary" style="float: right; margin-left: 5px"><span class="fa fa-edit"></span></button></a>
                        <a href="{{ route('qrcode', ['collection'=>'info_miscelanea', 'id'=>$info->id()]) }}" target="_blank"><button  class="btn btn-sm btn-secondary" style="float: right"><span class="fa fa-qrcode"></span></button></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
