@extends('layouts.app')

@section('title','Cargue')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Cargue')

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
                <h4 class="card-title"> Cargue del dia <?php echo date("Y-m-d");?></h4>
                <!-- <a href="{{ url('/venta/create') }}" class="btn btn-warning btn-round">Nueva Venta</a> -->
            </div>
            <div class="card-body">
                @if( isset( $ventas ) )
                    <div class="table-responsive">
                        <table class="table" cellspacing="0" id="tableVentas">
                            <thead class=" text-primary">
                                <th class="text-center">
                                    Cliente
                                </th>
                                <th class="text-center">
                                    N°Venta
                                </th>
                                <th class="text-center">
                                    Fecha
                                </th>
                                <th class="text-center">
                                    Estado venta
                                </th>                            
                                <th class="text-center">
                                    Total
                                </th>                            
                                <th class="text-center">
                                    Opciones
                                </th>
                            </thead>
                            <tbody>
                                @foreach( $ventas as $venta )
                                    <tr>
                                            <td class="text-center">{{ $venta->name }}</td>
                                        <td class="text-center">{{ $venta -> venta_id }}</td>
                                        @if($venta -> fecha_entrega !=null)
                                        <td class="text-center">{{ $venta -> fecha_entrega }}</td>

                                        @else
                                        <td class="text-center">sin fecha factura</td>
                                        @endif
                                        <td class="text-center">{{ $venta -> fk_estado_venta }}</td>  
                                        @if($venta->total != null ||$venta->total != "")                                           
                                        <td class="text-center">{{ $venta -> total }}</td>
                                        @else
                                        <td class="text-center">0</td>
                                        @endif
                                        
                                        <td class="text-center">
                                            <!-- <form method="post" class="delete">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }} -->
        
                                                <a href="{{ url('/venta/'.$venta->venta_id) }}" rel="tooltip" title="Ver Venta{{ $venta -> venta_id }}" class="btn btn-info btn-icon btn-sm">
                                                    <i class="fa fa-info"></i>
                                                </a>
                                            
                                                @if($venta->fk_estado_venta==1 || $venta->fk_estado_venta==2)
                                                <a href="{{ url('/venta/'.$venta->venta_id.'/edit') }}" rel="tooltip" title="Editar Venta{{ $venta -> venta_id }}" class="btn btn-success btn-icon btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endif
                                                @if($venta->fk_estado_venta==1)
                                                <a class='btn btn-danger btn-icon btn-sm' rel="tooltip" title="Eliminar venta {{ $venta -> venta_id }}" onclick="Delete('{{ $venta -> venta_id }}','{{ $venta -> venta_id }}')">
                                                        <i class='fa fa-times'></i>
                                                </a>
                                            
                                            @else

                                            <a href="{{ action('VentaController@imprimir',['id' => $venta -> venta_id,'estado'=>0 ]) }}"  class="btn btn-danger btn-sm" target="_blank()">Imprimir</a>
                                
                                            @endif
                                            @if($venta->fk_estado_venta==2)
                                                <button class="btn btn-warning btn-sm" id="btn_entregado" onclick="cambiarEstado( {{ $venta->venta_id }} )">Entregado</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay Cargues Registrados para hoy Puedes crear tu cargue dando click en el boton <strong>Crear Cargue</strong></p>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ url('/cargue/create') }}"  class="btn btn-danger btn-xs">Crear Cargue</a>
                        </div>
                    </div>
                @endif    
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

    {{-- metodo jquery para usar la libreria de confirmar para eliminar --}}
    <script>
        function cambiarEstado( id ) {
            // alert(id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/venta/cambiaEstado/",
                dataType: "json",
                data : {'venta_id':id },
                success: function( data ){
                    $.confirm({
                        title: 'Confirmar',
                        content: data.msg,
                        buttons: {
                            confirm: function () {
                                location.reload();
                            }
                        }
                    });
                }
            }); 
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#tableVentas').DataTable({
                "language": {

                    "emptyTable": "No hay Ventas registrados , click en el boton <b>Nueva Venta</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Venta por Página",
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