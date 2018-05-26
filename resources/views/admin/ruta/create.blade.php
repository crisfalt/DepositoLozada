@extends('layouts.app')

@section('title','Rutas')

@section('titulo-contenido','Rutas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Crear Nueva Ruta</h5>
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
                <form method="post" action="{{ url('/ruta') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="zona_id" value="{{ $zona->id }}">
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
                        <button class="btn btn-warning">Registrar La Ruta</button>
                        <a href="{{ url('/zona/'.$zona->id.'/rutas') }}" class="btn btn-default">Cancelar</a>
                    </div>
                {{--</form>--}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="card card-user">
                <div class="text-center">
                    <h5 class="title">Dias de La Ruta</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="dias_almacenados" id="dias_almacenados" value="{{ old('dias_almacenados') }}">
                        <div class="input-field col s4">
                            <label>Dia de La Semana</label>
                            <select class="form-control sel" name="dia" id="dia">
                                <option class="form-control" value="I">Seleccione</option>
                                @foreach( $diasSemana as $dia )
                                    <option class="form-control" value={{ $dia  }}>{{ $dia  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s4">
                            <a title="Agregar Dia" onclick="agregarDia()" class="btn btn-info btn-floating btn-round"><i class="now-ui-icons ui-1_simple-add"></i></a>
                        </div>
                    </div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="col s8" id="lista_dias"  style="display: none;">
                            <table class="striped">
                                <thead>
                                <tr>
                                    <th>Dia</th>
                                </tr>
                                </thead>
                                <tbody id="registro_dia">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')

    <script>
        //cargar valores anteriores de los dias ya escogidos
        $( document ).ready(function() {
            var dias_almacenados=$('#dias_almacenados').val();
            var lista_dias=$('#lista_dias');
            var registro_dia=$('#registro_dia');
            if( dias_almacenados != "" ) {
                var arrayDias = dias_almacenados.split(",");
                lista_dias.show();
                for( var i = 0 ; i < arrayDias.length ; i++ ) {
                    registro_dia.append(
                        '<tr>'+
                        '<td>'+arrayDias[i]+'</td>'+
                        '</tr>'
                    );
                }
            }
        });

        function concatenar( array , nuevoDia ) {
            var auxiliar = "";
            for( var i = 0 ; i < array.length ; i++ ) {
                auxiliar += array[i] + ",";
            }
            auxiliar += nuevoDia;
            var retorno = new Array( auxiliar );
            console.log(retorno);
            return retorno;
        }

        function agregarDia()
        {
            var dia = $('#dia');
            var lista_dias=$('#lista_dias');
            var registro_dia=$('#registro_dia');
            var dias_almacenados=$('#dias_almacenados');
            var arrayDia=new Array();
            if( dias_almacenados.val() != "" ) {
                $('input[name^="dias_almacenados"]').each(function() {
                    arrayDia.push( $(this).val() );
                });
            }
            if (dia.val()=="")
            {
                alert('Debes seleccionar el dia antes de agregar!');
                dia.focus();
            }
            else
            {
                lista_dias.show();
                registro_dia.append(
                    '<tr>'+
                    '<td>'+dia.val()+'</td>'+
                    '</tr>'
                );
                arrayDia = concatenar(arrayDia,dia.val());
                // arrayDia.push( dia.val() ); //agrego numero al final del arreglo
                dias_almacenados.val( arrayDia );
                $('.sel').each(function(){
                    $('.sel option[value="'+dia.val()+'"]').remove();
                })
                console.log( arrayDia );
                dia.val('I');
            }
        }
    </script>

@endsection
@endsection

