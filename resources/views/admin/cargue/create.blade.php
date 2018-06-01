@extends('layouts.app')

@section('title','Cargues')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Cargues')

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
                <h4 class="card-title"> Cargue</h4>
                <!-- <a href="{{ url('/cliente/create') }}" class="btn btn-warning btn-round">Nuevo Cargue</a> -->
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h5 class="title text-center">{{ $diaActual }}</h5>
                </div>
                <div class="row">
                    <div class="col-md-6 text-right">
                        <button class="btn btn-round btn-warning" id="btn_filtrar">Buscar</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button class="btn btn-round btn-info" id="btn_guardar">Guardar Cargue</button>
                    </div>
                </div>
                <?php $contador = 0; $zonasRecorridas = array(); $recorri = false;?>
                @foreach( $zonasPorDia as $zona )
                    @if( $contador == 0 )
                        <?php array_push( $zonasRecorridas , $zona->id ); ?>
                        <?php $contador++; ?>
                    @else
                        @for( $i = 0 ; $i < count($zonasRecorridas) ; $i++ )
                            @if( $zonasRecorridas[ $i ] == $zona->id )
                                <?php $recorri=true;?>
                                @continue;
                            @endif
                        @endfor
                    @endif
                    @if( !$recorri )
                        <div class="text-center">
                            <h7 class="title text-center">Zona : {{ $zona->nombre  }}</h7>
                        </div>
                        <?php array_push( $zonasRecorridas , $zona->id );?>
                        @foreach( $zona->rutasDelDia($diaActual) as $ruta )
                            <div class="text-left">
                                <h7 class="title text-center">Ruta : {{ $ruta->ruta_nombre.' '.$ruta->ruta_id  }}</h7>
                            </div>
                            <?php $facturasDeRuta = $ruta->facturasPorRuta($ruta->ruta_id);?>
                            @if( count($facturasDeRuta) > 0 )
                                <table class="display nowrap" cellspacing="0" width="100%" id="">
                                    <thead class=" text-primary">
                                        <th class="text-left">
                                            Cliente
                                        </th>
                                        <th class="text-left">
                                            N°Venta
                                        </th>
                                        <th class="text-left">
                                            Fecha
                                        </th>
                                        <th class="text-left">
                                            Estado venta
                                        </th>
                                        <th class="text-left">
                                            Total
                                        </th>
                                        <th class="text-left">
                                            Accion
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach( $facturasDeRuta as $factura )
                                            <tr>
                                                <td>{{ $factura->name }}</td>
                                                <td>{{ $factura->factura_id }}</td>
                                                <td>{{ $factura->fecha_entrega }}</td>
                                                <td>{{ $factura->estadoVentas() -> nombre }}</td>
                                                <td>{{ $factura->total }}</td>
                                                <td>
                                                    <a href='/venta/{{ $factura->factura_id }}' rel='tooltip' title='Ver Venta' class='btn btn-info btn-icon btn-sm'><i class='fa fa-info'></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            @else
                                <div class="text-left">
                                    <h7 class="title text-center">No hay Ventas para esta Ruta</h7>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                    @endif
                    <?php $recorri=false; ?>
                @endforeach
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
        function llenar(response, index, value)
        {
            console.log(response);
            $('#tableTiposMovimientos').DataTable({
                "destroy": true,
                "data": response,
                "columns":[
                    {"data":"name"},
                    {"data":"factura_id"},
                    {"data":"fecha_entrega"},
                    {"data":"fk_estado_venta"},
                    {"data":"total"},
                    {
                        "data": "factura_id", "render": function (response) {
                            return "<a href='/venta/"+response+"' rel='tooltip' title='Ver Venta "+response+"' class='btn btn-info btn-icon btn-sm'><i class='fa fa-info'></i></a>";
                            // return "<a class='btn btn-success btn-sm boton-accion' href='#' ><i class='fa fa-search-minus'></i> </a><a class='btn btn-default btn-sm' style='margin-left:5px' href='#'><i class='fa fa-pencil'></i></a><a class='btn btn-danger btn-sm' style='margin-left:5px' onclick=Delete(" + response + ")><i class='fa fa-trash'></i></a>";
                        },
                        "orderable": false,
                        "searchable": false,
                        "width": "150px"
                    }
                ],
                "responsive": "true",
                "autoWidth": "true"
            });
        }

        $('#btn_guardar').click( function() {
            var filas = $("#tableTiposMovimientos tr").length;
            if( filas <= 1 ) { 
                $.alert( 'No hay un cargue generado' );
            }
            else {
                var fecha_inicio = $('#fecha_inicio').val();
                var fecha_final = $('#fecha_final').val();
                var fecha_actual = new Date().toJSON().slice(0,10); //obtener fecha actual javascript
                var filas = $("#tableTiposMovimientos tr").length;
                var venta_ids = [];
                for (var i=1;i < filas; i++){
                    venta_ids.push(document.getElementById('tableTiposMovimientos').rows[ i ].cells[ 1 ].innerHTML);
                }
                console.log(venta_ids);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/cargue/create/",
                    dataType: "json",
                    data : {'fecha_inicio':fecha_inicio , 'fecha_final':fecha_final , 'fecha_actual':fecha_actual,'ids_venta':venta_ids},
                    success: function( data ){
                        $.alert('' + data.msg);
                    }
                }); 
            }
        });

        $('#btn_filtrar').click( function() {
            var fecha_inicio = $('#fecha_inicio').val();
            var fecha_final = $('#fecha_final').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/cargue/filtrar/",
                dataType: "json",
                data : {'fecha_inicio':fecha_inicio , 'fecha_final':fecha_final},
                success: function( data ){
                    $.each(data, function(index, value){
                        llenar(data, index, value);
                        /*tablaDatos.append("<tr>");
                        tablaDatos.append("<td>"+response[index].nombre+"</td>");
                        tablaDatos.append("<td>"+response[index].codigo+"</td>");
                        tablaDatos.append("</tr>");*/
                    });
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });
        });
    </script>
    <script>
        function Delete( nameProduct , idDel ) {
            var pathname = window.location.pathname; //ruta actual
			$.confirm({
				theme: 'supervan',
				title: 'Eliminar cliente',
				content: 'Seguro(a) que deseas eliminar el cliente' + nameProduct + '. <br> Click Aceptar or Cancelar',
				icon: 'fa fa-question-circle',
				animation: 'scale',
				animationBounce: 2.5,
				closeAnimation: 'scale',
				opacity: 0.5,
				buttons: {
					'confirm': {
						text: 'Aceptar',
						btnClass: 'btn-blue',
						action: function () {
							$.confirm({
								theme: 'supervan',
								title: 'Estas Seguro ?',
								content: 'Una vez eliminado debes volver a crear el cliente',
								icon: 'fa fa-warning',
								animation: 'scale',
								animationBounce: 2.5,
								closeAnimation: 'zoom',
								buttons: {
									confirm: {
										text: 'Si, Estoy Seguro!',
										btnClass: 'btn-orange',
										action: function () {
                                            $('.delete').attr('action' , pathname + '/' + idDel );
											$('.delete').submit();
										}
									},
									cancel: {
										text: 'No, Cancelar',
										//$.alert('you clicked on <strong>cancel</strong>');
									}
								}
							});
						}
					},
					cancel: {
						text: 'Cancelar',
						//$.alert('you clicked on <strong>cancel</strong>');
					},
				}
			});
		}
    </script>
    <!-- <script>
        $(document).ready(function() {
            $('#tableTiposMovimientos').DataTable({
                "language": {

                    // "emptyTable": "No hay clientes registrados , click en el boton <b>Nuevo cliente</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ clientes por Página",
                    "zeroRecords": "No se encontro ningun resultado",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                },
                "responsive" : "true",
                "autoWidth": "true"
            });
        });
    </script> -->
@endsection