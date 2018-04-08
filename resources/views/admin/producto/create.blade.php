@extends('layouts.app')

@section('title','Productos')

@section('titulo-contenido','Productos')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Crear Nuevo Producto</h5>
            </div>
            <div class="card-body">
                <!-- Mostrar los errores capturados por validate -->
                @if ($errors->any())
                <div class="alert alert-warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{ url('/producto') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" class="form-control" name="codigo" value="{{ old('codigo') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="cantidad" value="{{ old('cantidad') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cantidad De Reserva</label>
                                <input type="number" class="form-control" name="cantidad_reserva" value="{{ old('cantidad_reserva') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Precio de Compra</label>
                                <input type="number" class="form-control" name="precio_compra" value="{{ old('precio_compra') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Marcas</label>
                                <select class="form-control" name="fk_marca">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $marcas as $marca )
                                            <option class="form-control" value="{{ $marca->id }}" @if( $marca -> id == old( 'fk_marca') )  selected @endif>{{ $marca->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tamaño del Producto</label>
                                <select class="form-control" name="fk_size">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $sizes as $size )
                                            <option class="form-control" value="{{ $size->id }}" @if( $size -> id == old( 'fk_size' ) )  selected @endif>{{ $size->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de Envase</label>
                                <select class="form-control" name="fk_tipo_envase">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tiposEnvase as $tipoEnvase )
                                            <option class="form-control" value="{{ $tipoEnvase->id }}" @if( $tipoEnvase -> id == old( 'fk_tipo_envase') )  selected @endif>{{ $tipoEnvase->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de Contenido</label>
                                <select class="form-control" name="fk_tipo_contenido">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tiposContenido as $tipoContenido )
                                            <option class="form-control" value="{{ $tipoContenido->id }}" @if( $tipoContenido -> id == old( 'fk_tipo_contenido') )  selected @endif>{{ $tipoContenido->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de Paca</label>
                                <select class="form-control" name="fk_tipo_paca">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tiposPaca as $tipoPaca )
                                            <option class="form-control" value="{{ $tipoPaca->id }}" @if( $tipoPaca -> id == old( 'fk_tipo_paca' ) )  selected @endif>{{ $tipoPaca->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bodega al Registrar el Producto</label>
                                <select class="form-control" name="fk_bodega">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $bodegas as $bodega )
                                            <option class="form-control" value="{{ $bodega->id }}" @if( $bodega -> id == old( 'fk_bodega') )  selected @endif>{{ $bodega->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado">
                                    <option class="form-control" value="A">Activo</option>
                                    <option class="form-control" value="I">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">Registrar Producto</button>
                        <a href="{{ url('/marca') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection