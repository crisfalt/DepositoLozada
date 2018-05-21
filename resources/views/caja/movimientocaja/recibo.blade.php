<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Recibo de Caja</title>
 
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
      

      
    
<!--       
      <table  border="0" cellspacing="2" cellpadding="2" style="margin: 0 left; width:25%">
        <thead>
          <tr>
            <th class=""><center>Recibo de Caja</center></th>
            <th class=""><center>Deposito Los Losadas</center></th>
            <th class=""><center>Orden Compra #:</center></th>
            
          </tr>
        </thead>
        <tbody>
               
              
                    <tr>
                            <td class="text-center"><center>Los Losadas</center></td>                           
                            <td class="text-center"><center>Nit: 123456</center></td>                            
                            <td class="text-center"><center></center></td>                
                    </tr>
              
                

        </tbody>
      </table> -->
        

    


   <!--    tabla detalle -->


   <table class="egt" border="0.5" >

<thead>

  <tr>

    <th>Titulo</th>

    <th colspan="4">Recibo de caja Menor</th>

   

  </tr>

  <tr>
    @foreach( $Cargarmovimientos as $Cargarmovimiento )
    <th scope="col">N°{{$Cargarmovimiento->id}}</th>
    @endforeach
    <th colspan="2">Rivera/Huila</th>

    <th>Fecha:</th>
    @foreach( $Cargarmovimientos as $Cargarmovimiento )
    <th>{{$Cargarmovimiento->fecha}}</th>
    @endforeach

    

  </tr>

</thead>

<tbody style="background: rgba(128, 255, 0, 0.3); border: 1px solid rgba(100, 200, 0, 0.3);">

  <tr>

    <th>Valor</th>
    @foreach( $Cargarmovimientos as $Cargarmovimiento )
    <td colspan="4">${{number_format($Cargarmovimiento->valor)}}</td>
    @endforeach
    

  </tr>

  <tr>

    <th colspan="5">Concepto</th>

    

  </tr>

</tbody>

<tbody style="background: rgba(255, 128, 0, 0.3); border: 0.5px solid rgba(200, 100, 0, 0.3);">

  <tr>
    @foreach( $Cargarmovimientos as $Cargarmovimiento )
    <th colspan="5">{{$Cargarmovimiento->descripcion}}</th>
    @endforeach   

  </tr>
</tbody>

<tfoot style="background: rgba(128, 255, 0, 0.3); border: 1px solid rgba(100, 200, 0, 0.3);">
<tr>

    <th colspan="5">Valor En Letra</th>

    

</tr>

<tr>



@foreach( $Cargarmovimientos as $Cargarmovimiento )
<?php 
$letras = \NumeroALetras::convertir($Cargarmovimiento->valor);
 ?>

<td colspan="5">{{$letras}}</td>
@endforeach


</tr>

<tr>
<th colspan="5">Firma de recibido</th>
</tr>
<tr>
<th colspan="5">N°</th>
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
