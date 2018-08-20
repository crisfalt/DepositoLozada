@extends('layouts.app')

@section('title','Mis Rutas')

@section('titulo-contenido','Mis Rutas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <!-- mostrar mensaje del controlador -->
    @if (session('notification'))

    <div class="alert alert-info alert-with-icon" data-notify="container">
        <button type="button" data-dismiss="alert" aria-label="Close" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span data-notify="icon" class="now-ui-icons ui-1_check"></span>
        <span data-notify="message">{{ session('notification') }}</span>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Mis rutas de hoy {{ Carbon\Carbon::now() }}</h3>
            </div>
            <div class="card-body">
                <table class="display nowrap" cellspacing="0" width="100%" id="tableTiposMovimientos">
                    <thead class=" text-primary">
                    <th class="text-left">
                        #Id
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Descripcion
                    </th>
                    <th>
                        Zona
                    </th>
                    <th>
                        Estado
                    </th>
                    <th class="text-center">
                        Opciones
                    </th>
                    </thead>
                    <tbody>
                    @foreach( $rutasHoy as $ruta )
                        <tr>
                            <td>{{ $ruta -> id }}</td>
                            <td>{{ $ruta -> nombre }}</td>
                            <td>{{ $ruta -> descripcion }}</td>
                            <td>{{ $ruta -> zona -> nombre }}</td>
                            <td>
                                @if ( $ruta -> estado == 'A' )
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td class="td-actions text-center">
                                <form method="post" class="delete">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <a href="{{ url('/vendedor/ruta/'.$ruta->id.'/map') }}" rel="tooltip" title="Mapa Ruta {{ $ruta -> nombre }}" class="btn btn-info btn-icon btn-xs">
                                        <i class="fa fa-location-arrow"></i>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#tableTiposMovimientos').DataTable({
                "language": {

                    "emptyTable": "No hay productos registrados , click en el boton <b>Nuevo Producto</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Productos por Página",
                    "zeroRecords": "No se encontro ningun resultado",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                },
                "responsive" : "true",
                "autoWidth": "true"
            });
        });
    </script>
@endsection