@extends('layouts.app')

@section('title','Productos')

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

    </style>
@endsection

@section('titulo-contenido','Productos')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            {{-- <div class="image">
                <img src="../assets/img//bg5.jpg" alt="...">
            </div> --}}
            <div class="card-body">
                <div class="text-center">
                    <h5 class="title text-danger">Nombre</h5>
                    <h6 class="title">{{ $Producto -> nombre }}</h6>
                    <h5 class="title text-danger">Codigo</h5>
                    <h6 class="title">{{ $Producto -> codigo }}</h6>
                    <h5 class="title text-danger">Estado</h5>
                    <p class="title">
                        @if ( $Producto -> estado == 'A' )
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                    @if ( $Producto -> descripcion != "")
                        <h5 class="title text-danger">Descripcion</h5>
                        <p class="title text-center">
                            {{ $Producto -> descripcion }}
                        </p>
                    @endif
                    <h5 class="title text-danger">Precio de Compra</h5>
                    <p class="title text-center">
                        ${{ $Producto -> precio_compra }}
                    </p>
                    <h5 class="title text-danger">Cantidad En Stock</h5>
                    <p class="title text-center">
                        {{ $Producto -> cantidad }}
                    </p>
                    <h5 class="title text-danger">Cantidad Minima Stock</h5>
                    <p class="title text-center">
                        {{ $Producto -> cantidad_reserva }}
                    </p>
                    <h5 class="title text-danger">Marca</h5>
                    <p class="title text-center">
                        {{ $Producto -> marca -> nombre }}
                    </p>
                    <h5 class="title text-danger">Tamaño de Envasado</h5>
                    <p class="title text-center">
                        {{ $Producto -> size() -> nombre }}
                    </p>
                    <h5 class="title text-danger">Tipo de Envasado</h5>
                    <p class="title text-center">
                        {{ $Producto -> tipoEnvase() -> nombre }}
                    </p>
                    <h5 class="title text-danger">Tipo de Contenido</h5>
                    <p class="title text-center">
                        {{ $Producto -> tipoContenido -> nombre }}
                    </p>
                    <h5 class="title text-danger">Tipo de Empacado</h5>
                    <p class="title text-center">
                        {{ $Producto -> tipoPaca -> nombre }}
                    </p>
                    <h5 class="title text-danger">Bodega</h5>
                    <p class="title text-center">
                        {{ $Producto -> bodega() -> nombre }}
                    </p>
                </div>
                <div class="text-center">
                    <a href="{{ url('/producto') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
            <div class="card card-user">
                <div class="card-body">
                    @foreach ( $Producto -> imagenes() as $imagen )
                        <div class="row text-center">
                            <div class="col-md-12">
                                    <img class="img-raised img-rounded" src="{{ $imagen -> url }}" alt="" width="250" height="250">
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
</div>
@endsection