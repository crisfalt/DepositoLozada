@extends('layouts.app')

@section('title','Venta')

@section('titulo-contenido','Venta')

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
                <a href="{{ url('/venta/0/create') }}" class="btn btn-warning btn-round">Nueva Venta</a>
            </div>
            <div class="card-body">
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
                                Saldo
                            </th>                            
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        <tbody>
                            @foreach( $ventas as $venta )
                                <tr>
                                        <td class="text-center">{{ $venta ->cliente()->name }}</td>
                                    <td class="text-center">{{ $venta -> id }}</td>
                                    @if($venta -> created_at !=null)
                                    <td class="text-center">{{ $venta -> created_at }}</td>

                                    @else
                                    <td class="text-center">sin fecha factura</td>
                                    @endif
                                    <td class="text-center">{{ $venta -> estadoventas()->nombre}}</td>  
                                    @if($venta->total != null ||$venta->total != "")                                           
                                    <td class="text-center">{{ $venta -> total }}</td>
                                    @else

                                    <td class="text-center">0</td>
                                    @endif
                                     @if($venta->saldo != null ||$venta->saldo != "")                                           
                                    <td class="text-center">{{ $venta -> saldo }}</td>
                                    @else
                                    
                                    <td class="text-center">0</td>
                                    @endif
                                    
                                    <td class="td-actions text-right">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
    
                                            <a href="{{ url('/venta/'.$venta->id) }}" rel="tooltip" title="Ver Venta{{ $venta -> id }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                           
                                           
                                            @if($venta->fk_estado_venta==1 || $venta->fk_estado_venta==2)
                                            <a href="{{ url('/venta/'.$venta->id.'/edit') }}" rel="tooltip" title="Editar Venta{{ $venta -> id }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif
                                            @if(    $venta->fk_estado_venta==1 || $venta->fk_estado_venta==2 && $venta->total==0  )
                                            <a class='btn btn-danger btn-simple btn-xs' rel="tooltip" title="Eliminar venta {{ $venta -> id }}" onclick="Delete('{{ $venta -> id }}','{{ $venta -> id }}')">
                                                    <i class='fa fa-times'></i>
                                            </a>
                                          
                                          @else

                                          <a href="{{ action('VentaController@imprimir',['id' => $venta -> id,'estado'=>0 ]) }}"  class="btn btn-danger btn-xs" target="_blank()">
                                          PDF</a>
                            
                                          @endif
                                          @if($venta->fk_estado_venta==2)
                                          <a href="{{ action('VentaController@imprimir',['id' => $venta -> id,'estado'=>3 ]) }}"  class="btn btn-success btn-xs" target="_blank()">PDF - Entregar</a>
                                          @endif


                                           
                                            <!-- <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                <i class="fa fa-times"></i>
                                            </button> -->
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

    {{-- metodo jquery para usar la libreria de confirmar para eliminar --}}
    <script>
        function Delete( nameProduct , idDel ) {
            var pathname = window.location.pathname; //ruta actual
			$.confirm({
				theme: 'supervan',
				title: 'Eliminar Venta',
				content: 'Seguro(a) que deseas eliminar Venta ' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear la Venta',
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