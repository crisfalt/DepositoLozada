{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: crisfalt--}}
 {{--* Date: 30/05/2018--}}
 {{--* Time: 12:13 AM--}}
 {{--*/--}}

@extends('layouts.app')

@section('title','Proveedores')

@section('styles')
    <style>
        .quarter {
            height: 400px;
            width: 400px;
        }

    </style>
@endsection

@section('titulo-contenido','Proveedores')

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
                        <h6 class="title">{{ $proveedor -> nombre_tipo_documento }}</h6>
                        <h5 class="title text-danger">Numero de Identificacion</h5>
                        <h6 class="title">{{ $proveedor -> number_id }}</h6>
                        <h5 class="title text-danger">Nombre del Proveedor</h5>
                        <h6 class="title">{{ $proveedor -> name }}</h6>
                        <h5 class="title text-danger">Direccion del Proveedor</h5>
                        <h6 class="title">{{ $proveedor -> address }}</h6>
                        @if( !empty($proveedor->phone) )
                            <h5 class="title text-danger">Telefono del Proveedor</h5>
                            <h6 class="title">{{ $proveedor -> phone }}</h6>
                        @endif
                        @if( !empty($proveedor->celular) )
                            <h5 class="title text-danger">Celular del Proveedor</h5>
                            <h6 class="title">{{ $proveedor -> celular }}</h6>
                        @endif
                        @if( !empty($proveedor->email) )
                            <h5 class="title text-danger">Correo del Proveedor</h5>
                            <h6 class="title">{{ $proveedor -> email }}</h6>
                        @endif
                        <h5 class="title text-danger">Estado</h5>
                        <p class="title">
                            @if ( $proveedor -> estado == 'A' )
                                Activo
                            @else
                                Inactivo
                            @endif
                        </p>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/proveedor') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
