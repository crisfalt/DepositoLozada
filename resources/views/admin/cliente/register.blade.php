@extends('layouts.app')

@section('title','DepositoLozada | Registrar')

@section('styles')
    <style>
        .quarter {
            height: 400px;
            width: 400px;
        }

        .rounded {
            height: 400px;
            width: 400px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
            background-size:cover;
        }

        .upload {
            width: 128px;
            height: 128px;
            background: url( {{ asset('img/cloud.png')}} );
            overflow: hidden;
            text-align: center;
            margin: auto;
        }


        .upload input {
            display: block !important;
            width: 128px !important;
            height: 128px !important;
            opacity: 0 !important;
            overflow: hidden !important;

        }



    </style>
@endsection

@section('titulo-contenido','Registrar Cliente')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Registrar Cliente</h5>
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
                <form method="POST" action="{{ route('cliente') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-md-8 control-label">Nombre Completo</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Negocio</label>
                                <select class="form-control" name="tipo_negocio">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tipoNegocio as $tiponegocio )
                                            <option class="form-control" value="{{ $tiponegocio->id }}" @if( $tiponegocio -> id == old( 'tiponegocio') )  selected @endif>{{ $tiponegocio->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Documento</label>
                                <select class="form-control" name="tipo_documento_id">
                                        <option class="form-control" value="I">Seleccione</option>
                                        @foreach ( $tiposDocumento as $tipo )
                                            <option class="form-control" value="{{ $tipo->id }}" @if( $tipo -> id == old( 'tipo_documento_id') )  selected @endif>{{ $tipo->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Negocio</label>
                                  <input id="namenegocio" type="text" class="form-control" name="namenegocio" value="{{ old('namenegocio') }}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="number_id" class="col-md-8 control-label">Numero Documento</label>
                                 <input id="number_id" type="text" class="form-control" name="number_id" value="{{ old('number_id') }}" onkeypress="return solo_numeros(event)" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="address" class="col-md-8 control-label">Direccion</label>
                                 <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>
                             </div>
                         </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="col-md-8 control-label">Numero de Telefono</label>
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celular" class="col-md-8 control-label">Numero de Celular</label>
                                <input id="celular" type="text" class="form-control" name="celular" value="{{ old('celular') }}" onkeypress="return solo_numeros(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="col-md-6 control-label">Correo Electronico</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electronico...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valor_credito" class="col-md-6 control-label">Valor Tope Para Credito</label>
                                <input id="valor_credito" type="number" class="form-control" name="valor_credito" min="0" max="10000000" onkeypress="return solo_numeros(event)" value="{{ old('valor_credito',0) }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bodega Perteneciente</label>
                                <select class="form-control" name="bodega_id">
                                    <option class="form-control" value="I" required>Seleccione</option>
                                    @foreach ( $bodegas as $bodega )
                                        <option class="form-control" value="{{ $bodega->id }}" @if( $bodega -> id == old( 'bodega_id') )  selected @endif>{{ $bodega->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ruta Para el Cliente</label>
                                <select class="form-control" name="ruta_id">
                                    <option class="form-control" value="I" required>Seleccione</option>
                                    @foreach ( $rutas as $ruta )
                                        <option class="form-control" value="{{ $ruta->id }}" @if( $ruta -> id == old( 'ruta_id') )  selected @endif>{{ $ruta->nombre }}</option>
                                    @endforeach
                                </select>
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
                {{--</form>--}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="card card-user">
                <div class="text-center">
                    <h5>Foto del Cliente</h5>
                </div>
                <div class="card-body">
                    <center><p>Seleccionar Imagen</p></center>

                    <div class="row text-center">
                        <div class="upload"><input type="file" class="form-control" title="Imagen a subir" name="photo" id="photo"></div>
                    </div>
                    <br>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- Aqui pone la imagen que sube -->
                                <img src="" alt="..." class="img quarter" id="image">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
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
        //codigo para mostrar una imagen y refrescar el campo
        function mostrarImagen(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#photo').on('change', function (e) {
            mostrarImagen(this);
        });
    </script>

@endsection
@endsection
