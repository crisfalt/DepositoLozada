<!DOCTYPE html>
<html lang="es">
<!-- <html lang="{{ app()->getLocale() }}"> -->

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset( '/img/apple-icon.png' ) }}">
    <link rel="icon" type="image/png" href="{{ asset('/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', config('app.name'))</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/css/now-ui-dashboard.css?v=1.0.1')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('/demo/demo.css')}}" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
            <div class="logo">
                <a href="" class="simple-text logo-mini">
                    DL
                </a>
                <a href="" class="simple-text logo-normal">
                    Deposito Lozada
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <!-- <li class="active"> para que quede como activo -->
                    <li>
                        <a href="">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons files_single-copy-04"></i>
                            <p>Ventas</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons shopping_bag-16"></i>
                            <p>Compras</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Clientes</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons sport_user-run"></i>
                            <p>Proveedores</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons business_badge"></i>
                            <p>Empleados</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Inventarios</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons shopping_delivery-fast"></i>
                            <p>Rutas</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons business_chart-bar-32"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                            <p>Categorías</p>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                            <p>Configuración</p>
                        </a>
                    </li>
                    <li>
                    <a href="{{ route('tipomovimiento') }}">
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                            <p>Tipos de Mantenimiento</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="">
                            <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                            <p>Crisfalt Developer</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand">@yield('titulo-contenido','pagina')</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <!-- <form>
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </span>
                            </div>
                        </form> -->
                        <ul class="navbar-nav">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        Ingresar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        Registro
                                    </a>
                                </li>
                            @else 
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#pablo">
                                        <i class="now-ui-icons media-2_sound-wave"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">Stats</span>
                                        </p>
                                    </a>
                                </li> -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="now-ui-icons users_single-02"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">Mi Cuenta</span>
                                        </p>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                        <p class="dropdown-item">{{ Auth::user()->name }}</p>
                                        <a class="dropdown-item" href="#">Mi Perfil</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Mi Cuenta</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#pablo">
                                        <i class="now-ui-icons users_single-02"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">Account</span>
                                        </p>
                                    </a>
                                </li> -->
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <!-- yield del header es cambiante -->
            @yield('header-class')
            
            <div class="content">
                @yield('contenido')
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul>
                            <li>
                                <a href="#">
                                    Cristian Trujillo
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Acerca De
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Mis Proyectos
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, Diseñado Por
                        <a href="#" target="_blank">Cristian Trujillo</a>. Codificado Por
                        <a href="#" target="_blank">Cristian Trujillo</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

<!--   Core JS Files   -->
<script src="{{ asset('/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('/js/core/popper.min.js') }}"></script>
<script src="{{ asset('/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chart JS -->
<script src="{{ asset('/js/plugins/chartjs.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('/js/now-ui-dashboard.js?v=1.0.1') }}"></script>
<!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('/demo/demo.js') }}"></script>
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initGoogleMaps();
    });
</script>
@yield('scripts')

</html>