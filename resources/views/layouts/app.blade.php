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
    <!-- <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/css/now-ui-dashboard.css?v=1.0.1')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('/demo/demo.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-confirm.css') }}" />
    @yield('styles')
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar font-menu" data-color="red" data-image="https://pz-3-gatorwraps.netdna-ssl.com/wp-content/uploads/2015/08/sidebar-background-3-min.jpg">
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
                    @if( Auth::user() )
                        @if( Auth::user() -> perfil_id == 1 )
                            <li>
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="now-ui-icons design_app"></i>
                                    <p>alertas de entrega</p>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples">
                                    <i class="fa fa-database"></i>
                                    <p>Filtros Productos<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ route('marca') }}">
                                                <i class="now-ui-icons shopping_shop submenu"></i>
                                                <span class="sidebar-normal"> Marcas </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('sizebotella') }}">
                                                <i class="fa fa-glass submenu"></i>
                                                <span class="sidebar-normal"> Tamaño Envase </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('tipoenvase')}}">
                                                <i class="fa fa-flask submenu"></i>
                                                <span class="sidebar-normal"> Tipo Envase </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('tipocontenido')}}">
                                            <i class="fa fa-coffee submenu"></i>
                                                <span class="sidebar-normal glyphicon glyphicon-chevron-up">Tipo Contenido </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('tipopaca')}}">
                                                <i class="now-ui-icons design_app submenu"></i>
                                                <span class="sidebar-normal">Tipo Paca </span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples2">
                                    <i class="now-ui-icons travel_istanbul"></i>
                                    <p>Bodegas<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples2">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/bodega/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Crear Bodega </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('bodega') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Bodegas </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples3">
                                    <i class="fa fa-cubes shopping_box"></i>
                                    <p>Productos<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples3">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/producto/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Nuevo Producto </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producto') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Productos </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples9">
                                    <i class="fa fa-cubes shopping_box"></i>
                                    <p>Ventas<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples9">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/venta/0/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Nueva Venta </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('venta') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Ventas </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('abono') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Abonos Ventas </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples10">
                                    <i class="fa fa-cubes shopping_box"></i>
                                    <p>Compras<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples10">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/compra/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Nueva Compra </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('compra') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Compras </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('abonocompra') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Abonos compras </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples11">
                                    <i class="fa fa-cubes shopping_box"></i>
                                    <p>Cargues<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples11">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/cargue/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Nuevo Cargue </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('cargue') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Cargues </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/cargue/deldia') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Cargue del Dia </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples4">
                                    <i class="fa fa-users"></i>
                                    <p>Clientes<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples4">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/cliente/create') }}">
                                                <i class="fa fa-user-plus submenu"></i>
                                                <span class="sidebar-normal"> Nuevo Cliente </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('cliente') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Clientes </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples5">
                                    <i class="fa fa-user"></i>
                                    <p>Proveedores<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples5">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/proveedor/create') }}">
                                                <i class="fa fa-user-plus submenu"></i>
                                                <span class="sidebar-normal"> Nuevo Proveedor </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('proveedor') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Proveedores </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples6">
                                    <i class="fa fa-user-secret"></i>
                                    <p>Empleados<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples6">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/register') }}">
                                                <i class="fa fa-user-plus submenu"></i>
                                                <span class="sidebar-normal"> Registrar Empleado </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('empleados') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Listar Empleados </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/perfil/create') }}">
                                                <i class="fa fa-user-plus submenu"></i>
                                                <span class="sidebar-normal"> Registrar Perfil </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('perfil') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Listar Perfiles </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples7">
                                    <i class="fa fa-fax"></i>
                                    <p>Caja<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples7">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/caja/entrada') }}">
                                                <i class="fa fa-share submenu"></i>
                                                <span class="sidebar-normal"> Entrada </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/caja/salida') }}">
                                                <i class="fa fa-reply submenu"></i>
                                                <span class="sidebar-normal"> Salida </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/caja/closed') }}">
                                                <i class="fa fa-reply submenu"></i>
                                                <span class="sidebar-normal"> Cierre Caja </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/movimientocaja') }}">
                                                <i class="fa fa-line-chart submenu"></i>
                                                <span class="sidebar-normal"> Movimientos Cajas </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/caja/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Agregar Caja </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('caja') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Listar Cajas </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#componentsExamples8">
                                    <i class="fa fa-map"></i>
                                    <p>Zonas y Rutas<b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="componentsExamples8">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ url('/zona/create') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Registrar Zona de perico </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('zona') }}">
                                                <i class="fa fa-globe submenu"></i>
                                                <span class="sidebar-normal"> Ver Zonas </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('zona.vendedor.asignar_ruta') }}">
                                                <i class="fa fa-plus-square submenu"></i>
                                                <span class="sidebar-normal"> Asignar Vendedores </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/ruta/alls') }}">
                                                <i class="fa fa-road submenu"></i>
                                                <span class="sidebar-normal"> Ver Rutas </span>
                                            </a>
                                        </li>
                                        <!-- <li>
                                            <a href="#">
                                                <i class="fa fa-flag submenu"></i>
                                                <span class="sidebar-normal"> Reasignar Ruta </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/caja/create') }}">
                                                <i class="fa fa-reorder submenu"></i>
                                                <span class="sidebar-normal"> ReOrdenar Ruta </span>
                                            </a>
                                        </li>  -->

                                    </ul>
                                </div>
                            </li>
                            <li>
                            <a data-toggle="collapse" href="#componentsExamples17">
                                <i class="fa fa-cart-arrow-down"></i>
                                <p>Cartera<b class="caret"></b>
                                </p>
                            </a>
                                <div class="collapse" id="componentsExamples17">
                                    <ul class="nav">
                                        
                                        <li>
                                            <a href="{{ route('cartera') }}">
                                                <i class="fa fa-eye submenu"></i>
                                                <span class="sidebar-normal"> Ver Cartera </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
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
                                    <p>Configuración</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('formapago') }}">
                                    <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                    <p>Forma de Pago</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('descripcionprecio') }}">
                                    <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                    <p>Descripcion de Precio</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('descripcioniva') }}">
                                    <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                    <p>Descripcion de Iva</p>
                                </a>
                            </li>
                        @else
                            @if( Auth::user() -> perfil_id == 4 )
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
                            @else
                                <li>
                                    <a href="">
                                        <i class="now-ui-icons files_single-copy-04"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                                <li>
                                <a href="{{ url('/vendedor/producto') }}">
                                    <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                    <p>Productos</p>
                                </a>
                            </li>
                            @endif
                        @endif
                    @endif
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
                                <a href="www.jumpcorptechnology.net">
                                   Jump Corp Technology
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Contactenos
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Proyectos
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
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!-- Chart JS -->
<script src="{{ asset('/js/plugins/chartjs.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('/js/now-ui-dashboard.js?v=1.0.1') }}"></script>
<!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('/demo/demo.js') }}"></script>
<script src="{{ asset('/demo/jquery.sharrre.js') }}"></script>
<!-- plugin js para eliminar registros -->
<script src="{{ asset('/js/jquery-confirm.js') }}" type="text/javascript"></script>
<!-- LOS NUEVOS SCRIPTS -->
<script src="{{ asset('/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-selectpicker.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-switch.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('/js/plugins/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jasny-bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
<script src="{{ asset('/js/plugins/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jquery-jvectormap.js') }}"></script>
<script src="{{ asset('/js/plugins/nouislider.min.js') }}"></script>
<script src="{{ asset('/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('/js/plugins/sweetalert2.min.js') }}"></script>
 <!-- Google Maps Plugin   
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDS-rmXg8BxyY1KtI2N3s7h86kOhzZQvI8&callback=initMap"></script> -->
<!-- <script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initGoogleMaps();
    });
</script> -->
@yield('scripts')

</html>