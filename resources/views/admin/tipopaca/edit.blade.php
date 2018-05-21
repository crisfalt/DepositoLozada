@extends('layouts.app')

@section('title','Tipos de Pacas')

@section('titulo-contenido','Tipos de Pacas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Editar Tipo de Paca {{ $tipoPaca -> nombre }}</h5>
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
                <form method="post" action="{{ url('/tipopaca/'.$tipoPaca->id.'/edit') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre' , $tipoPaca->nombre ) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion' , $tipoPaca->descripcion) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cantidad de unidades en la Paca</label>
                                <input type="number" step="0.01" class="form-control" name="cantidad" value="{{ old('cantidad',$tipoPaca->cantidad) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Precio de la Paca</label>
                                <input type="number" step="0.01" class="form-control" name="precio" value="{{ old('precio',$tipoPaca->precio) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label id="lbl_precio_envase">Precio del Envase (unidad)</label>
                                <input type="number" step="0.01" class="form-control" name="precio_envase" id="precio_envase" value="{{ old('precio_envase',0) }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Es Retornable ?</label>
                                <label class="radio-inline col-md-4">
                                    <input type="radio" name="retornable" value="SI"> SI
                                </label>
                                <label class="radio-inline col-md-4">
                                    <input type="radio" name="retornable" value="NO"> NO
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado">
                                @if( $tipoPaca->estado == 'A' and $tipoPaca->estado == old('estado',$tipoPaca->estado)  )
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
                        <button class="btn btn-warning">Actualizar Tipo de Paca</button>
                        <a href="{{ url('/tipopaca') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection