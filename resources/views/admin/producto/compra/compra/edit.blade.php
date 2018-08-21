@extends('layouts.app')

@section('title','Compra')


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                                   <h5 class="title">Crear Compra</h5>
                                  
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
                                    N°Compra
                                </th>
                                <th class="text-center">
                                    Estado
                                </th>
                                <th class="text-center">
                                    proveedor
                                </th>
                                
                                <th class="text-center">
                                    Total
                                </th>                            
                                <th class="text-center">
                                    Opciones
                                </th>
                            </thead>
                            @foreach( $Cargarcompras as $CargarCompra )
                            <?php
                                $nombreEstadoCompra =  $CargarCompra -> estadoCompras();
                                $nombreProveedor = $CargarCompra -> proveedors();
                            ?>
                                <tr>
                                        <td class="text-center">{{ $CargarCompra -> id }}</td>
                                        @if( $CargarCompra -> estadoCompras() != "" ||  $CargarCompra -> estadoCompras() != null )
                                        <td class="text-center">{{  $CargarCompra -> estadoCompras() -> nombre }}</td> 
                                        @else
                                        <td class="text-center">0</td> 
                                        @endif
                                          {{-- proveedires esta vacio debe validar eso  --}}
                                        @if( $CargarCompra -> proveedors() != "" || $CargarCompra -> proveedors() != null )
                                        <td class="text-center">{{ $CargarCompra -> proveedors() -> name }}</td>
                                        @else 
                                        <td class="text-center">Sin Definir</td>
                                        @endif
                                        @if($CargarCompra->total != null ||$CargarCompra->total != "")                                           
                                        <td class="text-center">{{ $CargarCompra -> total }}</td>
                                        @else
                                        <td class="text-center">0</td>
                                        @endif
                                        <td class="td-actions text-center">
                                            <form  method="post" class="delete">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
        
                                                @if($Cargarcompras[0]->fk_estado_compra ==1)
                                                <a href="{{ url('/compracabeza/'.$CargarCompra->id.'/edit') }}" rel="tooltip" title="Editar Compra{{ $CargarCompra -> id }}" class="btn btn-success btn-simple btn-xs">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                               
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
            @if($Cargarcompras[0]->fk_estado_compra ==1)
    
                    <form style="margin: 0; padding: 0;" id="AgregarCompra" action="{{url('/AgregarCompraEditar')}}" method="post" onsubmit="return validacionAgregar()">
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
                                                      <option class="form-control" value="0" selected>Compra individual</option>
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
                                                  {{-- onclick="MostrarCanastaIndividual();" --}}
                                              <label>Cantidad</label>
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
                                                     <button class="btn btn-info btn-round" id="OcltarBotonSubmit" type="submit"><i class="now-ui-icons add">Agregar</i></button>
                                                   </center>
                                                   <center>
                                                     <button class="btn btn-info btn-round" id="OcultarBotonModal" type="submit" onclick='AbrirModalCanasta();'  style=" display : none"><i class="now-ui-icons add">Agregar canasta</i></button>
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
                                {{-- @if($Cargarcompras[0]->fk_estado_compra !=1)
                                <th class="text-center">
                                    Cantidad Devolucion
                                </th>
    
                                @endif --}}
                                                     
                              
                              
                               
                                <th class="text-center">
                                    Precio Compra
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
                               @foreach( $Detalle_compras as $Detalle_compra )
                               <tr>
                                <?php
                                    
                                     $NombreProducto =  $Detalle_compra->producto();
                                     $PrecioProducto = $Detalle_compra->producto();
                                     $envase=$Detalle_compra->empaque();
                                     $marca=$Detalle_compra->productoMarca();
                                      $IdCompra =$Detalle_compra ->fk_compra;
                                      $subtotal=$Detalle_compra->precio * $Detalle_compra->cantidad;
                                      $total=$total+$subtotal;
                                      $canasta= $Detalle_compra->Numero_canasta;
                                      if($canasta==null || $canasta==0 || $canasta==-1 || $canasta==-2 )
                                     {
                                        $canasta=0;
                                     }                                                                          
                                 ?>
                                 {{-- {{$marca->nombre}} --}}
                                 <input type="text" id="idfac" value="{{$IdCompra}}" name="idfac" hidden="true">
 
                                 @if($Detalle_compra->Numero_canasta !=null && $Detalle_compra->Numero_canasta != 0 && $Detalle_compra->Numero_canasta != -1 && $Detalle_compra->Numero_canasta != -2)
                                 
                                 <th class="text-center">{{  $Detalle_compra -> Numero_canasta }}</td>                               
                                 @else                                
                                     <th class="text-center"> </td>                                 
                                 @endif
                                
                                   @if($Detalle_compra->Numero_canasta ==-1)
                                  <th class="text-center">{{  $envase -> nombre.'-'.$marca->nombre}}</td>
                                   
                                   @elseif($Detalle_compra->Numero_canasta >0 || $Detalle_compra->Numero_canasta ==-2)
                                  <th class="text-center">{{  $NombreProducto -> nombre.'-'.$marca->nombre }}</td>
                                   @elseif($Detalle_compra->Numero_canasta ==0 )
                                   <th class="text-center">{{'envases-'.$marca->nombre}}</td>
                                   @endif
                                     
                                 
                                  @if($Detalle_compra->Numero_canasta ==null || $Detalle_compra->Numero_canasta == -2 || $Detalle_compra->Numero_canasta == -1)
                                  
                                     <th class="text-center"><input name='{{$Detalle_compra -> id}}' type="number" value='{{$Detalle_compra -> cantidad}}' class="number"  MIN="1" STEP="1" SIZE="6" id="number" onchange="agregarCantidad(this.name,this.value);"></td>
                                  
                                  @else
                                  <th class="text-center"><input name='{{$Detalle_compra -> id}}' type="number" value='{{$Detalle_compra -> cantidad}}' class="number "  MIN="1" STEP="1" SIZE="6" id="number"  style="background-color:#ff0000" disabled></td>
                                  @endif
                                       
                                           {{-- <td>{{ $Detalle_compra -> cantidad }}</td> --}}
                                           <th class="text-center">{{ $Detalle_compra-> precio }}</td>
                                           <th class="text-center">{{ $Detalle_compra-> precio * $Detalle_compra-> cantidad }} </td>
                                           
                                           <th class="text-center">
                                                @if($Cargarcompras[0]->fk_estado_compra ==1)
                                            <form  style="margin: 0; padding: 0;"  action="{{url('/detallecompraEdit/'.$Detalle_compra->id.'/'.$canasta)}}" method="post">
                                                {{ csrf_field() }}
                                                   {{-- {{ method_field('DELETE') }}    --}}
                                                   
                                                   <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                       <i class="fa fa-times"></i>
                                                   </button> 
                                               </form>
                                             </th>
                                             @endif
                                             {{-- @if($Cargarcompras[0]->fk_estado_compra !=1)
                                             
                                                <form  style="margin: 0; padding: 0;"  action="{{url('/compra/agregarCantidadDevolucion')}}" method="post">
                                                    {{ csrf_field() }}
                                                     
                                                       @if($Cargarcompras[0]->fk_estado_compra !=1)
                                                       <th class="text-center"><input name="fk_cantidad" type="number" value='{{$cantidad}}' class="number "  MIN="1" STEP="1" MAX='{{$Detalle_compra -> cantidad}}' SIZE="6" id="number" ></td>
                                                      <input type="text" name="id"  value='{{$Detalle_compra->id}}' hidden="true" >
                                                       @endif
                                                       <th class="text-center">
                                                       <button type="submit" rel="tooltip" title="devolver" class="btn btn-danger btn-simple btn-xs">
                                                           <i class="now-ui-icons arrows-1_share-66"></i>
                                                       </button> 
                                                    </th>
                                                   </form>
                                                
                                                 @endif --}}
                                           </td>
                                       </tr>
                                       @endforeach
                            </tbody>
                            
                        </table>
                        <hr>
                        <h3 class="text-center"><strong>Total:{{$total}}</strong></h3>
                        @if($total !=0)
                        @if($Cargarcompras[0]->fk_estado_compra ==1)
                       <div class="row text-center">
                            
                             <div class="col-md-6">
                                 <div class="form-group">
                                    
                                    <a href="{{ action('compraController@cerrarSesion',['idSession' => 2]) }}" class="btn btn-success btn-round">pendiente</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        
                                    <a href="{{ action('compraController@update',['id' => $IdCompra,'estado'=>4]) }}"  class="btn btn-info btn-round" >por recibir</a>
                                    </div>
                            </div>
    
                             <div class="col-md-6">
                                <div class="form-group">
                                    
                                <a href="{{ action('compraController@update',['id' => $IdCompra,'estado'=>0]) }}"  class="btn btn-info btn-round" >registar</a>
                                {{-- target="_blank()" codigo para nueva pestaña --}}
                                </div>
                            </div>
                        </div>
                        @endif
                        @else
                        @if($Cargarcompras[0]->fk_estado_compra ==1)
                        <div class="col-md-6">
                                <div class="form-group">
                                   
                                   <a href="{{ action('compraController@cerrarSesion',['idSession' => 2]) }}" class="btn btn-success btn-round">pendiente</a>
                               </div>
                           </div>
                        @endif
                        @endif
                       
                    </div>
                </div>
        
            </div>
        
    </div>
    
    @if($Cargarcompras[0]->fk_estado_compra !=1)
    <span  data-notify="message"> <h2 class="text-center">no se puede editar ya se facturo</h2></span>
    <div class="col-md-4">
            <div class="form-group">
               
               <a href="{{ action('compraController@cerrarSesion',['idSession' => 2]) }}"  class="btn btn-success btn-round">Regresar</a>
           </div>
       </div>
    @endif
@endsection



@section('scripts')


    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('/js/typeahead.bundle.min.js')}}"></script>
     <script src="{{asset('/js/scriptcompraEditar.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   

    
    
@endsection