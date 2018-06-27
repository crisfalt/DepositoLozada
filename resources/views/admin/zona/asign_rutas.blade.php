@extends('layouts.app')

@section('title','DepositoLozada | DashBoard')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('styles')
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
@endsection

@section('titulo-contenido' , 'Bienvenido')

@section('header-class')
    <div class="panel-header panel-header-sm">
    </div>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Asignar Vendedor a Una zona o Ruta</h5>
                </div>
                <div class="card-body">
                    <form id="form">
                        {{ csrf_field() }}
                        <div class="alert alert-with-icon" id="message">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="title">Nombre o Numero de Documento del Vendedor</label>
                                <input type="text" class="form-control" name="name" id="name" value="" placeholder="nombre del vendedor">
                                <input type="hidden" id="vendedor_id">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="title">Zonas</label>
                                    <select class="form-control" name="zona_id" id="zona_id" onchange="loadRutas(this)">
                                        <option class="form-control" value="I">Seleccione Una Zona</option>
                                        @foreach ( $zonas as $zona )
                                            <option class="form-control" value="{{ $zona->id }}" @if( $zona -> id == old( 'zona_id') )  selected @endif>{{ $zona->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="title text-center">Rutas</label>
                                <div id="multiple">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-round btn-warning" id="btnAsignar">Asignar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Vendedores Con sus Rutas</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="title">Nombre Vendedor</h5>
                    </div>
                    <div class="text-center">
                        <h7 class="description">Numero de Identificacion</h7>
                    </div>
                    <br>
                    <div>
                        <table class="table table-striped" cellspacing="0" width="100%" id="tableTiposMovimientos">
                            <thead class=" text-primary">
                                <th class="text-center">
                                    Zona
                                </th>
                                <th class="text-center">
                                    Ruta
                                </th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#message").hide();
            var src = "{{ route('searchajax') }}";
            $("#name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: src,
                        dataType: "json",
                        data: {
                            term : request.term
                        },
                        success: function(data) {
                            if( data[0].id != "undefined" || data[0].id != null ) $('#vendedor_id').val(data[0].id);
                            response(data);
                        }
                    });
                },
                minLength: 3,

            });
        });
    </script>
    <script>
        $("#form").on("submit", function(e){
            e.preventDefault();
            var nombreVendedor = $('#name');
            var idVendedor = $('#vendedor_id').val();
            if( nombreVendedor.val() == null || nombreVendedor.val() == '' ) {
                document.getElementById('message').innerHTML= 'El nombre o numero de documento del vendedor no puede ser vacio';
                $('#message').removeClass('alert-success');
                $('#message').addClass('alert-danger');
                $("#message").show();
                nombreVendedor.focus();
            }
            else {
                var zona = $('#zona_id');
                if( zona.val() == null || zona.val() == 'I' ) {
                    document.getElementById('message').innerHTML='Debe seleccionar una zona no puede ser vacia\n';
                    $('#message').removeClass('alert-success');
                    $('#message').addClass('alert-danger');
                    $("#message").show();
                    zona.focus();
                }
                else {
                    var contador = 0;
                    var rutas_id = [];
                    $('input[type=checkbox]:checked').each(function() {
                        rutas_id[ contador ] = $(this).prop("id");
                        contador++;
                        console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") Seleccionado");
                    });
                    if( contador == 0 ) {
                        document.getElementById('message').innerHTML='Debes escoger al menos una Ruta';
                        $('#message').removeClass('alert-success');
                        $('#message').addClass('alert-danger');
                        $("#message").show();
                    }
                    else {
                        $("#message").hide();
                        console.log(rutas_id);
                        var src = "{{ route('zona.vendedor.actualizar_asignacion') }}";
                        $.ajax({
                            url: src,
                            dataType: "json",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                vendedor_id : idVendedor,
                                rutas_id : rutas_id
                            },
                            success: function(response) {
                                if( response.status ) {
                                    document.getElementById('message').innerHTML=response.msg;
                                    $('#message').removeClass('alert-danger');
                                    $('#message').addClass('alert-success');
                                    $("#message").show();
                                    $('#name').val("");
                                    $("#zona_id").prop('selectedIndex', 'I');
                                    //clear all elements inside div with dom
                                    var d = document.getElementById("multiple");
                                    while (d.hasChildNodes()) d.removeChild(d.firstChild);
                                }
                            }
                        });
                        // $.each(rutas_id , function (index,value) {
                        //     console.log(value);
                        // })
                    }
                }
            }

        });
        function loadRutas( origin ) {
            src = "{{ route('zona.search.rutas.json') }}";
            $("#rutas_id option").remove();
            var contador = 0;
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    zona_id : origin.value
                },
                success: function(data) {
                    console.log(data);
                    $('#multiple').empty();
                    var newDiv = document.createElement("div");
                    newDiv.setAttribute('id','control');
                    newDiv.setAttribute('class','text-center');
                    if( data.id === 'I' ) {
                        var txtVacia   = document.createElement("INPUT");
                        txtVacia.setAttribute("type", "text");
                        txtVacia.setAttribute('class','form-control');
                        txtVacia.setAttribute('readOnly','true');
                        txtVacia.value=""+data.name;
                        newDiv.appendChild(txtVacia);
                    }
                    else {
                        $.each(data, function (key, value) {
                            console.log(value);
                            var label = document.createElement("LABEL");
                            label.setAttribute('class','custom-control custom-checkbox col-md-4');
                            var spanIndicator = document.createElement("SPAN");
                            spanIndicator.setAttribute('class','custom-control-indicator');
                            var spanDescription = document.createElement("SPAN");
                            spanDescription.setAttribute('class','custom-control-description');
                            spanDescription.innerHTML=""+value.name;
                            var checkRutas   = document.createElement("INPUT");
                            checkRutas.setAttribute("type", "checkbox");
                            checkRutas.setAttribute('class','custom-control-input');
                            checkRutas.setAttribute('id',value.id);
                            label.appendChild(checkRutas);
                            label.appendChild(spanIndicator);
                            label.appendChild(spanDescription);
                            newDiv.appendChild(label);
                        });
                    }
                    document.getElementById("multiple").appendChild(newDiv);
                }
            });
        }
    </script>
@endsection