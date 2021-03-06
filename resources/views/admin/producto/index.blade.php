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
            <div class="card-header">
                {{-- <h4 class="card-title"> Simple Table</h4> --}}
                <a href="{{ url('/producto/create') }}" class="btn btn-warning btn-round">Nuevo Producto</a>
            </div>                            
            <div class="card-body">
                <!-- <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"> -->
                    <table class="display nowrap" cellspacing="0" width="100%" id="tableTiposMovimientos">
                        <thead class=" text-primary">
                            <th class="text-left col-md-1">
                                Codigo
                            </th>
                            <th class="col-md-2">
                                Nombre
                            </th>
                            <th>
                                Cantidad
                            </th>
                            <th class="col-md-1">
                                Cantidad En Reserva
                            </th>
                            <th class="col-md-1">
                                Precio de Compra
                            </th>
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        <tbody>
                            @foreach( $Productos as $producto )
                                <tr>
                                    <td class="col-md-1">{{ $producto -> codigo }}</td>
                                    <td class="col-md-2">{{ $producto -> nombre }}</td>
                                    <td>{{ $producto -> cantidad }}</td>
                                    <td class="col-md-1">{{ $producto -> cantidad_reserva }}</td>
                                    <td class="col-md-1">{{ $producto -> precio_compra }}</td>
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
                                            <!-- <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm   btn-neutral  " data-original-title="" title="">
                                                <i class="now-ui-icons users_single-02"></i>
                                            </button> -->
                                            <a href="{{ url('/producto/'.$producto->codigo) }}" rel="tooltip" title="Ver Producto {{ $producto -> nombre }}" class="btn btn-info btn-icon btn-sm">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            <a href="{{ url('/producto/'.$producto->codigo.'/imagenes') }}" rel="tooltip" title="Imágenes del producto {{ $producto -> nombre }}" class="btn btn-warning btn-icon btn-sm">
                                                <i class="fa fa-image"></i>
                                            </a>
                                            <a href="{{ url('/producto/'.$producto->codigo.'/edit') }}" rel="tooltip" title="Editar Producto {{ $producto -> nombre }}" class="btn btn-success btn-icon btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class='btn btn-danger btn-icon btn-sm' rel="tooltip" title="Eliminar Producto {{ $producto -> nombre }}" onclick="Delete('{{ $producto -> nombre }}','{{ $producto -> codigo }}')">
                                                <i class='fa fa-times'></i>
                                            </a>
                                            <!-- <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                <i class="fa fa-times"></i>
                                            </button> -->
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- </div> -->
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
				title: 'Eliminar Producto',
				content: 'Seguro(a) que deseas eliminar el producto' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear el producto',
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
