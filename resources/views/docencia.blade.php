@extends('plantilla')

@section('seccion')
    <h1>Docencia</h1>
    <h2>Esta es la docencia disponible</h2>

    @foreach($docencia as $item)
        <a href="{{ route('docencia',$item) }}" class="h4 text-danger">{{$item}}</a><br>
    @endforeach

    @if(!empty($nombre))
        @switch($nombre)
            @case($nombre=='ABD')
                <h3>E</h3>
            @case($nombre=='ED')
            @case($nombre=='MP')
        @endswitch
    @endif
@endsection
