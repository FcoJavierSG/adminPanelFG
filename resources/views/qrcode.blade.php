<?php
session_start();
if (!isset($_SESSION['active']) || $_SESSION['active'] != true){
    header('Location:' . '/', true, 301);
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{!! asset('css/futurguide.css') !!}" >

    <title> Generador de QR | FuturGuideAR </title>
</head>
<body>

    <div class="form-signin text-center mb-4" style="margin-top: 300px">
        <img class="mb-4" src="{{$url}}" alt="" width="300" height="300">
        <button class="btn btn-lg btn-danger btn-block" type="button" onclick="window.print();return false;" />Imprimir código QR</button>
    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/docs.min.js') !!}"></script>
</body>
</html>


