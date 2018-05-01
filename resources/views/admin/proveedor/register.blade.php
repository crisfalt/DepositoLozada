@extends('layouts.app')

@section('title','DepositoLozada | Registrar')

@section('titulo-contenido','Registrar Proveedor')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Registrar Proveedor</h5>
            </div>
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
            <div class="card-body">
                <form method="POST" action="{{ route('proveedor') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="col-md-8 control-label">Nombre Completo</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Documento</label>
                                <select class="form-control" name="tipo_documento_id" required>
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tiposDocumento as $tipo )
                                            <option class="form-control" value="{{ $tipo->id }}" @if( $tipo -> id == old( 'tipo_documento_id') )  selected @endif>{{ $tipo->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="number_id" class="col-md-8 control-label">Numero Documento</label>
                                <input id="number_id" type="text" class="form-control" name="number_id" value="{{ old('number_id') }}" onkeypress="return solo_numeros(event)" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address" class="col-md-8 control-label">Direccion</label>
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone" class="col-md-8 control-label">Numero de Telefono</label>
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" onkeypress="return solo_numeros(event)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular" class="col-md-8 control-label">Numero de Celular</label>
                                <input id="celular" type="text" class="form-control" name="celular" value="{{ old('celular') }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="col-md-6 control-label">Correo Electronico</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electronico...">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')

    <script>
        //validar que se digite solo numeros
        function solo_numeros(e){
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        }
    </script>

@endsection
@endsection
