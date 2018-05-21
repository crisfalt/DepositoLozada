@extends('layouts.app')

@section('title','Tipo de Paca')

@section('titulo-contenido','Tipo de Paca')

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
                    <h5 class="title">{{ $tipoPaca -> nombre }}</h5>
                    </a>
                    <p class="description">
                        @if ( $tipoPaca -> estado == 'A' )
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                </div>
                <p class="description text-center">
                    {{ $tipoPaca -> descripcion }}
                </p>
                <p class="description text-center">
                    La paca tiene {{ $tipoPaca -> cantidad }} unidades
                </p>
                <p class="description text-center">
                    La paca tiene un valor de {{ $tipoPaca -> precio }}
                </p>
                <p class="description text-center">
                    El envase tiene un valor de {{ $tipoPaca -> precio_envase }}
                </p>
                <p class="description text-center">
                    @if ($tipoPaca -> retornable)
                        Es retornable
                    @else
                        No es retornable
                    @endif
                </p>
                <div class="text-center">
                    <a href="{{ url('/tipopaca') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection