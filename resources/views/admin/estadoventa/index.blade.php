@extends('layouts.app')

@section('title','Estado Venta')

@section('titulo-contenido','Estado Venta')

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
                <a href="{{ url('/estadoventa/create') }}" class="btn btn-warning btn-round">Nuevo Estado Venta</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableTiposEnvases">
                        <thead class=" text-primary">
                            <th class="text-left">
                                #Id
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Descripcion
                            </th>
                            <th>
                                Estado
                            </th>
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        <tbody>
                            @foreach( $estadosVentas as $estadosVenta )
                                <tr>
                                    <td>{{ $estadosVenta -> id }}</td>
                                    <td>{{ $estadosVenta -> nombre }}</td>
                                    <td>{{ $estadosVenta -> descripcion }}</td>
                                    <td>
                                        @if ( $estadosVenta -> estado == 'A' )
                                            Activo
                                        @else
                                            Inactivo
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <a href="{{ url('/estadoventa/'.$estadosVenta->id) }}" rel="tooltip" title="Ver Estado Venta{{ $estadosVenta -> nombre }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            <a href="{{ url('/estadoventa/'.$estadosVenta->id.'/edit') }}" rel="tooltip" title="Editar Estado Venta{{ $estadosVenta -> nombre }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class='btn btn-danger btn-simple btn-xs' rel="tooltip" title="Eliminar Estado Venta {{ $estadosVenta -> nombre }}" onclick="Delete('{{ $estadosVenta -> nombre }}','{{ $estadosVenta -> id }}')">
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
				title: 'Eliminar Estado de Venta',
				content: 'Seguro(a) que deseas eliminar el Estado de Venta ' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear el estado de venta',
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
            $('#tableTiposEnvases').DataTable({
                "language": {

                    "emptyTable": "No hay Estado de venta registrados , click en el boton <b>Nuevo Estado de venta</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Estados de venta   por Página",
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