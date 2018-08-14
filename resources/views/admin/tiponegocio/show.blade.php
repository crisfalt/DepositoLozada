@extends('layouts.app')

@section('title','Tipo de Negocio')

@section('titulo-contenido','Tipo de Negocio')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            
            <div class="card-body">
                <div class="text-center">
                    <a href="#">
                        
                    <h5 class="title">{{ $tiposNegocio -> nombre }}</h5>
                    </a>
                    <p class="description">
                        @if ( $tiposNegocio -> estado == 'A' )
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                </div>
                <p class="description text-center">
                    {{ $tiposNegocio -> descripcion }}
                </p>
                <div class="text-center">
                    <a href="{{ url('/tiponegocio') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection