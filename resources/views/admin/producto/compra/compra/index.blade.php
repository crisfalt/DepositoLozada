@extends('layouts.app')

@section('title','Compra')

@section('titulo-contenido','Compra')

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
                <a href="{{ url('/compra/create') }}" class="btn btn-warning btn-round">Nueva compra</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCompras">
                        <thead class=" text-primary">
                            
                            <th class="text-center">
                                N°compra
                            </th>
                            <th class="text-center">
                                Referencia compra
                            </th>
                            <th class="text-center">
                                    proveedor
                            </th>
                            <th class="text-center">
                                Fecha
                            </th>
                            <th class="text-center">
                                Est compra
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
                            @foreach( $compras as $compra )
                                <tr>
                                       
                                    <td class="text-center">{{ $compra -> id }}</td>
                                    <!-- ///////////////////numero de ferentecia -->
                                    @if($compra -> refcompra  !=null ||$compra->refcompra != "")
                                    <td class="text-center">{{ $compra -> refcompra  }}</td>
                                    @else
                                    <td class="text-center">sin numero de referencia</td>
                                    @endif




                                     <td class="text-center">{{ $compra ->proveedors()->name }}</td>
                                    @if($compra -> fecha_compra  !=null)
                                    
                                    <td class="text-center">{{ $compra ->fecha_compra}}</td>
                                    @else
                                    <td class="text-center">sin fecha factura</td>
                                    @endif
                                    
                                    <td class="text-center">{{ $compra -> estadoCompras()->nombre}}</td>  
                                    @if($compra->total != null ||$compra->total != "")                                           
                                    <td class="text-center">{{ $compra -> total }}</td>
                                    @else
                                    <td class="text-center">0</td>
                                    @endif

                                     @if($compra->saldo != null ||$compra->saldo != "")                                           
                                    <td class="text-center">{{ $compra -> saldo }}</td>
                                    @else
                                    <td class="text-center">0</td>
                                    @endif
                                    
                                    <td class="td-actions text-right">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <a href="{{ url('/compra/'.$compra->id) }}" rel="tooltip" title="Ver compra{{ $compra -> id }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                           
                                            @if($compra->fk_estado_compra==1 || $compra->fk_estado_compra==2)
                                            <a href="{{ url('/compra/'.$compra->id.'/edit') }}" rel="tooltip" title="Editar compra{{ $compra -> id }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif
                                            @if($compra->fk_estado_compra==1)
                                            <a class='btn btn-danger btn-simple btn-xs' rel="tooltip" title="Eliminar compra {{ $compra -> id }}" onclick="Delete('{{ $compra -> id }}','{{ $compra -> id }}')">
                                                    <i class='fa fa-times'></i>
                                            </a>
                                          
                                          @else

                                          <a href="{{ action('compraController@imprimir',['id' => $compra -> id,'estado'=>0 ]) }}"  class="btn btn-danger btn-xs" target="_blank()">PDF</a>
                            
                                          @endif
                                          @if($compra->fk_estado_compra==2)
                                          <a href="{{ action('compraController@imprimir',['id' => $compra -> id,'estado'=>3 ]) }}" class="btn btn-success btn-xs"  class="btn btn-info btn-round" target="_blank()">PDF - Recibido</a>
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

    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>

    {{-- metodo jquery para usar la libreria de confirmar para eliminar --}}
    <script>
        function Delete( nameProduct , idDel ) {
            var pathname = window.location; //ruta actual
			$.confirm({
				theme: 'supervan',
				title: 'Eliminar Compra',
				content: 'Seguro(a) que deseas eliminar compra ' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear la compra',
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
            $('#tableCompras').DataTable({
                "language": {

                    "emptyTable": "No hay compras registrados , click en el boton <b>Nuevo Estado de Compra</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ compra por Página",
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
