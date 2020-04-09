@extends('master')
@section('title', 'Editar información | FuturguideAR')
@section('seccion')

    {{var_dump($documento)}}

    @foreach ($documento as $document)

    {{var_dump($document->data())}}

    {{printf(PHP_EOL)}}


    @endforeach

@endsection

