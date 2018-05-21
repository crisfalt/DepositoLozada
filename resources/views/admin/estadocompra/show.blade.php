@extends('layouts.app')

@section('title','Estado de Compra')

@section('titulo-contenido','Estado de Compra')

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
                    <h5 class="title">{{ $estadoCompras -> nombre }}</h5>
                    </a>
                    <p class="description">
                        @if ( $estadoCompras -> estado == 'A' )
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                </div>
                <p class="description text-center">
                    {{ $estadoCompras -> descripcion }}
                </p>
                <div class="text-center">
                    <a href="{{ url('/estadocompra') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection