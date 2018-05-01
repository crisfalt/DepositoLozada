@extends('layouts.app')

@section('title','Productos')

@section('titulo-contenido','Productos')

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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableTiposMovimientos">
                        <thead class=" text-primary">
                            <th class="text-left">
                                Codigo
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Cantidad Disponible en Inventario
                            </th>
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        <tbody>
                            @foreach( $Productos as $producto )
                                <tr>
                                    <td>{{ $producto -> codigo }}</td>
                                    <td>{{ $producto -> nombre }}</td>
                                    <td class="text-center">{{ $producto -> cantidad }}</td>
                                    {{-- <td>
                                        @if ( $marca -> estado == 'A' )
                                            Activo
                                        @else
                                            Inactivo
                                        @endif
                                    </td> --}}
                                    <td class="td-actions text-center">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <a href="{{ url('/vendedor/producto/'.$producto->codigo) }}" rel="tooltip" title="Ver Producto {{ $producto -> nombre }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
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
</div>
@endsection

@section('scripts')

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
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