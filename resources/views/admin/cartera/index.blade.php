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
    <div class="col-md-6">
        <div class="card">
          
            <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cedula</label>
                                <input type="text" class="form-control" id="cc" name="cedula" value="{{ old('cedula') }}">
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="text-center">
                        <button class="btn btn-info">Consultar</button>
                        <a href="{{ url('/formapago') }}" class="btn btn-default">Cancelar</a>
                    </div>
               

            </div>
        </div>
    </div>

     <div class="col-md-6">
        <div class="card">
          
            <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                             <h3 class="text-center">Total Facturas</h3>
                            </div>
                        </div>
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <h3 class="text-center">$1.02560.0</h3>
                            </div>
                        </div>
                    </div>
             


            </div>
        </div>
    </div>
   
</div>
<div class="row">

     <div class="col-md-12">
        <div class="card">
          
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
                               Saldo
                            </th>
                            <th class="text-center">
                               Accion
                            </th>
                         
                        </thead>
                        <tbody>
                               
                            @foreach( $facTuras as $facTura )
                        
                                <tr>
                                    <td class="text-center">{{$facTura -> fk_cliente}}</td>
                                    
                                    @if($facTura -> saldo==null)
                                    <td class="text-center">0</td>
                                    @else
                                    <td class="text-center">{{$facTura -> saldo}}</td>   
                                    @endif
                                    <td class="text-center">Abonar</td>
                            
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

    <script type="text/javascript">
         function traerfacturas()
    {
        var idcedula = document.getElementById('cc').value;
        $("#fkVentas option").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/cartera/searchVenta"+idcedula,
                dataType: 'json',
                success: function( data ){
                    console.log(data);
                    $.each(data, function (key, ventas) {
                        $("#fkVentas").append("<option value=" + ventas.id + ">" + ventas.nombmuni + "</option>");
                    });
                }
            });

    }
    </script>


@endsection