<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recibo de Venta</title>
 
  </head>
  <style type="text/css">
    #detallecompra td:nth-child(1){
      
      width: 3%;;
      text-align: center;
      
    }
    #detallecompra td:nth-child(2){
      
      width: 12%;;
      text-align: center;
      
    }
    #detallecompra td:nth-child(3){
      
      width: 3%;;
      text-align: center;
      
    }

    #detallecompra td:nth-child(4){
      
      width: 10%;
      text-align: center;
      
    }
    #detallecompra td:nth-child(5){
      
      
      text-align: center;
      
    }

  </style>
  <body>

    <main>
      

      
    
      <div class="">

      <table  border="0" cellspacing="2" cellpadding="2" style="margin: 0 auto; width:100%">
        <thead>
          <tr>
            <th class=""><center></center></th>
            <th class=""><center>Deposito Los Losadas</center></th>
            <th class=""><center>Factura de Compra #:</center></th>
            
          </tr>
        </thead>
        <tbody>
                @foreach( $Cargarventas as $Cargarventa )
              
                    <tr>
                            <td class="text-center"><center>
                              <div style=" display: block;margin: -50px auto;">
                              <img src="{{ $imageLogo  }}" width="850%" height="150%" style=""></img>                                
                              </div>
                            </center></td>                           
                            <td class="text-center"><center>Nit: 123456</center></td>                            
                            <td class="text-center"><center>{{ $Cargarventa -> id }}</center></td>                
                    </tr>
                    <tr>
                            <td class="text-center"><center></center></td>                           
                            <td class="text-center"><center>Direccion: Rivera/Huila</center></td>                
                            <td class="text-center"><center></center></td>                         
                    </tr>
                    <tr>
                            <td class="text-center"><center></center></td>                           
                            <td class="text-center"><center>Telefono: 89756</center></td>                         
                            <td class="text-center"><center></center></td> 
                    </tr>
                 @endforeach

        </tbody>
        

    <table class="" style="margin: 0 auto; width:100%">
        <<thead>
            <tr>

              <th></th>
              <th></th>
              <th></th>
              <th></th>

            </tr>
      </thead>
      <tbody>
              <tr>
                <th>Condicion Pago:</th>
                  @foreach( $Cargarventas as $Cargarventa )
                <td>{{$Cargarventa ->formapagos()->nombre}}</td>
                  @endforeach
                <td><strong>Fecha:</strong></td>
                @foreach( $Cargarventas as $Cargarventa )
                <td>{{$Cargarventa ->created_at}}</td>
                  @endforeach
              </tr>

              <tr>
                <th>Cliente:</th>
                  @foreach( $Cargarventas as $Cargarventa )
                <td>{{$Cargarventa ->cliente()->name}}</td>
                  @endforeach
                <td><strong>Tel:</strong></td>
                @foreach( $Cargarventas as $Cargarventa )
                <td>{{$Cargarventa ->cliente()->phone}}</td>
                @endforeach

              </tr>

              <tr>

                  <th>Empleado</th>
                  @foreach( $Cargarventas as $Cargarventa )
                  <td>{{$Cargarventa ->vendedores()->name}}</td>
                  @endforeach
                  <td><strong>Direccion:</strong></td>
                  @foreach( $Cargarventas as $Cargarventa )
                  @if($Cargarventa ->cliente()->address==null)
                  <td>{{$Cargarventa ->cliente()->address}}</td>
                  @else
                  <td>No Hay direccion</td>
                  @endif
                   @endforeach

              </tr>
              <tr>

                  <th>Departamento</th>
                  @foreach( $Cargarventas as $Cargarventa )
                  <td>{{$Cargarventa ->departamentos()->nombre}}</td>
                  @endforeach
                  <td><strong>Municipio:</strong></td>
                  @foreach( $Cargarventas as $Cargarventa )
                  <td>{{$Cargarventa ->municipios()->nombre}}</td>
                   @endforeach

              </tr>
              <tr>

                  <th>Zona:</th>
                  @foreach( $Cargarventas as $Cargarventa )
                  <td>{{$Cargarventa ->zonass()->nombre}}</td>
                  @endforeach
                  <td><strong>Ruta:</strong></td>
                  @foreach( $Cargarventas as $Cargarventa )
                  <td>{{$Cargarventa ->rutass()->nombre}}</td>
                   @endforeach

              </tr>
        </tbody>



   <!--    tabla detalle -->

   <table id="detallecompra"  style="width:100%"  border="0.5" >
<thead>
  <tr>

    <th>IdItem</th>
    <!-- <th>TipoPaca</th> -->
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio Compra</th>
    <th>SubTotal</th>

  </tr>
  </thead>
  <tbody>
    <?php                                
    $IdCompra =0; 
    $subtotal=0;
    $total=0;
    $acumuladorProducto = "";
    $acumuladorCantidad = "";
    $acumuladorPrecio = "";
    $acumuladorSubTotal = "";
    $arrayAcumulador = array();
    $arrayAcumulador2 = array();
    $arrayAcumulador3 = array();
    $arrayAcumulador4 = array();
      ?>
    @for($i = 0 ; $i < count($arrayCanasta); $i++ )
        @for($j = 0 ; $j < count($Detalleventas); $j++ )
            @if( $arrayCanasta[ $i ] == $Detalleventas[ $j ]->Numero_canasta )
                <?php 
                    $acumuladorProducto = ($acumuladorProducto . $Detalleventas[$j]->producto()->nombre);
                    $acumuladorProducto = $acumuladorProducto."-";
                    $acumuladorCantidad = ($acumuladorCantidad.$Detalleventas[$j]->cantidad);
                    $acumuladorCantidad = $acumuladorCantidad."-";
                    $acumuladorPrecio = $acumuladorPrecio.number_format($Detalleventas[$j]->precio)."-";
                    $acumuladorSubTotal .= number_format(($Detalleventas[$j]->cantidad * $Detalleventas[$j]->precio))."-";
                      $subtotal += ($Detalleventas[$j]->cantidad * $Detalleventas[$j]->precio);
                    
                ?>
            @endif
        @endfor
        <?php
          $total += $subtotal;
          array_push( $arrayAcumulador, $acumuladorProducto );
          array_push( $arrayAcumulador2, $acumuladorCantidad );
          array_push( $arrayAcumulador3, $acumuladorPrecio );
          array_push( $arrayAcumulador4, $acumuladorSubTotal );
          $acumuladorProducto = "";
          $acumuladorCantidad = "";
          $acumuladorPrecio = "";
          $acumuladorSubTotal = "";
          $subtotal = 0;
        ?>  
    @endfor
    @foreach( $arrayAcumulador as $index => $detalle )
              <?php
               $totalindi=0;

                ?> 
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $detalle }}</td>
            <td>{{ $arrayAcumulador2[$index] }}</td>
            <td>{{ $arrayAcumulador3[$index] }}</td>
            <td>{{ $arrayAcumulador4[$index] }}</td>
        </tr>
    @endforeach
    @for($j = 0 ; $j < count($Detalleventas); $j++ )
      @if($Detalleventas[ $j ]->Numero_canasta == null ) 
          <tr>
              <td></td>
              <td>{{ $Detalleventas[$j]->producto()->nombre }}</td>
              <td>{{ $Detalleventas[$j]->cantidad }}</td>
              <td>{{ number_format($Detalleventas[$j]->precio) }}</td>
               <?php
               $totalindi=($Detalleventas[$j]->precio)*($Detalleventas[$j]->cantidad);

                ?>  
              <td>{{number_format($totalindi)}}</td>
          </tr>
        @endif
    @endfor
   </tbody>
  <tfoot>

    <tr>

      <th colspan="4" class="text-center">Total</th>

      
      <td colspan="1"><strong>$ {{number_format(($total)+($totalindi))}}</strong></td>
     
     

    </tr>

  </tfoot>

</table>


                    
  </body>
   </main>
</html>


    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
