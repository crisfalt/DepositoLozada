
@extends('layouts.app')

@section('title','Venta')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet">


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Venta')

@section('header-class')

<div class="panel-header panel-header-sm">
</div>
@endsection


<style>

/* modal Por canasta */

        /* The Modal (background) */

        .colorCarrito {
            color:#ffffff;
        }
        #ContadorDeCantidad {
            color: #ffffff;
        }
        input:not([type]):disabled, input:not([type])[readonly="readonly"], input[type=text]:not(.browser-default):disabled, input[type=text]:not(.browser-default)[readonly="readonly"], input[type=password]:not(.browser-default):disabled, input[type=password]:not(.browser-default)[readonly="readonly"], input[type=email]:not(.browser-default):disabled, input[type=email]:not(.browser-default)[readonly="readonly"], input[type=url]:not(.browser-default):disabled, input[type=url]:not(.browser-default)[readonly="readonly"], input[type=time]:not(.browser-default):disabled, input[type=time]:not(.browser-default)[readonly="readonly"], input[type=date]:not(.browser-default):disabled, input[type=date]:not(.browser-default)[readonly="readonly"], input[type=datetime]:not(.browser-default):disabled, input[type=datetime]:not(.browser-default)[readonly="readonly"], input[type=datetime-local]:not(.browser-default):disabled, input[type=datetime-local]:not(.browser-default)[readonly="readonly"], input[type=tel]:not(.browser-default):disabled, input[type=tel]:not(.browser-default)[readonly="readonly"], input[type=number]:not(.browser-default):disabled, input[type=number]:not(.browser-default)[readonly="readonly"], input[type=search]:not(.browser-default):disabled, input[type=search]:not(.browser-default)[readonly="readonly"], textarea.materialize-textarea:disabled, textarea.materialize-textarea[readonly="readonly"] {
            color: #ffffff;
            border-bottom: 1px dotted rgba(0, 0, 0, 0.42);
        }


        .modal2 {
            /* visibility: hidden; */
            /*width: 320px;
                                                                            height: 568px;*/
            /*width: auto;
            height: auto;*/
            width: 500px;
            /*width: auto;*/
            height: auto;
            /*max-height: 70%;
            width: 55%;*/
            opacity: 0;
            margin: auto;
            background-repeat: no-repeat;
            color: #000000;
            box-shadow: 5px 10px 18px darkred;
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-58%,-50%); /*centrar en la mitad*/
            box-sizing: border-box;
            padding: 0px 30px;
            overflow: auto;
            display: none; /*Hidden by default*/
            position: fixed; /* Stay in place */
            /*position: relative;*/
            z-index: 1; /* Sit on top */
            /*padding-top: 100px;*/ /* Location of the box */
            /*left: 0;
            top: 0;*/
            /*width: 25%;*/ /*Full width*/
            /*height: 23%;*/ /*Full height*/
            overflow: auto; /*Enable scroll if needed*/
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            /*background-size: 100% 100%;*/ /*cubra el ancho de la pantalla*/
            /*font-family: sans-serif;*/
            /*height: 100vh;*/
           
            
        }

        /* Modal Content */
        .modal2-content {
            background-color: #fefefe;
            margin: auto;
            padding: 100px;
            border: 1px solid #888;
            width: 100%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            /*font-size: 28px;*/
            font-size: 46px;
            /*margin-top: -24px;*/
            font-weight: bold;
            margin: -15px;
        }

            .close:hover,
            .close:focus {
                color: #ff0000;
                text-decoration: none;
                cursor: pointer;
            }



