<nav class="navbar navbar-inverse" role="navigation">
    <!-- El logotipo y el icono que despliega el menú se agrupan para mostrarlos mejor en los dispositivos móviles -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target=".navbar-ex1-collapse">
            <span class="sr-only">Desplegar navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier otro elemento que se pueda ocultar al minimizar la barra -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <img id="logo" src="static/img/logo-freetech-solutions.png" class="Logo"/>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Grupos <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=ListGroup">Listado</a></li>
                    <li><a href="index.php?page=NewGroup">Alta</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Pines <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=NewPin">Alta</a></li>
                    <li><a href="index.php?page=ListPin">Listado</a></li>
                    <li class="divider"></li>
                    <!--<li><a href="index.php?page=ExportPin">Exportar</a></li>-->
                    <li><a href="views/Pin/UploadPin.php">Importar</a></li>
                    <!--<li class="divider"></li>
                    <li><a href="#">Acción #5</a></li> -->
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Destinos <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=NewDestiny">Alta</a></li>
                    <li><a href="index.php?page=ListDestiny">Listado</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Perfiles <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=NewProfile">Alta</a></li>
                    <li><a href="index.php?page=ListProfile">Listado</a></li>
                </ul>
            </li>
            <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Permisos <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=NewPermission">Alta</a></li>
                    <li><a href="index.php?page=ListPermission">Listado</a></li>
                </ul>
            </li>-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Reportes <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <!--<li><a href="#">A</a></li>
                    <li><a href="#">L</a></li>
                    <li><a href="#">Acción #4</a></li>
                    <li><a href="#">Acción #5</a></li>-->
                </ul>
            </li>
            <!--<li class="dropdown">
                <a  href="index.php?page=Logout" class="logout">
                    <span class="glyphicon glyphicon-off" placeholder="Salir"></span> Salir
                </a>
            </li>-->
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li id="logout" class="dropdown">
                <a href="controllers/Logout.php" class="logout">
                    <span class="glyphicon glyphicon-off" placeholder="Salir"></span> Salir
                </a>
            </li>
        </ul>
    </div>
</nav>