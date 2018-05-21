@extends('layouts.app')

@section('title','DepositoLozada | DashBoard')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido' , 'Bienvenido')

@section('header-class')
<div class="panel-header">
    <canvas id="bigDashboardChart"></canvas>
</div>
@endsection

@section('contenido')

    <form action="">
        <input type="hidden" name="nombre" id="nombre" value="{{ Auth::user() -> name }}">
    </form>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var perfil = {{ Auth::user() -> perfil_id }};
        if( perfil  == 4 ) { //si es un cajero
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: '/caja/cajas',
                success: function (data) {
                    if( data.success ) {
                        console.log('asignar caja');
                        crearDialogo( data.Cajas );
                    }
                    else {
                        console.log('ya tiene caja');
                        $.confirm({
                            title: 'Confirmar',
                            content: data.msg,
                            buttons: {
                                'confirm': {
                                    text: 'Ok',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $.alert({
                                            title: 'Alerta',
                                            content: 'Recuerda que debes hacer cierre de tu caja',
                                        });
                                    }
                                },
                            }
                        });
                    }
                },
                error: function() { 
                    console.log(data);
                }
            });
        }
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
    });

    function crearDialogo( cajas ) {
        var nombreCajero = $('#nombre').val();
        var contenido = '' +
            '<form action="" class="formName">' +
            '{{ csrf_field() }}'+
            '<div class="form-group">' +
            '<label>Seleccionar Caja</label>' + 
            '<select class="caja form-control" name="caja_id" required>'+ 
            '<option class="form-control" value="I">Seleccione una Caja</option>';
        $.each( cajas, function( key, value ) {
            contenido = contenido + '<option class="form-control" value="'+value.id+'">'+value.nombre+'</option>';
        });
        contenido = contenido + '</select>';
        contenido += '<br>' + '<label>Valor de la Base</label>';
        contenido += '<input type="number" class="base form-control" name="nombre" id="nombre" value="10000" min="10000" required>' + '</div>' + '</form>';
        $.confirm({
            title: 'Bienvenido Cajero ' + nombreCajero,
            content: contenido,
            buttons: {
                formSubmit: {
                    text: 'Abrir Caja',
                    btnClass: 'btn-blue',
                    action: function () {
                        var valorCaja = this.$content.find('.caja').val();
                        var baseCaja = this.$content.find('.base').val();
                        if(!valorCaja || valorCaja == 'I' ){
                            $.alert('debes escoger una caja');
                            return false;
                        }
                        if(!baseCaja){
                            $.alert('debes escribir el monto de la base');
                            return false;
                        }
                        else {
                            if(baseCaja < 10000){
                                $.alert('el valor de la base debe ser mayor o igual a 10.000');
                                return false;
                            }
                        }
                        var ruta='http://'+window.location.host;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: ruta + "/caja/asignar/"+valorCaja+"/"+baseCaja,
                            dataType: "json",
                            success: function( msg ){
                                $.alert('' + msg.msg);
                            }
                        });    
                    }   
                },
                // cancel: function () {
                //     //close
                // },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

</script>
@endsection