@extends('layouts.app')

@section('title','Bodega')

@section('titulo-contenido','Bodega')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Editar Bodega {{ $bodega -> nombre }}</h5>
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
                <form method="post" action="{{ url('/bodega/'.$bodega->id.'/edit') }}">
                    {{ csrf_field() }}
                  
                     <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre' , $bodega->nombre) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" class="form-control" name="direccion" value="{{ old('direccion', $bodega->direccion) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono', $bodega->telefono) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Celular</label>
                                <input type="text" class="form-control" name="celular" value="{{ old('celular', $bodega->celular) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Municipio</label>
                                <select class="form-control" name="fk_municipio">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $municipios as $municipio )
                                  
                                        <option class="form-control" value="{{$municipio->id  }}" @if( $municipio -> id == old( 'fk_municipio',$bodega->fk_municipio) )  selected @endif>{{ $municipio->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">Actualizar bodega</button>
                        <a href="{{ url('/bodega') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection