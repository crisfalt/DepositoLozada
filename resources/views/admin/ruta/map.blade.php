@extends('layouts.app')

@section('title','Rutas')

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
                    <div id="directions-panel"></div>
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
<script>
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
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Segmento de la Ruta: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address;
              summaryPanel.innerHTML += ' => ' + route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += ' Distancia => ' + route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>

@endsection