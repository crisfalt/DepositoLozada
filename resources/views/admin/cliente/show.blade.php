{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: crisfalt--}}
 {{--* Date: 30/05/2018--}}
 {{--* Time: 12:13 AM--}}
 {{--*/--}}

@extends('layouts.app')

@section('title','Clientes')

@section('styles')
    <style>
        .quarter {
            height: 400px;
            width: 400px;
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
                        <h5 class="title text-danger">Tipo de Identificacion</h5>
                        <h6 class="title">{{ $cliente -> nombre_tipo_documento}}</h6>
                        <h5 class="title text-danger">Tipo de Negocio</h5>
                        <h6 class="title">{{ $cliente -> tipoNegocio -> nombre}}</h6>
                        <h5 class="title text-danger">Nombre del Negocio</h5>
                        <h6 class="title">{{ $cliente -> nombre_negocio}}</h6>
                        <h5 class="title text-danger">Numero de Identificacion</h5>
                        <h6 class="title">{{ $cliente -> number_id }}</h6>
                        <h5 class="title text-danger">Nombre del Cliente</h5>
                        <h6 class="title">{{ $cliente -> name }}</h6>
                        <h5 class="title text-danger">Direccion del Cliente</h5>
                        <h6 class="title">{{ $cliente -> address }}</h6>
                        @if( !empty($cliente->phone) )
                            <h5 class="title text-danger">Telefono del Cliente</h5>
                            <h6 class="title">{{ $cliente -> phone }}</h6>
                        @endif
                        @if( !empty($cliente->celular) )
                            <h5 class="title text-danger">Celular del Cliente</h5>
                            <h6 class="title">{{ $cliente -> celular }}</h6>
                        @endif
                        @if( !empty($cliente->email) )
                            <h5 class="title text-danger">Correo del Cliente</h5>
                            <h6 class="title">{{ $cliente -> email }}</h6>
                        @endif
                        <h5 class="title text-danger">Valor de credito disponible</h5>
                        <h6 class="title">{{ $cliente -> valor_credito }}</h6>
                        <h5 class="title text-danger">Estado</h5>
                        <p class="title">
                            @if ( $cliente -> estado == 'A' )
                                Activo
                            @else
                                Inactivo
                            @endif
                        </p>
                        <h5 class="title text-danger">Bodega a la cual pertenece el Cliente</h5>
                        <h6 class="title">{{ $cliente -> bodega() -> nombre }}</h6>
                        <h5 class="title text-danger">Zona a la cual pertenece el Cliente</h5>
                        <h6 class="title">{{ $cliente -> ruta -> zona -> nombre }}</h6>
                        <h5 class="title text-danger">Ruta a la cual pertenece el Cliente</h5>
                        <h6 class="title">{{ $cliente -> ruta -> nombre }}</h6>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/cliente') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-user">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12">
                            @if( !empty($cliente -> url_foto) )
                                <img class="img-raised img-rounded" src="/imagenes/clientes/{{ $cliente -> url_foto }}" alt="" width="250" height="250">
                            @else
                                <img class="img-raised img-rounded" src="/imagenes/default.png" alt="" width="250" height="250">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
