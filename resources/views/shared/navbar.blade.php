
<nav class="navbar navbar-expand navbar-light border-bottom" id="navbar-wrapper">
    <a href="#" class="navbar-brand">FuturGuideAR <b class="h6 font-weight-light">Panel de administración</b></a>
    <button class="btn btn-secondary" id="menu-toggle"><span class="navbar-toggler-icon" ></span></button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="#"><span class="fa fa-user"></span>{{ ' ' . $_SESSION['email'] }}</a>
            </li>
        </ul>
    </div>
</nav>
