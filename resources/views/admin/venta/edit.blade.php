@extends('layouts.app')

@section('title','Venta')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" />
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/layout.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Compra')

@section('header-class')

<div class="panel-header panel-header-sm">
</div>
@endsection


<style>




.custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding-top: 2px;
    padding-bottom: 5px;
    padding-right: 5px;
  }

  .enlace {
      border: 0;
      padding: 50px;
      background-color: transparent;    
      color: blue;
      border-bottom: 0px solid blue;
    }

    .ui-widget {

    font-size: 1.5em;
    }
</style>
@section('contenido')
<div class="row">    
    <!-- mostrar mensaje del controlador -->
    @if (session('notification'))
    <div class="alert alert-info alert-with-icon" data-notify="container">
        <button type="button" data-dismiss="alert" aria-label="Close" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span data-notify="icon" class="now-ui-icons ui-1_check"></span>
        <span data-notify="message">{{ session('notification') }}</span>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
                <div class="row text-center">
                     <div class="col-md-6 pr-1">
                            <div class="form-group">
                               <h5 class="title">Editar  venta</h5>
                              
                            </div>
                     </div>
                     <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <h5 class="title" id="date">Fecha</h5>
                                
                            </div>
                     </div>                 
                </div>
          </div>
         
        

     <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                @if ( session( 'error' ) )
                <div class="alert alert-warning">
                    <ul>
                        @foreach (session('error') as $itemError)
                            <li>{{ $itemError }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCompras">
                        <thead class=" text-primary">
                         <th class="text-center">
                                N°Venta
                            </th>
                            <th class="text-center">
                                Estado
                            </th>
                            <th class="text-center">
                                Cliente
                            </th>
                            
                            <th class="text-center">
                                Total
                            </th>                            
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        @foreach( $CargarVentas as $CargarVenta )
                        <?php
                            $nombreEstadoVenta =  $CargarVenta -> estadoVentas();
                            $nombreProveedor = $CargarVenta -> cliente();
                        ?>
                            <tr>
                        <input type="hidden" name="" value="{{ $CargarVenta -> id }}" id="id_factura"/>
                                    <td class="text-center">{{ $CargarVenta -> id }}</td>
                                    @if( $CargarVenta -> estadoVentas() != "" ||  $CargarVenta -> estadoVentas() != null )
                                    <td class="text-center">{{  $CargarVenta -> estadoVentas() -> nombre }}</td> 
                                    @else
                                    <td class="text-center">0</td> 
                                    @endif
                                      {{-- proveedores esta vacio debe validar eso  --}}
                                    @if( $CargarVenta -> cliente()!= "" || $CargarVenta -> cliente()!= null )
                                    <td class="text-center">{{ $CargarVenta -> cliente()-> name }}</td>
                                    @else 
                                    <td class="text-center">Sin Definir</td>
                                    @endif
                                    @if($CargarVenta->total != null ||$CargarVenta->total != "")                                           
                                    <td class="text-center">{{ $CargarVenta -> total }}</td>
                                    @else
                                    <td class="text-center">0</td>
                                    @endif
                                    <td class="td-actions text-center">
                                        <form  method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            @if($CargarVentas[0]->fk_estado_venta ==1)
                                            <a href="{{ url('/ventacabeza/'.$CargarVenta->id.'/edit') }}" rel="tooltip" title="Editar Compra{{ $CargarVenta -> id }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                           
                                            @endif
                                        </form>
                                    </td>

                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                <label>fecha entrega</label>
                              <input type="date" name="fecha_entrega" id="datepicker" value="{{$CargarVenta->fecha_entrega}}" onchange="validarfecha(this.value);" pattern="[_0-9]{2}/[_0-9]{2}/[_0-9]{4}"class="form-control" required>
                                    
                            </div>                                    
                            </div>

                              <!--   <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                <label>hora entrega</label>
                              <input type="time" name="hora" id="#input_starttime" value="{{$CargarVenta->hora}}" onchange="validarhora(this.value);" pattern="[_0-9]{2}/[_0-9]{2}/[_0-9]{4}"class="form-control" >
                                    
                            </div>                                    
                            </div> -->

                          <!--  <div class="row"> -->
                          <!--  <div class='col-sm-6'>
                         <div class="form-group">
                           <div class='input-group date' id='datetimepicker3'>
                           <input type='text' class="form-control" />
                              <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                         </span>
                            </div>
                            </div>
                          </div> -->
                        </br>
                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                <label>hora entrega</label>
                                <input id="timepicker" width="270" value="{{$CargarVenta->hora}}"  onchange="validarhora(this.value)" />
                                  </div>                                    
                            </div>
</br>
                                
                                </tr>
                             
                                @endforeach
                              

        @if($CargarVentas[0]->fk_estado_venta ==1)

                <form style="margin: 0; padding: 0;" id="AgregarVenta" action="{{url('/AgregarVentaEditar')}}" method="post" onsubmit="return validacionAgregar()">
                    {{ csrf_field() }}
                    <?php
                      $cargarProducto= Session::get('productoEditar');
                         
                     ?>
                 
                   
                    <div class="row" style="justify-content: center;">
                                  
  
                          <div class="col-md-3 pr-1">
                              <div class="form-group">
                                  
                                  <select class="form-control"  id="marca" name="marca" size="4">
                                      <option class="form-control" value="0" selected>Selecione la Marca</option>
                                      @foreach ( $marcas as $marca )
                                               <option class="form-control" value="{{ $marca->id}}" @if( $marca -> fk_producto == old( 'marca') ) @endif>{{ $marca->nombre }}</option>
                                        @endforeach
                                  </select>
                              </div>
                              
                          </div>
                          <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                      <select class="form-control"  style=" display : none" name="tipocontenido"  id="tipocontenido" disabled="TRUE" size="4" >
                                              <option class="form-control" value="0" selected>Selecione el Tipo Contenido</option>
                                          @foreach ( $tipocontenidos as $TipoContenido )
                                                   <option class="form-control" value="{{ $TipoContenido->id}}" @if( $TipoContenido -> fk_producto == old( 'TipoContenido') )  @endif>{{ $TipoContenido->nombre }}</option>
                                            @endforeach
                                      </select>
                                  </div>
                                  
                              </div>
                           <div class="col-md-3 pr-1">
                                      <div class="form-group">
                                          <select class="form-control"  id="tipopaca" name="fk_tipo_paca" style=" display : none"   disabled="TRUE" size="4"  >
                                                  <option class="form-control" value="0" selected>venta individual</option>
                                              @foreach ( $tipopacas as $tipopaca )
                                                       <option class="form-control" value="{{ $tipopaca->id}}" @if( $tipopaca -> fk_producto == old( 'fk_tipo_paca') ) @endif>{{ $tipopaca->nombre }}</option>
                                                @endforeach
                                          </select>
                                      </div>
                                      
                           </div>
             
              </div>
  
         
  
                      <div class="row" style="justify-content: center;">
                         
                                  <div  class="col-md-3 pr-1"  style=" display : none" id="comboboxOCultar">
                                      <div class="form-group"> 
                                      <label>Producto</label>                           
                                       <select class="form-group" id="combobox" name="fk_producto"   required>     
                                              <option class="form-control" value="0" selected>buscar producto</option>                                    
                                              @foreach( $productos as $producto )
                                       <option class="form-control" value="{{$producto-> codigo}}">{{$producto -> nombre}}</option>
                                              @endforeach
                                        </select>
                                      </div>                            
                                  </div>
                         
  
                     
                                  <div class="col-md-2 pr-1" id="cantidad4Ocultar" " style=" display : none">
                                      <div class="form-group">
                                          <label>Cantdad</label>
                                          <input type="number"  class="form-control" placeholder="Cantidad" id="cantidad4"  name="cantidad" MIN="1" STEP="1" onclick="MostrarCanastaIndividual();"   value="0" required>
                                         
                                      </div>
                                      
                                  </div>
  
                                    
                                  <div class="col-md-2 pr-1" id="cantidadcanastaOcultar"  style=" display : none"  >
                                          <div class="form-group">
                                            <label>Cantidad Canasta</label>
                                              <input type="number" class="form-control" placeholder="Cantidad de canasta"  id="cantidadcanasta" MIN="0" STEP="1"   value="0"  required>
                                             
                                          </div>
                                          
                                      </div>  
                                  
                                  <div class="col-md-2 pr-1" id="cantidaenvaseOcultar"   style=" display : none" >
                                      <div class="form-group">
                                        <label>Cantidad Envases</label>
                                          <input type="number" class="form-control" name="cantidadEnvases" placeholder="Cantidad de envases"  id="cantidaenvase" MIN="0" STEP="1"  value="0">
                                         
                                      </div>
                                      
                                  </div>      
                                  
                                  <div class="col-md-2 pr-1" id="cantidadPlasticoOcultar"   style=" display : none" >
                                      <div class="form-group">
                                        <label>Cantidad Plastico</label>
                                          <input type="number" class="form-control" name="cantidadPlastico" placeholder="Cantidad de plastico"  id="cantidadPlastico" MIN="0" STEP="1"  value="0">
                                         
                                      </div>
                                      
                                  </div> 
  
                                  
                                  
  
  
                      </div>
                        <div class="row text-center" >                         
                                  <div class="col-md-12 pr-1" >
                                            <div class="form-group">
                                                <center>
                                                 <button class="btn btn-info btn-round" id="OcltarBotonSubmit" type="submit"> Agregar</button>
                                                </center>
                                                 <center>
                                                 <button class="btn btn-info btn-round" id="OcultarBotonModal" type="submit" onclick='AbrirModalCanasta();'  style=" display : none"> Agregar canasta</i></button>
                                                 </center>
                                            </div>
                                            
                                  </div>
                        </div>  
                </form>
    @endif
               
            </div>
     
          
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCompras">
                        <thead class=" text-primary">
                                <th class="text-center">
                                        Canasta
                                    </th>
                            
                            <th class="text-center">
                                Producto
                            </th>
                            <th class="text-center">
                                Cantidad
                            </th>
                            {{-- @if($CargarVentas[0]->fk_estado_venta !=1)
                            <th class="text-center">
                                Cantidad Devolucion
                            </th>

                            @endif --}}
                                                 
                          
                          
                           
                            <th class="text-center">
                                Precio venta
                            </th>
                            <th class="text-center">
                                SubTotal
                            </th>                            
                            <th class="text-center">
                                devolver
                            </th>
                        </thead>                       

                        <tbody>
                                <?php                                
                                $IdCompra =0; 
                               $subtotal=0;
                               $total=0;      
                            ?>
                           @foreach( $Detalles_ventas as $Detalles_venta )
                           <tr>
                            <?php
                                
                                 $NombreProducto =  $Detalles_venta->producto();
                                 $PrecioProducto = $Detalles_venta->producto();
                                 $envase=$Detalles_venta->empaque();
                                 $marca=$Detalles_venta->productoMarca();
                                  $IdVenta =$Detalles_venta ->fk_factura; 
                                  $subtotal=$Detalles_venta->precio * $Detalles_venta->cantidad;
                                  $total=$total+$subtotal;
                                  $canasta= $Detalles_venta->Numero_canasta;
                                  if($canasta==null || $canasta==0 || $canasta==-1 || $canasta==-2 )
                                     {
                                        $canasta=0;
                                     }                                                                         
                             ?>
                             {{-- {{$marca->nombre}} --}}
                             <input type="text" id="idfac" value="{{$IdVenta}}" name="idfac" hidden="true">

                             @if($Detalles_venta->Numero_canasta !=null && $Detalles_venta->Numero_canasta != 0 && $Detalles_venta->Numero_canasta != -1 && $Detalles_venta->Numero_canasta != -2)
                             
                             <th class="text-center">{{  $Detalles_venta -> Numero_canasta }}</td>                               
                             @else                                
                                 <th class="text-center"> </td>                                 
                             @endif
                            
                               @if($Detalles_venta->Numero_canasta ==-1)
                              <th class="text-center">{{  $envase -> nombre.'-'.$marca->nombre}}</td>
                               
                               @elseif($Detalles_venta->Numero_canasta >0 || $Detalles_venta->Numero_canasta ==-2)
                              <th class="text-center">{{  $NombreProducto -> nombre.'-'.$marca->nombre }}</td>
                               @elseif($Detalles_venta->Numero_canasta ==0 )
                               <th class="text-center">{{'envases-'.$marca->nombre}}</td>
                               @endif
                                 
                             
                              @if($Detalles_venta->Numero_canasta ==null || $Detalles_venta->Numero_canasta == -2 || $Detalles_venta->Numero_canasta == -1)
                              
                                 <th class="text-center"><input name='{{$Detalles_venta -> id}}' type="number" value='{{$Detalles_venta -> cantidad}}' class="number"  MIN="1" STEP="1" SIZE="6" id="number" onchange="agregarCantidad(this.name,this.value);"></td>
                              
                              @else
                              <th class="text-center"><input name='{{$Detalles_venta -> id}}' type="number" value='{{$Detalles_venta -> cantidad}}' class="number "  MIN="1" STEP="1" SIZE="6" id="number"  style="background-color:#ff0000" disabled></td>
                              @endif
                                   
                                       {{-- <td>{{ $Detalles_venta -> cantidad }}</td> --}}
                                       <th class="text-center">{{ $Detalles_venta-> precio }}</td>
                                       <th class="text-center">{{ $Detalles_venta-> precio * $Detalles_venta-> cantidad }} </td>
                                       
                                       <th class="text-center">
                                            @if($CargarVentas[0]->fk_estado_venta ==1)
                                        <form  style="margin: 0; padding: 0;"  action="{{url('/detalleventaEdit/'.$Detalles_venta->id.'/'.$canasta)}}" method="post">
                                            {{ csrf_field() }}
                                               
                                               
                                               <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                   <i class="fa fa-times"></i>
                                               </button> 
                                           </form>
                                         </th>
                                         @endif
                                         @if($CargarVentas[0]->fk_estado_venta !=1)
                                         
                                            <form  style="margin: 0; padding: 0;"  action="{{url('/venta/agregarCantidadDevolucion')}}" method="post">
                                                {{ csrf_field() }}
                                                   {{-- {{ method_field('DELETE') }}    --}}
                                                   @if($CargarVentas[0]->fk_estado_venta !=1)
                                                   <th class="text-center"><input name="fk_cantidad" type="number" value='{{$cantidad}}' class="number "  MIN="1" STEP="1" MAX='{{$Detalles_venta -> cantidad}}' SIZE="6" id="number" ></td>
                                                  <input type="text" name="id"  value='{{$Detalles_venta->id}}' hidden="true" >
                                                   @endif
                                                   <th class="text-center">
                                                   <button type="submit" rel="tooltip" title="devolver" class="btn btn-danger btn-simple btn-xs">
                                                       <i class="now-ui-icons arrows-1_share-66"></i>
                                                   </button> 
                                                </th>
                                               </form>
                                            
                                             @endif
                                       </td>
                                   </tr>
                                   @endforeach
                        </tbody>
                        
                    </table>
                    <hr>
                    <h3 class="text-center"><strong>Total:{{$total}}</strong></h3>
                    @if($total !=0)
                    @if($CargarVentas[0]->fk_estado_venta ==1)
                   <div class="row text-center">
                        
                         <div class="col-md-6">
                             <div class="form-group">
                                
                                <a href="{{ action('VentaController@cerrarSesion',['idSession' => 2]) }}" class="btn btn-success btn-round">pendiente</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                    
                                <a href="{{ action('VentaController@update',['id' => $IdVenta,'estado'=>4]) }}"  class="btn btn-info btn-round" >por entregar</a>
                                </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                
                            <a href="{{ action('VentaController@update',['id' => $IdVenta,'estado'=>0]) }}"  class="btn btn-info btn-round" >entregar</a>
                            {{-- target="_blank()" codigo para nueva pestaña --}}
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    @if($CargarVentas[0]->fk_estado_venta ==1)
                    <div class="col-md-6">
                            <div class="form-group">
                               
                               <a href="{{ action('VentaController@cerrarSesion',['idSession' => 2]) }}" class="btn btn-success btn-round">pendiente</a>
                           </div>
                       </div>
                    @endif
                    @endif
                   
                </div>
            </div>
    
        </div>
    
</div>

@if($CargarVentas[0]->fk_estado_venta !=1)
<span  data-notify="message"> <h2 class="text-center">no se puede editar ya se facturo</h2></span>
<div class="col-md-4">
        <div class="form-group">
           
           <a href="{{ action('VentaController@cerrarSesion',['idSession' => 2]) }}"  class="btn btn-success btn-round">Cerrar Venta</a>
       </div>
   </div>
@endif
<!-- este voton se utiliza para devolver -->
<div class="col-md-4">
        <div class="form-group">
           
           <a href="{{URL::previous()}}"  class="btn btn-success btn-round">Regresar</a>
       </div>
   </div>


@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script> -->
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('/js/bootstrap-datetimepicker.min.js')}}"></script>
 
   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('/js/typeahead.bundle.min.js')}}"></script>
     <script src="{{asset('/js/scriptventaEditar.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



    
    
@endsection

