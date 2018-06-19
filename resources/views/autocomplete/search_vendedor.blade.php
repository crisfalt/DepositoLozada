@extends('layouts.app')

@section('title','DepositoLozada | DashBoard')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
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
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="title">Nombre o Numero de Documento del Vendedor</label>
                            <input type="text" class="form-control" name="name" id="name" value="" placeholder="nombre del vendedor">
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

                                {{--<select class="form-control" name="rutas_id" id="rutas_id">--}}
                                    {{--<option class="form-control" value="I">Seleccione</option>--}}
                                    {{--@foreach ( $marcas as $marca )--}}
                                        {{--<option class="form-control" value="{{ $marca->id }}" @if( $marca -> id == old( 'fk_marca') )  selected @endif>{{ $marca->nombre }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-round btn-warning">Asignar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    <script>

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

        $(document).ready(function() {
            src = "{{ route('searchajax') }}";
            $("#name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: src,
                        dataType: "json",
                        data: {
                            term : request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 3,

            });
        });
    </script>
@endsection