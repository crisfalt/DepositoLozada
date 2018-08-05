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
                        <h6 class="title">{{ $empleado -> tipoDocumento -> nombre }}</h6>
                        <h5 class="title text-danger">Numero de Identificacion</h5>
                        <h6 class="title">{{ $empleado -> number_id }}</h6>
                        <h5 class="title text-danger">Nombre del Empleado</h5>
                        <h6 class="title">{{ $empleado -> name }}</h6>
                        <h5 class="title text-danger">Direccion del Empleado</h5>
                        <h6 class="title">{{ $empleado -> address }}</h6>
                        @if( !empty($empleado->phone) )
                            <h5 class="title text-danger">Telefono del Empleado</h5>
                            <h6 class="title">{{ $empleado -> phone }}</h6>
                        @endif
                        @if( !empty($empleado->celular) )
                            <h5 class="title text-danger">Celular del Empleado</h5>
                            <h6 class="title">{{ $empleado -> celular }}</h6>
                        @endif
                        @if( !empty($empleado->email) )
                            <h5 class="title text-danger">Correo del Empleado</h5>
                            <h6 class="title">{{ $empleado -> email }}</h6>
                        @endif
                        <h5 class="title text-danger">Tipo de Perfil del Empleado</h5>
                        <h6 class="title">{{ $empleado -> perfil -> nombre }}</h6>
                        <h5 class="title text-danger">Estado</h5>
                        <p class="title">
                            @if ( $empleado -> estado == 'A' )
                                Activo
                            @else
                                Inactivo
                            @endif
                        </p>
                        <h5 class="title text-danger">Bodega a la cual pertenece el Empleado</h5>
                        <h6 class="title">{{ $empleado -> bodega -> nombre }}</h6>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/empleados') }}" class="btn btn-info btn-round"><i class="now-ui-icons arrows-1_minimal-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
