<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">
        <img class="" src="{!! asset('images/iconoFG-76.png') !!}" style="border-radius: 20px" alt="logo" width="75" height="75">
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('inicio') }}" class="list-group-item list-group-item-action bg-light" id="sidebarlink"><span class="fa fa-home"></span><br />Inicio</a>
        <a href="{{ route('despacho.index') }}" class="list-group-item list-group-item-action bg-light" id="sidebarlink"><span class="fa fa-building"></span><br />Despacho</a>
        <a href="{{ route('docencia.index') }}" class="list-group-item list-group-item-action bg-light" id="sidebarlink"><span class="fa fa-chalkboard-teacher"></span><br />Docencia</a>
        <a href="{{ route('informacion.index') }}" class="list-group-item list-group-item-action bg-light" id="sidebarlink"><span class="fa fa-info"></span><br />Información</a>
        <a href="{{ route('logout') }}" class=" list-group-item list-group-item-action bg-light" id="sidebarlink"><span class="fa fa-sign-out-alt"></span><br />Cerrar sesión</a>
    </div>
</div>
