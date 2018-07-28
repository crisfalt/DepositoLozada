@extends('layouts.app')

@section('title','Tipos de Pacas')

@section('titulo-contenido','Tipos de Pacas')

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
                <a href="{{ url('/tipopaca/create') }}" class="btn btn-warning btn-round">Nuevo Tipo de Paca</a>
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
                            Descripcion
                        </th>
                        <th>
                            Cantidad
                        </th>
                        <th>
                            Precio Canasta
                        </th>
                        <th>
                            Precio Envase
                        </th>
                        <th>
                            Retornable
                        </th>
                        <th>
                            Estado
                        </th>
                        <th class="text-center">
                            Opciones
                        </th>
                    </thead>
                    <tbody>
                        @foreach( $tiposPacas as $tipoPaca )
                            <tr>
                                <td>{{ $tipoPaca -> id }}</td>
                                <td>{{ $tipoPaca -> nombre }}</td>
                                <td>{{ $tipoPaca -> descripcion }}</td>
                                <td>{{ $tipoPaca -> cantidad }}</td>
                                <td>{{ $tipoPaca -> precio }}</td>
                                <td>{{ $tipoPaca -> precio_envase }}</td>
                                <td>
                                    @if ( $tipoPaca -> retornable == '1')
                                        SI
                                    @else
                                        NO
                                    @endif
                                </td>
                                <td>
                                    @if ( $tipoPaca -> estado == 'A' )
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td class="td-actions text-right">
                                    <form method="post" class="delete">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <a href="{{ url('/tipopaca/'.$tipoPaca->id) }}" rel="tooltip" title="Ver Tipo Paca {{ $tipoPaca -> nombre }}" class="btn btn-info btn-icon btn-xs">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href="{{ url('/tipopaca/'.$tipoPaca->id.'/edit') }}" rel="tooltip" title="Editar Tipo Paca {{ $tipoPaca -> nombre }}" class="btn btn-success btn-icon btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class='btn btn-danger btn-icon btn-xs' rel="tooltip" title="Eliminar Tipo Contenido {{ $tipoPaca -> nombre }}" onclick="Delete('{{ $tipoPaca -> nombre }}','{{ $tipoPaca -> id }}')">
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

    {{-- metodo jquery para usar la libreria de confirmar para eliminar --}}
    <script>
        function Delete( nameProduct , idDel ) {
            var pathname = window.location.pathname; //ruta actual
			$.confirm({
				theme: 'supervan',
				title: 'Eliminar Tipo de Contenido',
				content: 'Seguro(a) que deseas eliminar el tipo de Paca ' + nameProduct + '. <br> Click Aceptar or Cancelar',
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
								content: 'Una vez eliminado debes volver a crear el tipo de paca',
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

                    "emptyTable": "No hay tipos de contenido pacas , click en el boton <b>Nuevo Tipo de Paca</b> para agregar uno nuevo",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "previous": "Anterior",
                        "next": "Siguiente",
                    },
                    "search": "Buscar: ",
                    "info": "Mostrando del _START_ al _END_, de un total de _TOTAL_ entradas",
                    "lengthMenu": "Mostrar _MENU_ Tipos de Pacas por Página",
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