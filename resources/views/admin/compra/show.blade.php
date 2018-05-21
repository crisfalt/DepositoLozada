@extends('layouts.app')

@section('title','Compra')


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Compra')

@section('header-class')

<div class="panel-header panel-header-sm">
</div>
@endsection


<!-- <style>




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
</style> -->
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
                                   <h5 class="title">Mirar Compra</h5>
                                  
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
                                        
                                    </tr>
                                    @endforeach
                  
                   
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
                                   
                                <th class="text-center">
                                    Precio Compra
                                </th>
                                <th class="text-center">
                                    SubTotal
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
                                           
                                            $IdCompra =$Detalle_compra ->fk_compra; 
                                            $subtotal=$Detalle_compra->precio * $Detalle_compra->cantidad;
                                            $total=$total+$subtotal;
                                            $canasta= $Detalle_compra->Numero_canasta;
                                            $cantidad=0;
                                         if($canasta==null)
                                         {
                                            $canasta=0;
                                         }
       
       
       
                                           
                                       ?>
       
       
                                       @if($Detalle_compra->Numero_canasta !=null)
                                       
                                           <th class="text-center">{{  $Detalle_compra -> Numero_canasta }}</td>
       
                                       
                                       @else
                                       
                                           <th class="text-center"> </td> 
                                       
                                       @endif
                                       @if($envase!=null)
                                       @if($envase->precio != 0)
                                       
                                       <th class="text-center">{{  $envase -> nombre }}</td>
                                       @else
                                       <th class="text-center">{{  $NombreProducto -> nombre }}</td>
                                       @endif
       
                                       @else
                                         <th class="text-center">{{  $NombreProducto -> nombre }}</td>
                                           
                                        @endif
                                        @if($Detalle_compra->Numero_canasta ==null)
                                            @if($Cargarcompras[0]->fk_estado_compra ==1)
                                        
                                           <th class="text-center"><input name='{{$Detalle_compra -> id}}' type="number" value='{{$Detalle_compra -> cantidad}}' class="number"  id="number"    ></td>
                                             @elseif($Cargarcompras[0]->fk_estado_compra <=3)
                                        
                                            <th class="text-center"><input name='{{$Detalle_compra -> id}}' type="text" value='{{$Detalle_compra -> cantidad}}' class="number"   id="number" disabled></td>
                                                       
                                            @endif
                                        @else
                                        
                                        <th class="text-center"><input name='{{$Detalle_compra -> id}}' type="text" value='{{$Detalle_compra -> cantidad}}' class="number " id="number"   disabled></td>
                                        @endif
                                       
                                             
                                           <th class="text-center">{{ $Detalle_compra-> precio }}</td>
                                           <th class="text-center">{{ $Detalle_compra-> precio * $Detalle_compra-> cantidad }} </td>
                                           
                                           
                                             
                                                
                                                    
                                           </td>
                                       </tr>
                                       @endforeach
                            </tbody>
                            
                        </table>
                        <hr>
                        <h3 class="text-center"><strong>Total:{{$total}}</strong></h3>
                         

                         <div class="col-md-4">
                            <div class="form-group">
                               
                               <a href="{{ action('compraController@cerrarSesion',['idSession' => 2]) }}"  class="btn btn-danger btn-round">Regresar</a>
                           </div>
                        </div>
                       
                    </div>
                </div>
        
            </div>


        
    </div>
    
    
    
    
   
@endsection



@section('scripts')


    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('/js/typeahead.bundle.min.js')}}"></script>
 <!--     <script src="{{asset('/js/scriptcompraEditar.js')}}"></script -->>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   

    
    
@endsection