/* fin modal  */


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
                               <h5 class="title">Crear Venta</h5>
                              
                            </div>
                     </div>
                     <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <h5 class="title" id="date">Fecha</h5>
                                
                            </div>
                     </div>                 
                </div>
          </div>
        <!--   inicia la conduicion del if -->         
          <div class="card-body"> <!-- falta cerrar este -->
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
                @if ( session( 'error' ) )
                <div class="alert alert-warning">
                    <ul>
                        @foreach (session('error') as $itemError)
                            <li>{{ $itemError }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

             
            <!--     fin errores -->
            @if(!Session::get('IdVenta'))
          <form  id="AgregarCabezeraVenta" action="{{url('/venta')}}" method="post">
                  {{ csrf_field() }}
                 <div class="row">
                        <div class="col-md-3 col-sm-12 pr-1">
                            <div class="form-group">
                                <label>Estado Venta</label>
                                <select class="form-control" name="fk_estado_venta" readonly>
                                @foreach ( $estadoEntregaVentas as $estadoEntregaVenta )
                                            <option class="form-control" value="{{ $estadoEntregaVenta->id }}" @if( $estadoEntregaVenta -> id == old( 'fk_estado_venta') )  selected @endif>{{ $estadoEntregaVenta->nombre }}</option>
                                @endforeach
                                </select>
                            </div>                            
                        </div>

                         <div class="col-md-3 col-sm-12 pr-1">
                             <div class="form-group">
                               <label>Bodega</label>
                                <select class="form-control" name="fk_bodega" >
                                     @foreach ( $bodegas as $bodega )
                                            <option class="form-control" value="{{ $bodega->id }}" @if( $bodega -> id == old( 'fk_bodega') )  selected @endif>{{ $bodega->nombre }}</option>
                                     @endforeach
                                </select>
                             </div>
                        </div>

                       <div class="col-md-3 col-sm-12 pr-1">
                             <div class="form-group">
                                 <label>Forma Pago</label>
                                <select class="form-control" name="fk_forma_de_pago" >
                                   @foreach ( $formaPagos as $formaPago )
                                            <option class="form-control" value="{{ $formaPago->id }}" @if( $formaPago -> id == old( 'fk_forma_de_pago') )  selected @endif>{{ $formaPago->nombre }}</option>
                                     @endforeach
                                </select>
                            </div>
                       </div>
                       <div class="col-md-3 col-sm-12 pr-1">
                            <div class="form-group">
                                <label>Cliente</label>
                                @if( isset($id_cliente ) )
                                    <select class="form-group"  id="combobox2"  name="fk_cliente" readonly="true" required>
                                    @foreach( $clientes as $cliente )
                                        @if( $cliente->number_id == $id_cliente )
                                            <option class="form-control"  value="{{$cliente-> number_id}},{{ $cliente-> name }}">{{$cliente -> name}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                @else
                                    <select class="form-group"  id="combobox2"  name="fk_cliente" required>
                                    <option value="I">Nombre Cliente</option>
                                    @foreach( $clientes as $cliente )
                                        <option class="form-control"  value="{{$cliente-> number_id}},{{ $cliente-> name }}">{{$cliente -> name}}</option>
                                    @endforeach
                                    </select>
                                @endif
                            </div>                            
                       </div>                     
                 </div>

              <label for="cbmostrar">
                <input type="checkbox"  class="fantasma" />
                desea ingresar la fecha y hora de lo contario el sistema le asiganara una fecha de entrega
              </label>
                 <div class="row" id="dvOcultar" style="display:none">                            
                            <div class="col-md-2 col-sm-12">
                                 <div class="form-group">
                                <label>fecha entrega</label>
                              <input type="date" name="fecha_entrega" id="datepicker" onchange="validarfecha(this.value);" pattern="[_0-9]{2}/[_0-9]{2}/[_0-9]{4}"class="form-control">
                                    
                            </div>                                    
                            </div>

                           <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                     <label>Hora entrega</label>
                                      <input type="time" name="hora" id="timepicker" onchange="validarhora(this.value);" pattern="[_0-9]{2}/[_0-9]{2}/[_0-9]{4}"class="form-control" >
                               
                                 </div>
                                      
                           </div>
                              
                  </div>

                  <div class="row text-center">                            
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group ">                                          
                                    <button class="btn btn-info btn-round" onclick="validacion(event);">Agregar</button>
                               </div>                                      
                            </div>

                           <div class="col-md-6 col-sm-12">
                                <div class="form-group ">
                                          
                                  <a href="{{ url('/venta') }}" class="btn  btn-danger btn-round" >Cancelar</a>
                                 </div>
                                      
                           </div>
                              
                  </div>
          </form>
        </div>
      <!--   termina el if -->
        @endif 
    <!--  cuando incia el otro if -->
    @if(Session::get('IdVenta') !=null)
     <div class="card-body">
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
                            // $nombreProveedor = $CargarVenta -> vendedores();
                        ?>
                            <tr>
                                    <td class="text-center">{{ $CargarVenta -> id }}</td>
                                    @if( $CargarVenta -> estadoVentas() != "" ||  $CargarVenta -> estadoVentas() != null )
                                    <td class="text-center">{{  $CargarVenta -> estadoVentas() -> nombre }}</td> 
                                    @else
                                    <td class="text-center">0</td> 
                                    @endif
                                    <td class="text-center">{{  $CargarVenta -> cliente() -> name }}</td> 

                                    @if($CargarVenta->total != null ||$CargarVenta->total != "")                                           
                                    <td class="text-center">{{ $CargarVenta -> total }}</td>
                                    @else
                                    <td class="text-center">0</td>
                                    @endif
                                    <td class="td-actions text-center">
                                        <form  method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            
                                            <a href="{{ url('/ventacabezacrear/'.$CargarVenta->id.'/edit') }}" rel="tooltip" title="Editar Venta{{ $CargarVenta -> id }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                           
                                            
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                                               

        <form style="margin: 0; padding: 0;"  id="AgregarVenta"  action="{{url('/AgregarVenta')}}"  method="post" onsubmit="return validacionAgregar()">
                {{ csrf_field() }}
                  <?php
                    $cargarProducto= Session::get('producto');
                       
                   ?>
                  @if(!Session::get('IdPaca'))
                 
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
                                    <select class="form-control"  style=" display: none;" name="tipocontenido"  id="tipocontenido" disabled="TRUE" size="4" >
                                            <option class="form-control" value="0" selected>Selecione el Tipo Contenido</option>
                                        @foreach ( $tipocontenidos as $TipoContenido )
<!--                                            --><?php
//                                                echo '<script>';
//                                                echo 'console.log('. json_encode( $TipoContenido ) .')';
//                                                echo '</script>';
//                                            ?>
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

                 @endif

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
                                        <label>Cantidad</label>
                                        <input type="number"  class="form-control" placeholder="Cantidad" id="cantidad4"  name="cantidad" MIN="1" STEP="1" onclick="MostrarCanastaIndividual();"   value="0" required>
                                       
                                    </div>
                                </div>
                                    
                                
                                  
                                <div class="col-md-2 pr-1" id="cantidadcanastaOcultar"  style=" display : none"  >
                                        <div class="form-group">
                                            <label>Cantidad Canastas</label>
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

                               
                                    <div class="form-group">
                                        <select class="form-control" name="fk_precio" disabled="true" id="fk_precio" style=" display : none" required>
                                                <option class="form-control" value="0" selected>precio venta</option> 
                                            @foreach ( $PrecioDeVentas as $PrecioDeVenta )
                                                     <option class="form-control" value="{{ $PrecioDeVenta->id}},{{$PrecioDeVenta->valor}}" @if( $PrecioDeVenta -> fk_producto == old( 'fk_precio') )  @endif>{{ $PrecioDeVenta->valor }}</option>
                                              @endforeach
                                        </select>
                                    </div>
                                    
                    </div>               
                                


                   
                      <div class="row text-center" >                         
                                <div class="col-md-12 pr-1" >
                                          <div class="form-group">
                                                <center>
                                               <button class="btn btn-info btn-round" id="OcltarBotonSubmit" type="submit">
                                                <i class="now-ui-icons add">Agregar</i>
                                              </button>
                                                </center>
                                              
                                                <center>
                                               <button class="btn btn-info btn-round" id="OcultarBotonModal" type="submit" onclick='AbrirModalCanasta();'  style=" display : none">
                                                <i class="now-ui-icons add">Agregar canasta</i>
                                              </button>
                                             </center>
                                          </div>                                          
                                </div>
                      </div>  
                </form> 
               
            </div>
     
          
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCompras">
                        <thead class=" text-primary">
                                <th class="text-center">
                                        canasta
                                    </th>
                            <th class="text-center">
                                Producto
                            </th>
                                                 
                           <th class="text-center">
                                Cantidad
                            </th>
                           
                            <th class="text-center">
                                Precio venta
                            </th>
                            <th class="text-center">
                                SubTotal
                            </th>                            
                            <th class="text-center">
                                Eliminar
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
                                        <form  style="margin: 0; padding: 0;"  action="{{url('/detalleventa/'.$Detalles_venta->id.'/'.$canasta)}}" method="post">
                                            {{ csrf_field() }}
                                            {{-- {{ method_field('DELETE') }}    --}}
                                            
                                            <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                <i class="fa fa-times"></i>
                                            </button> 
                                        </form>
                                      </th>
                                    </td>
                                </tr>
                                @endforeach
                           
                        </tbody>
                        
                    </table>
                    <hr>
                    <h3 class="text-center" ><strong>Total:{{$total}}</strong></h3>
                 @if($total !=0)


                    @foreach($CargarVentas as $CargarVenta)
                @if($CargarVenta->fk_forma_de_pago==2)
                 <div class="row text-center" >                         
                                <div class="col-md-2" >
                                          <div class="form-group">
                                            <label>Pago Incial</label>
                                            <input type="numeric" id="numero2" onkeypress="return solo_numeros(event)" onchange="validarmayor()"  class="form-control" name="pinicial" value="{{ old('pinicial') }}" required>
                                               
                                          </div>
                                          
                                </div>
                                <div class="col-md-2" >
                                          <div class="form-group text-center">
                                            <label>Deuda:</label>
                                            <input type="text" id="deuda" disabled="true" value="{{$total}}" class="form-control"  required>
                                               
                                          </div>
                                          
                                </div>
                                <div class="col-md-2" >
                                          <div class="form-group">                                            
                                            <input type="text" id="total" value="{{$total}}" class="form-control" hidden="true" required>
                                               
                                          </div>                                         
                                </div>
                  </div>
                  @endif
                  @endforeach

                   <div class="row text-center">
                        
                         <div class="col-md-4">
                             <div class="form-group">
                                
                                <a href="{{ action('VentaController@cerrarSesion',['idSession' => 1]) }}"  class="btn btn-success btn-round">pendiente</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group" >
                                    
                                <a onselect="validarmayor()" id="porentregar" href="{{ action('VentaController@recibo',['id' => $IdVenta,'estado'=>4,'abono'=>0]) }}"  class="btn btn-info btn-round" id="porentregar">por entregar</a>
                               
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                                
                            <a onselect="validarmayor()" id="entregar" href="{{ action('VentaController@recibo',['id' =>$IdVenta,'estado'=>0,'abono'=>0]) }}"  class="btn btn-info btn-round" >Registrar</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-4">
                            <div class="form-group" >                               
                               <a href="{{ action('VentaController@cerrarSesion',['idSession' => 3]) }}"  class="btn btn-success btn-round">pendiente</a>
                           </div>
                       </div>
                    @endif 

            @endif     
                </div>
            </div>
    
        </div>
    </div>
</div>


@section('scripts')
{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>


    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>
     <script src="{{asset('/js/scriptventa.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   <script type="text/javascript">

      function buscarDeudas(cedula)
    {
      alert(cedula);
      return 0;
        var idcliente = document.getElementById('combobox2').value;
        $("#numero2 option").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/abono/searchTotal/"+idcliente,
                dataType: 'json',
                success: function( data ){
                    console.log(data);
                    $.each(data, function (key, saldventa) {
                        
                        if(saldventa.saldo==null ||saldventa.saldo==0)
                        {
                            alert("entre por ull");
                            $("#numero2").append("<option value=" + saldventa.id + ">" +saldventa.total+ "</option>");
                            $("#saldo2").val( saldventa.total );

                        }
                        else
                        {
                            alert("entre al else");
                            $("#numero2").append("<option value=" + saldventa.id + ">" +saldventa.saldo+ "</option>");
                            $("#saldo2").val( saldventa.saldo );
                        }
                        
                   
                       
                    });
                }
            });

            

    }
   </script>

@endsection
@endsection