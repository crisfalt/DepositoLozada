@extends('layouts.app')

@section('title','Rutas')
<link rel="stylesheet" type="text/css" href="{{ asset('css/shadowbox.css') }}" />
@section('styles')
    <style>
        /* estilo para que la imagen quede bien redonda */
        .resize-img {
            height: 80px;
            width: 80px;
        }
    </style>
@endsection

@section('titulo-contenido','Rutas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <!-- <div class="row">
                    <div class="col-md-6 text-right"><a href="{{ url('/zona') }}" class="btn btn-info btn-round">Volver</a></div>
                </div> -->
                <h4 class="card-title text-center"> Mapa de Ruta {{ $ruta -> nombre }}</h4>
            </div>
            <div class="card-body" onload="mapa.initMap()">
                <div id="map"></div>
                <br>
                <div class="row justify-content-center">
                    <a class="btn btn-info" href="{{ url('/ruta/alls') }}">Regresar</a>
                </div>
                <div id="right-panel">
                    {{--<div id="directions-panel"></div>--}}
                    <table class="table table-responsive" cellspacing="0" width="100%" id="tableTiposMovimientos">
                        <thead class=" text-primary">
                        <th class="text-left">
                            Orden
                        </th>
                        <th class="text-left">
                            Foto
                        </th>
                        <th class="text-center">
                            Cliente
                        </th>
                        <th>
                            Direccion
                        </th>
                        <th>
                            Telefono
                        </th>
                        <th>
                            Celular
                        </th>
                        <th>
                            Acciones
                        </th>
                        </thead>
                        <tbody>
                        @foreach( $ruta->union() as $index => $rutaCliente )
                            <tr>
                                <td>{{ ($index+1)  }}</td>
                                <td>
                                    @if( $rutaCliente -> url_foto )
                                        <a href="/imagenes/clientes/{{ $rutaCliente -> url_foto }}" rel="shadowbox"><img class="rounded-circle mx-auto d-block resize-img" src="/imagenes/clientes/{{ $rutaCliente -> url_foto }}"></a>
                                    @else
                                        <img class="img-thumbnail mx-auto d-block resize-img" src="/imagenes/default.png" alt="">
                                    @endif
                                </td>
                                <td>{{ $rutaCliente -> name }}</td>
                                <td>{{ $rutaCliente -> address }}</td>
                                <td>{{ $rutaCliente -> phone }}</td>
                                <td>{{ $rutaCliente -> celular }}</td>
                                <td class="td-actions text-center">
                                    <a class="btn btn-warning" href="{{ url('/venta/'.$rutaCliente->number_id.'/create') }}" target="_blank">Realizar Venta</a>
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
<!-- MAPA -->

@endsection 
@section('scripts')
 <!--  Google Maps Plugin    -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDS-rmXg8BxyY1KtI2N3s7h86kOhzZQvI8&callback=initMap"></script>
 <!-- script para cargar el mapa de los clientes en una ruta -->
<script src="{{ asset('/js/shadowbox.js') }}"></script>
<script>
    Shadowbox.init({
        overlayColor: "#000",
        overlayOpacity: "0.6",
    });

    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            scrollwheel: false,
            zoomControl: true,
            center: {lat: 2.535935, lng: -75.52767}
        });
        directionsDisplay.setMap(map);

        calculateAndDisplayRoute(directionsService, directionsDisplay);
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var unidas = <?php echo json_encode($ruta->union());?>; //capturar arreglo de php a javascript
        console.log( unidas );
        for (var i = 1; i < ( unidas.length - 1 ); i++) {
            waypts.push({
              location: unidas[ i ].address + ' Rivera,Huila',
              stopover: true,
            });
        }

        directionsService.route({
            origin: unidas[ 0 ].address  + ' Rivera,Huila',
            destination: unidas[ unidas.length - 1 ].address + ' Rivera,Huila',
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
        //            for (var i = 0; i < ( unidas.length); i++) {
        ////                var routeSegment = i + 1;
        ////                summaryPanel.innerHTML += '<b>Segmento de la Ruta: ' + routeSegment +
        ////                  '</b><br>';
        ////                summaryPanel.innerHTML += route.legs[i].start_address;
        ////                summaryPanel.innerHTML += ' => ' + route.legs[i].end_address + '<br>';
        ////                summaryPanel.innerHTML += ' Distancia => ' + route.legs[i].distance.text + '<br><br>';
        //                summaryPanel.innerHTML += '<b>Cliente '+ (i+1) + ' : ' + unidas[ i ].name + '</b>';
        //                summaryPanel.innerHTML += '\t;<b>Direccion : ' + unidas[ i ].address + '</b><br>';
        //                summaryPanel.innerHTML += '<a class="btn btn-warning" href="#">Realizar Venta</a><br>';
        //            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
    }
    </script>

@endsection