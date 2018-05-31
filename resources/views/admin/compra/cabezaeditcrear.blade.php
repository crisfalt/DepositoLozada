@extends('layouts.app')

@section('title','Editar Compra')

@section('titulo-contenido','Editar Compra')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Editar Compra {{ $compras -> id }}</h5>
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
                <form method="post" action="{{ url('/compracabezacrear/'.'edit/'.$compras->id) }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Bodega</label>
                              <select class="form-control" name="bodega" id="bodega" >
                                   
                                     @foreach ( $bodegas as $bodega )
                                             
                                            <option class="form-control" value="{{ $bodega->id }}" @if( $bodega -> id == old( 'fk_bodega') )  selected @endif>{{ $bodega->nombre }}</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Forma Pago</label>
                                <select class="form-control" name="formapago" id="modopago" >
                                   @foreach ( $formaPagos as $formaPago )

                                            <option class="form-control" value="{{ $formaPago->id }}" @if( $formaPago -> id == old( 'fk_forma_pago') )  selected @endif>{{ $formaPago->nombre }}</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                 <label>Proveedor</label>
                              <select class="form-control" name="proveedor" id="modopago" >
                                   @foreach ( $Proveedors as $proveedor )

                                            <option class="form-control" value="{{ $proveedor->number_id }}" @if( $proveedor -> number_id == old( 'fk_proveeedors'))  selected @endif>{{ $proveedor->name }}</option>
                                     @endforeach
                                </select>
                                 
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning">Actualizar Compra</button>

                        <a href="{{ url('/compra/create') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection