@extends('layouts.app')

@section('title','Tipo de Contenido')

@section('titulo-contenido','Tipo de Contenido')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            {{-- <div class="image">
                <img src="../assets/img//bg5.jpg" alt="...">
            </div> --}}
            <div class="card-body">
                <div class="text-center">
                    <a href="#">
                        {{-- <img class="avatar border-gray" src="../assets/img//mike.jpg" alt="..."> --}}
                    <h5 class="title">{{ $tipoContenido -> nombre }}</h5>
                    </a>
                    <p class="description">
                        @if ( $tipoContenido -> estado == 'A' )
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                </div>
                <p class="description text-center">
                    {{ $tipoContenido -> descripcion }}
                </p>
                <div class="text-center">
                    <a href="{{ url('/tipocontenido') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection