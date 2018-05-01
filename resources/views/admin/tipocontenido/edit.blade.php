@extends('layouts.app')

@section('title','Tipos de Envases')

@section('titulo-contenido','Tipos de Envases')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Editar Tipo de Contenido {{ $tipoContenido -> nombre }}</h5>
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
                <form method="post" action="{{ url('/tipocontenido/'.$tipoContenido->id.'/edit') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre' , $tipoContenido->nombre ) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion' , $tipoContenido->descripcion) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado">
                                @if( $tipoContenido->estado == 'A' and $tipoContenido->estado == old('estado',$tipoContenido->estado)  )
                                    <option class="form-control" value="A" selected>Activo</option>
                                    <option class="form-control" value="I">Inactivo</option>
                                @else
                                    <option class="form-control" value="A">Activo</option>            
                                    <option class="form-control" value="I" selected>Inactivo</option>
                                @endif    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">Actualizar Tipo de Contenido</button>
                        <a href="{{ url('/tipocontenido') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection