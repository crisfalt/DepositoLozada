@extends('layouts.app')

@section('title','Tipos de Paca')

@section('titulo-contenido','Tipos de Paca')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Crear Nuevo Tipo de Paca</h5>
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
                <form method="post" action="{{ url('/tipopaca') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cantidad de unidades en la Paca</label>
                                <input type="number" step="0.01" class="form-control" name="cantidad" value="{{ old('cantidad') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Es Retornable ?</label>
                                <label class="radio-inline col-md-4">
                                    <input type="radio" name="retornable" value="SI" > SI
                                </label>
                                <label class="radio-inline col-md-4">
                                    <input type="radio" name="retornable" value="NO"> NO
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label id="lbl_precio">Precio de la Paca</label>
                                <input type="number" step="0.01" class="form-control" name="precio" id="precio" value="{{ old('precio',0) }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label id="lbl_precio_envase">Precio del Envase (unidad)</label>
                                <input type="number" step="0.01" class="form-control" name="precio_envase" id="precio_envase" value="{{ old('precio_envase',0) }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado">
                                    <option class="form-control" value="A">Activo</option>
                                    <option class="form-control" value="I">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">Registrar Tipo de Paca</button>
                        <a href="{{ url('/tipopaca') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    //validar que se digite solo numeros
    function solo_numeros(e){
        var key = window.Event ? e.which : e.keyCode 
        return ((key >= 48 && key <= 57) || (key==8)) 
    }

    $(document).ready(function () {
        //ocultar campos precio de paca
        $('#lbl_precio').hide();
        $('#precio').hide();
        $('#precio').val(0);
        //ocultar campos precio de envase
        $('#lbl_precio_envase').hide();
        $('#precio_envase').hide();
        $('#precio_envase').val(0);
        $('input:radio[name=retornable]').change(function () {
            if ($("input[name='retornable']:checked").val() == 'SI') {
                $('#lbl_precio').show();
                $('#precio').show();
                $('#lbl_precio_envase').show();
                $('#precio_envase').show();
            }
            if ($("input[name='retornable']:checked").val() == 'NO') {
                $('#lbl_precio').hide();
                $('#precio').hide();
                $('#precio').val(0);
                $('#lbl_precio_envase').hide();
                $('#precio_envase').hide();
                $('#precio_envase').val(0);
            }
        });
    });
</script>
@endsection