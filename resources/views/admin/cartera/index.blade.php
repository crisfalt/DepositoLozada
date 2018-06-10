@extends('layouts.app')

@section('title','Catera Clientes')

@section('titulo-contenido','Catera Clientes')

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
              <!--   {{-- <h4 class="card-title"> Simple Table</h4> --}} -->
                {{-- <a href="{{ url('/formapago/create') }}" class="btn btn-warning btn-round">Nueva Forma Pago</a> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCartera">
                        <thead class=" text-primary">
                            <th class="text-center">
                                Cedula
                            </th>
                            {{-- <th>
                                Cliente
                            </th> --}}
                            <th class="text-center">
                                    Total de ventas
                            </th>
                            <th class="text-center">
                               Total Por pagar
                            </th>
                         
                        </thead>
                        <tbody>
                               
                            @foreach( $facTuras as $facTura )
                        
                                <tr>
                                    <td class="text-center">{{$facTura -> fk_cliente}}</td>
                                    <td class="text-center">{{$facTura -> total}}</td>
                                    @if($facTura -> saldo==null)
                                    <td class="text-center">0</td>
                                    @else
                                    <td class="text-center">{{$facTura -> saldo}}</td>   
                                    @endif
                                   
                            
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

    {{-- metodo jquery para usar la libreria de confirmar para eliminar --}}
   
    <script>
        $(document).ready(function() {
            $('#tableCartera').DataTable({
                "language": {

                    "emptyTable": "No hay Carteras  , click en el boton <b>Buscar</b> con el numero de cedula nombre",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Catera por Página",
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