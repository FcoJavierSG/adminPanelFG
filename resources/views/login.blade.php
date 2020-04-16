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

    <title> Login | FuturGuideAR </title>
</head>
<body>
<form method="post" action="{{ route('login') }}" class="form-signin">
    {{ csrf_field() }}
    <div class="text-center mb-4">
        <img class="mb-4" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="76" height="76">
        <h1 class="h3 mb-3 font-weight-normal">FuturGuideAR</h1>
        <h3 class="h5 mb-3 font-weight-normal">Panel de Administración</h3>
    </div>

    <div class="form-label-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <input type="email" name="email" id="email" class="form-control" placeholder="Correo de administrador" value="{{ old('email') }}" required autofocus>
        <label for="email">Correo de administrador</label>
        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-label-group" {{ $errors->has('password') ? 'has-error' : '' }}>
        <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
        <label for="password">Contraseña</label>
        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
    </div>
    <button class="btn btn-lg btn-danger btn-block" type="submit">Iniciar sesión</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2020</p>
</form>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/docs.min.js') !!}"></script>
</body>
</html>


