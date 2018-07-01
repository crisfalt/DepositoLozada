@extends('layouts.app')

@section('title','Rutas')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                <h5 class="title">Editar Ruta {{ $ruta -> nombre }}</h5>
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
                <form method="post" action="{{ url('/ruta/'.$ruta->id.'/edit') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="zona_id" value="{{ $ruta->zona->id }}">
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre' , $ruta->nombre ) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion' , $ruta->descripcion) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado">
                                @if( $ruta->estado == 'A' and $ruta->estado == old('estado',$ruta->estado)  )
                                    <option class="form-control" value="A" selected>Activo</option>
                                    <option class="form-control" value="I">Inactivo</option>
                                @else
                                    <option class="form-control" value="A">Activo</option>            
                                    <option class="form-control" value="I" selected>Inactivo</option>
                                @endif    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">Actualizar Ruta</button>
                        <a href="{{ url('/zona/'.$ruta -> zona-> id.'/rutas') }}" class="btn btn-default">Cancelar</a>
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
                        <div class="col s8" id="lista_dias">
                            <table class="striped" id="tableDias">
                                <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody id="registro_dia">
                                    @foreach( $ruta -> diasCargados() as $dia )
                                        <tr>
                                            <td>{{ $dia -> dia }}</td>
                                            <td>
                                                <a class='btn btn-danger btn-icon btn-sm' rel="tooltip" title="Eliminar Dia" onclick="Delete('{{ $dia -> dia }}','{{ $dia -> id  }}')">
                                                    <i class='fa fa-times'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
            var arrayJS = <?php echo json_encode($ruta -> diasCargados());?>;
            for( var i = 0 ; i < arrayJS.length ; i++ ) {
                $('.sel').each(function(){
                    console.log(arrayJS[ i ].dia);
                    $('.sel option[value="'+arrayJS[ i ].dia+'"]').remove();
                });
            }
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
                });
                console.log( arrayDia );
                dia.val('I');
            }
        }
        //funcion para eliminar un precio de la lista
        function Delete( nameDay , idDel ) {
            alert(idDel);
            var filasDias = $("#tableDias tr").length-1;//hay que restar 1 porque es el encabezado
            if( filasDias > 1 ) {
                var pathname = window.location.pathname; //ruta actual
                $.confirm({
                    theme: 'supervan',
                    title: 'Eliminar Precio O Iva',
                    content: 'Seguro(a) que deseas eliminar el dia ' + nameDay + '. <br> Click Aceptar or Cancelar',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    animationBounce: 2.5,
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Aceptar',
                            btnClass: 'btn-blue',
                            action: function () {
                                $.confirm({
                                    theme: 'supervan',
                                    title: 'Estas Seguro ?',
                                    content: 'Una vez eliminado debes volver a crear el dia',
                                    icon: 'fa fa-warning',
                                    animation: 'scale',
                                    animationBounce: 2.5,
                                    closeAnimation: 'zoom',
                                    buttons: {
                                        confirm: {
                                            text: 'Si, Estoy Seguro!',
                                            btnClass: 'btn-orange',
                                            action: function () {
                                                $.ajax({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type: "POST",
                                                    url: "/ruta/dia/eliminar",
                                                    dataType: "json",
                                                    data: {'id':idDel},
                                                    success: function( data ) {
                                                        if (data.status) {
                                                            $.confirm({
                                                                title: 'Confirmar!',
                                                                content: data.msg,
                                                                buttons: {
                                                                    'confirm': {
                                                                        text: 'Ok',
                                                                        btnClass: 'btn-orange',
                                                                        action: function () {
                                                                            location.reload();
                                                                        }
                                                                    },
                                                                }
                                                            });
                                                        }
                                                        else {
                                                            $.confirm({
                                                                title: 'Confirmar!',
                                                                content: data.msg,
                                                                buttons: {
                                                                    'confirm': {
                                                                        text: 'Ok',
                                                                        btnClass: 'btn-orange'
                                                                    },
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                                // $('.delete').attr('action' , pathname + '/' + idDel );
                                                // $('.delete').submit();
                                            }
                                        },
                                        cancel: {
                                            text: 'No, Cancelar',
                                            //$.alert('you clicked on <strong>cancel</strong>');
                                        }
                                    }
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancelar',
                            //$.alert('you clicked on <strong>cancel</strong>');
                        },
                    }
                });
            }
            else {
                $.alert({
                    title: 'Alerta!',
                    content: 'No pueden haber rutas sin al menos un dia de entrega',
                });
            }
        }
    </script>

@endsection
@endsection