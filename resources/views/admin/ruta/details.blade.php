@extends('layouts.app')

@section('title','Rutas')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Rutas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
        </div>
        <div class="card-body">
            <form action="">
                
            </form>
        </div>
    </div>
</div> -->
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
                <h4 class="card-title text-center"> Clientes en la Ruta {{ $ruta -> nombre }}</h4>
            </div>
            <div class="card-body">
                <input type="hidden" id="ruta_id" name="ruta_id" value="{{ $ruta -> id }}">
                <table class="display nowrap" cellspacing="0" width="100%" id="tableTiposMovimientos">
                    <thead class=" text-primary">
                        <th class="text-left">
                            #Id
                        </th>
                        <th>
                            Orden
                        </th>
                        <th>
                            # Identificacion
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Direccion
                        </th>
                    </thead>
                    <tbody>
                        @if( $count > 0 )
                            @foreach( $ruta -> listaOrdenada() as $index=>$itemLista )
                                <tr id="{{ $index }}">
                                    <td>{{ $itemLista -> id }}</td>
                                    <td>{{ $itemLista -> orden }}</td>
                                    <td>{{ $itemLista -> cliente() -> number_id }}</td>
                                    <td>{{ $itemLista -> cliente() -> name }}</td>
                                    <td>{{ $itemLista -> cliente() -> address }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="result">Started dragging row 2.1</div>
                <div class="row justify-content-center">
                    <input type="submit" class="btn btn-warning" value="Guardar Cambios" onclick="guardarCambios()">
                    <a class="btn btn-info" href="{{ url('/ruta/alls') }}">Regresar</a>
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
    <!-- script tablas arrastables drap and drog -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>

    <script>
        function guardarCambios() {
            var filas = $("#tableTiposMovimientos tr").length;
            var columnas = $("#tableTiposMovimientos tr:last td").length;
            var arrayContenido = [];
            var ruta_id = $('#ruta_id').val();
            for (var i=1;i < filas; i++){
                var arrayFilas = [];
                for( var j = 0 ; j < columnas ; j++ ) {
                    arrayFilas.push(document.getElementById('tableTiposMovimientos').rows[ i ].cells[ j ].innerHTML);
                }
                arrayContenido.push( arrayFilas );
            }
            console.log( arrayContenido );
            //enviar datos a traves de json
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/ruta/reordenar",
                dataType: "json",
                data: {'array':JSON.stringify(arrayContenido),'ruta_id':ruta_id},
                success: function( msg ){
                    $.alert('' + msg.msg);
                }
            });  
        }

        function burbuja(miArray)
        {
            console.log(miArray);
            for(var i=1;i<miArray.length;i++)
            {
                for(var j=0;j<(miArray.length-i);j++)
                {
                    if(miArray[j]>miArray[j+1])
                    {
                        k=miArray[j+1];
                        miArray[j+1]=miArray[j];
                        miArray[j]=k;
                    }
                }
            }
            return miArray;
        }

        function reordenar( columnas ) {
            var listaOrdenada = burbuja( columnas );
            console.log(listaOrdenada);
            var contador = 0;
            for (var i=1;i < document.getElementById('tableTiposMovimientos').rows.length; i++){
                document.getElementById('tableTiposMovimientos').rows[ i ].cells[ 1 ].innerHTML = listaOrdenada[ contador ];
                contador++;
            } 
        }

        $(document).ready(function() {            
            $("#tableTiposMovimientos").tableDnD({
                onDragClass: "myDragClass",
                onDrop: function(table, row) {
                    var rows = table.tBodies[0].rows;
                    var debugStr = "Row dropped was "+row.id+". New order: ";
                    var columnas2 = [];
                    for (var i=0; i<rows.length; i++) {
                        debugStr += rows[i].id+" ";
                        columnas2[i] = $("#tableTiposMovimientos").find( '#'+rows[i].id ).find('td').eq(1).html();
                    }
                    reordenar( columnas2 );
                    $('.result').text(debugStr);
                },
                onDragStart: function(table, row) {
                    $('.result').text("Started dragging row "+row.id);
                    var columnas = $("#tableTiposMovimientos").find( '#'+row.id ).find('td').eq(1).html();
                    console.log( columnas );
                }
            });
            $('#tableTiposMovimientos').DataTable({
                "language": {

                    "emptyTable": "No hay rutas , click en el boton <b>Nueva Ruta</b> para agregar una nueva",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Rutas por Página",
                    "zeroRecords": "No se encontro ningun resultado",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                },
                "order": [[ 1, "asc" ]],
                //ocultar toda una columna de una tabla
                // "columnDefs": [
                //     { "visible": false, "targets": 2 }
                // ],
                "responsive" : "true",
                "autoWidth": "true"
            });
        });
    </script>
@endsection