@extends('layouts.app')

@section('title','Cajas')

@section('titulo-contenido','Cajas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Entrada a Caja</h5>
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
                <form method="post" action="{{ url('/caja/entrada') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Caja</label>
                                <input type="text" class="form-control" name="caja" value="{{ old('caja', 1 ) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="text" class="form-control" name="fecha" value="{{ old('fecha', date('d-m-Y')) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripcion del movimiento</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Valor del Movimiento</label>
                                <input type="number" class="form-control" min="1000" name="valor" value="{{ old('valor') }}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="tipo_movimiento_id" value=1>
                    <div class="text-center">
                        <button class="btn btn-warning">Registrar Entrada</button>
                        <a href="{{ url('/caja') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection