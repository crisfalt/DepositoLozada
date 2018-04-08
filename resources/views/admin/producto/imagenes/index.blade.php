@extends('layouts.app')

@section('title','Imagenes Producto {{ $producto[0] -> nombre }}')

@section('titulo-contenido','Imagenes Producto {{ $producto[0] -> nombre }}')

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
                <h4 class="card-title"> Simple Table</h4>
            </div>
            {{-- <div class="card-body">
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
                                Cantidad
                            </th>
                            <th>
                                Cantidad En Reserva
                            </th>
                            <th>
                                Precio de Compra
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
                                    <td>{{ $producto -> cantidad }}</td>
                                    <td>{{ $producto -> cantidad_reserva }}</td>
                                    <td>{{ $producto -> precio_compra }}</td>
                                    {{-- <td>
                                        @if ( $marca -> estado == 'A' )
                                            Activo
                                        @else
                                            Inactivo
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <a href="{{ url('/producto/'.$producto->codigo) }}" rel="tooltip" title="Ver Producto {{ $producto -> nombre }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            <a href="{{ url('/producto/'.$producto->id.'/images') }}" rel="tooltip" title="Imágenes del producto {{ $producto -> nombre }}" class="btn btn-warning btn-simple btn-xs">
                                                <i class="fa fa-image"></i>
                                            </a>
                                            <a href="{{ url('/producto/'.$producto->codigo.'/edit') }}" rel="tooltip" title="Editar Producto {{ $producto -> nombre }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class='btn btn-danger btn-simple btn-xs' rel="tooltip" title="Eliminar Producto {{ $producto -> nombre }}" onclick="Delete('{{ $producto -> nombre }}','{{ $producto -> codigo }}')">
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
                </div>
            </div> --}}
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