@extends('layouts.app')

@section('title','Imagenes Producto')

@section('styles')
    <style>
        .quarter {
			height: 400px;
			width: 400px;
		}
		/* estilo para que la imagen quede bien redonda */
		.rounded {
			height: 400px;
			width: 400px;
			-webkit-border-radius: 50%;
			-moz-border-radius: 50%;
			-ms-border-radius: 50%;
			-o-border-radius: 50%;
			border-radius: 50%;
			background-size:cover;
		}

        .upload {
            width: 128px;
            height: 128px;
            background: url( {{ asset('img/cloud.png')}} );
            overflow: hidden;
            text-align: center;
            margin: auto;
        }


        .upload input {
            display: block !important;
            width: 128px !important;
            height: 128px !important;
            opacity: 0 !important;
            overflow: hidden !important;
            
        }

        

    </style>
@endsection

@section('titulo-contenido','Imagenes Producto')

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
                <h4 class="card-title text-center">Imagenes del Producto {{ $producto->nombre }}</h4>
            </div>
            @if ($errors->any())
                <div class="alert alert-warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{-- <div class="row">
                            <div class="col-md-6"><label>Imagen a Subir</label></div>
                    </div> --}}
                    
                    <center><p>Seleccionar Imagen</p></center>

                    <div class="row text-center">
                        {{-- <div class="col-md-12">
                            <div class="form-group"> --}}
                                <div class="upload"><input type="file" class="form-control" title="Imagen a subir" accept=".jpg,.jpeg,.png" name="photo" id="photo"></div>
                            {{-- </div>
                        </div> --}}
                    </div>
                    <br>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="form-group">
                        <!-- Aqui pone la imagen que sube -->
                                <img src="" alt="..." class="img quarter" id="image">
                            </div>
                        </div>
                    </div>
                    <!-- <input type="hidden" id="txtPhoto" name="txtPhoto" value=""> -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-round">Subir Nueva Imagen</button>
                        <a href="{{ url('/producto') }}" class="btn btn-default btn-round">Volver al listado de productos</a>
                    </div>
                </form>
                <hr>
                <div class="row text-center">
                    @if ( count( $imagenes ) != 0 )
                        @foreach( $imagenes as $image )
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <!-- campo calculado en el modelo productimage metodo getUrlAttribute -->
                                    <img class="img-raised img-rounded" src="{{ $image -> url }}" alt="" width="250" height="250">
                                    <form method="post" action="">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="image_id" value="{{ $image -> id }}">
                                        <button type="submit" class="btn btn-danger btn-round">Eliminar Imagen</button>
                                        @if( $image -> featured == true )
                                            <button type="button" class="btn btn-warning btn-fab btn-fab-mini btn-round" rel="tooltip" title="Imagen destacada actualmente"><i class="now-ui-icons ui-2_favourite-28"></i></button>
                                        @else
                                            <a href="{{ url('/producto/'.$producto -> codigo.'/imagenes/select/'.$image -> id) }}" class="btn btn-info btn-fab btn-fab-mini btn-round" rel="tooltip" title="Imagen por destacar"><i class="now-ui-icons ui-2_favourite-28"></i></a>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <hr>
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

    <script>
        //codigo para mostrar una imagen y refrescar el campo
        function mostrarImagen(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#photo').on('change', function (e) {
            mostrarImagen(this);
        });
        
    </script>
@endsection