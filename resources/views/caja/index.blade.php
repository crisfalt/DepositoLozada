@extends('layouts.app')

@section('title','Cajas')

@section('titulo-contenido','Cajas')

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

    {{-- <div class="alert alert-info">
        <button type="button" aria-hidden="true" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span>{{ session('notification') }}</span>
    </div> --}}

    {{-- <div class="alert alert-success">
        <div class="container-fluid">
            <div class="alert-icon">
                <i class="material-icons">check</i>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
            </button>
            {{ session('notification') }}
        </div>
    </div> --}}
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{-- <h4 class="card-title"> Simple Table</h4> --}}
                <a href="{{ url('/caja/create') }}" class="btn btn-warning btn-round">Nueva Caja</a>
            </div>
            <div class="card-body">
                <table class="display nowrap" cellspacing="0" width="100%" id="tableTiposMovimientos">
                    <thead class=" text-primary">
                        <th class="text-left">
                            #Id
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Bodega
                        </th>
                        <th>
                            Estado
                        </th>
                        <th class="text-center">
                            Opciones
                        </th>
                    </thead>
                    <tbody>
                        @foreach( $Cajas as $caja )
                            <tr>
                                <td>{{ $caja -> id }}</td>
                                <td>{{ $caja -> nombre }}</td>
                                <td>{{ $caja -> bodega -> nombre }}</td>
                                <td>
                                    @if ( $caja -> estado == 'A' )
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td class="td-actions text-center">
                                    <form method="post" class="delete">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <a href="{{ url('/caja/'.$caja->id) }}" rel="tooltip" title="Ver caja {{ $caja -> nombre }}" class="btn btn-info btn-icon btn-xs">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href="{{ url('/caja/'.$caja->id.'/edit') }}" rel="tooltip" title="Editar caja {{ $caja -> nombre }}" class="btn btn-success btn-icon btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class='btn btn-danger btn-icon btn-xs' rel="tooltip" title="Eliminar caja {{ $caja -> nombre }}" onclick="Delete('{{ $caja -> nombre }}','{{ $caja -> id }}')">
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
				title: 'Eliminar Caja',
				content: 'Seguro(a) que deseas eliminar la caja' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear la caja',
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

                    "emptyTable": "No hay cajas registradas , click en el boton <b>Nueva caja</b> para agregar uno nueva",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ cajas por Página",
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