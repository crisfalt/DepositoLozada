<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Venta;
use App\Bodega;
use App\EstadoDeVenta;
use App\User;
use App\formapago;
use Session;
use App\Producto;
use DateTime;
use App\detalles_venta;
use App\CartDetail;
use App\Cliente;
use App\PreciosProducto;
use App\TipoPaca;
use App\Marca; 
use App\TipoContenido;
use Carbon\Carbon;
use App\abonoVenta;


use Auth;


class VentaController extends Controller

    {

        public function abonar() 
        {
            $id_factura= $_POST["id_factura"];
            $saldo= $_POST["saldo"];
            $abono= $_POST["abono"];
            $fechaAbono= Carbon::now()->toDateString();
            $resta=$saldo-$abono;
            $notification="";
            if($saldo==$abono)
            {
                 DB::table('ventas')
                ->where('id',$id_factura)      
                ->update(['fk_forma_de_pago' => 1,'saldo' => $resta]);
                //inserta tabla abono
                $objAbono = new abonoVenta();
                $objAbono -> valor = (float)$abono; 
                $objAbono -> fecha = $fechaAbono;                  
                $objAbono -> fk_venta = $id_factura;
                $objAbono->save();
                $notification = 'la factura fue pagada exitosamente '. $id_factura;
            }
            else
            {
                DB::table('ventas')
                ->where('id',$id_factura)      
                ->update(['saldo' => $resta]);
                //inserta tabla abono
                $objAbono = new abonoVenta();
                $objAbono -> valor = (float)$abono; 
                $objAbono -> fecha = $fechaAbono;                  
                $objAbono -> fk_venta = $id_factura;
                $objAbono->save();
                $notification = 'el abono se realizo exitosamente de la factura '. $id_factura;
            }
            return response()->json( ['mensaje'=>$notification ] );  
        }
    
        public function BuscarCliente() 
        {
           
            $id_cliente= $_POST["id_cliente"];
            $CedulaCliente=explode(',',$id_cliente);
            $ConsultarDeuda=DB::table('ventas')->where('fk_cliente',$CedulaCliente[0] )->where('fk_forma_de_pago',2)->get();
            // dd( $ConsultarDeuda);
            return response()->json( ['items'=>$ConsultarDeuda ] );  
        }


        public function ActualizarHoraEntrega() 
        {
            $notificacion="";
            $factura_id= $_POST["id_factura"];
            $actualizar_hora= $_POST["actualizar_hora"];
            
            $ConsultarFacturaVenta=DB::table('ventas')->where('id',$factura_id )->get();
            if(count($ConsultarFacturaVenta) !=0)
            {
                if($ConsultarFacturaVenta[0]->fk_estado_venta ==1 || $ConsultarFacturaVenta[0]->fk_estado_venta == 2)
                {
                    DB::table('ventas')
                        ->where('id',$factura_id)
                        ->update(['hora' =>$actualizar_hora]);
                    $notificacion=("se actualizo la hora de entrega de la factura #".$factura_id);
                }
                else
                {
                    $notificacion=("no se puede editar la hora entrega por que ya se facturo :(");
                }
            }
            return response()->json( ['items'=>$notificacion ] );  
        }

        ////
        public function ActualizarFechaEntrega() 
        {
            $notificacion="";
            $factura_id= $_POST["id_factura"];
            $actualizar_fecha= $_POST["actualizar_fecha"];

            $ConsultarFacturaVenta=DB::table('ventas')->where('id',$factura_id )->get();
            if(count($ConsultarFacturaVenta) !=0)
            {
                if($ConsultarFacturaVenta[0]->fk_estado_venta ==1 || $ConsultarFacturaVenta[0]->fk_estado_venta == 2)
                {
                    DB::table('ventas')
                        ->where('id',$factura_id)
                        ->update(['fecha_entrega' =>$actualizar_fecha]);
                    $notificacion=("se actualizo la fecha de entrega de la factura #".$factura_id);
                }
                else
                {
                    $notificacion=("no se puede editar la fecha entrega por que ya se facturo :(");
                }
            }
            return response()->json( ['items'=>$notificacion ] );  
        }
        ////

        public function AgregarCanastaEditar() 
        {
            $productoID= $_POST["ids"];
            $productoCantidad= $_POST["cantidad"];
            $productoCantidadCanasta= $_POST["cantidadCanasta"];
            $productoCantidadEnvase= $_POST["cantidadEnvase"];
            $productoTipoPaca= $_POST["tipoPaca"];
            $productoCantidadPlastico= $_POST["cantidadPlastico"];
            $cantidadCanasta=$_POST["cantidadcanasta"];
            $datos=$_POST["datosCanasta"];
            $IdVenta= session::get('IdVentaEditar');
            $ObtenerCombo=DB::table('tipo_pacas')->where('id', $productoTipoPaca)->value('cantidad');
            $total=0;
            $tmp=0;
            $totalCanasta=$productoCantidadCanasta * $ObtenerCombo;
            $ObteneIDcanasta=DB::table('detalles_ventas')->where('fk_factura','=',$IdVenta)->max('Numero_canasta');
            if($ObteneIDcanasta==null)
            {
                $ObteneIDcanasta=0; 
            }
      
            for( $j = 0 ; $j < $cantidadCanasta ; $j++ ) {
                $ObteneIDcanasta=$ObteneIDcanasta + 1;
            
                for( $i = 0 ; $i < count($datos) ; $i++ ) 
                {

                    if($productoCantidad[$tmp] !=0)
                    {
                        $DatoPrecio= DB::table('precios_productos')                        
                        ->join('productos',
                            'precios_productos.fk_producto',
                            '=',
                            'productos.codigo'
                        ) 
                                            
                    ->where('productos.codigo','=', $productoID[$tmp])
                                    
                        ->min('precios_productos.valor');
                
            
                        DB::table('detalles_ventas')->insert([
                            ['precio' => $DatoPrecio, 'cantidad' =>$productoCantidad[$tmp],'fk_tipo_paca'=>0,'fk_factura'=>$IdVenta,'fk_producto'=>$productoID[$tmp],'Numero_canasta' =>$ObteneIDcanasta]]);
                        
            
                    }
                    $tmp++; 
                }
            }

            ////canasta y envases Editar

            $consultaTipoPaca=DB::table('productos')->where('codigo',$productoID)->value('fk_tipo_paca');
            
            
            $consultaIDCanasta=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('fk_tipo_paca',$productoTipoPaca)->get();

            
            
            if($consultaTipoPaca!=null)
            {
                
                if($productoCantidadEnvase!=null && $productoCantidadEnvase!=0)
                {
                    $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get(); 
                    if(count($consultaIDCanasta)!=0)
                    {
                    // dd($consultaIDCanasta[0]-> cantidad,$productoCantidadEnvase);
                    
                        DB::table('detalles_ventas')
                        ->where('fk_tipo_paca',$consultaTipoPaca)
                        ->where('fk_factura',$IdVenta)
                        ->where('precio',$consultarEnvases[0]->precio_envase)
                        ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadEnvase]);
                    
                    }
                    else
                    {
                        DB::table('detalles_ventas')->insert([
                            ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$productoCantidadEnvase,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                        ]);
                    }
                
                }

                if($productoCantidadPlastico!=null && $productoCantidadPlastico!=0 )
                {
                    $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
                    //    foreach($consultarEnvases as $consultarEnvase)
                    //    {
                    //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
                        
                    //    }
                        
                        if(count($consultaIDCanasta)!=0)
                        {
                        // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
                        
                            DB::table('detalles_ventas')
                            ->where('fk_tipo_paca',$productoTipoPaca)
                            ->where('fk_factura',$IdVenta)
                            ->where('precio',$consultarEnvases[0]->precio)
                            ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadPlastico]);
                        
                        }
                        else
                        {
                            
                        //  $TotaEnvases=$DividirPrecio * $precio;
                            DB::table('detalles_ventas')->insert([
                            ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$productoCantidadPlastico,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                            
                        ]);
                            }


                }

            } 

            $notificacion=("Se agrego exitosamente");
            return response()->json( ['items'=>$notificacion ] );            
        }



        //listar Canasta
      
        public function ConsultarCanastaEditar($tipopaca) 

        {
            $marca = Session::get('IdMarcaEditar');
            $contenido = Session::get('IdContenidoEditar');
   

            if($tipopaca!=0)
            {
         
            $ObtenerProductos=DB::table('productos')->where('fk_tipo_paca',$tipopaca)->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();//obtengo los productos con una marca,tipo cotenido,tipo empaque
            $cantidadCanasta=DB::table('tipo_pacas')->where('id',$tipopaca)->value('cantidad');
        
            }
            else
            {
                $cantidadCanasta=0;
                $ObtenerProductos=0;
            }

// dd($cantidadCanasta);
            return response()->json( [ 'items'=>$ObtenerProductos,'cantidadCanasta'=>$cantidadCanasta ] );

        }

        public function tipoContenidoEditar($id) 
        {

             
            $ListarTipoContenido= DB::table('productos')                        
            ->join('marcas','productos.fk_marca','=','marcas.id')
            ->join('tipo_contenidos','productos.fk_tipo_contenido','=','tipo_contenidos.id')
            ->select('tipo_contenidos.id','tipo_contenidos.nombre')                
            ->where('productos.fk_marca','=',$id)
            ->groupBy('tipo_contenidos.id')
            ->get();
            Session::put('IdMarcaEditar',$id);
            $ListarMarcas=DB::table('productos')->where('fk_marca',$id)->select('codigo','nombre')->get(); 
           
            $array = Array();
            $array[ 0 ] = $ListarTipoContenido;
            $array[ 1 ] = $ListarMarcas;
            return response()->json( [ 'items'=>$array ] );
        }

        public function tipoPacaEditar($id) 
        {
            $marca = Session::get('IdMarcaEditar');
            Session::put('IdContenidoEditar',$id);
            

     $ListarTipoPaca= DB::table('productos')                        
            ->join('marcas',
                   'productos.fk_marca',
                   '=',
                   'marcas.id'
                  )   
            ->join('tipo_pacas',
                    'productos.fk_tipo_paca',
                    '=',
                    'tipo_pacas.id'
                   )
            ->join('tipo_contenidos',
                    'productos.fk_tipo_contenido',
                    '=',
                    'tipo_contenidos.id'
                   )
            ->select('tipo_pacas.id',
                     'tipo_pacas.nombre'
                    ) 
            ->where([
                ['fk_marca', '=',$marca],
                ['fk_tipo_contenido', '=', $id]
            ])
            ->groupBy('tipo_pacas.id')                       
            ->get();
// dd($ListarTipoPaca);

            $ObtenerProductoTipoPaca=DB::table('productos')->where('fk_tipo_contenido',$id)->where('fk_marca',$marca)->get();//obtengo los productos con una marca
            return response()->json(['items'=> $ListarTipoPaca,'FiltroProducto'=>$ObtenerProductoTipoPaca]);
        }
        public function ProductoEditar($id) 
        {
         
            $marca = Session::get('IdMarcaEditar');
            $contenido = Session::get('IdContenidoEditar');
            Session::put('Tipo_pacaEditar',$id);




          
            if($id!=0)
            {
         
            $ObtenerProductos=DB::table('productos')->where('fk_tipo_paca',$id)->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();//obtengo los productos con una marca,tipo cotenido,tipo empaque
            }
            else
            {
                $ObtenerProductos=DB::table('productos')->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();
            }

            
           Session::put('productoEditar', $ObtenerProductos);

            $arrayN = array();
            $arrayId = array();
            foreach($ObtenerProductos as $ObtenerProducto)
            {

         
            
                array_push($arrayN,$ObtenerProducto -> nombre);
                array_push($arrayId,$ObtenerProducto-> codigo);

            }

            $ObtenerIdCanastaRetornable=0;
            if(0 ==$id)
            {
                $ObtenerIdCanastaRetornable=$id;
            
            }
            else
            {
                $retornable=DB::table('tipo_pacas')->where('id',$id)->select('retornable')->get(); 
                $ObtenerIdCanastaRetornable=$retornable[0]->retornable;
            }

            $array = array( $arrayN , $arrayId );
                //   dd($ObtenerIdCanastaRetornable);
            return response()->json(['items'=>  $array,'id'=>$id,'retornable'=>$ObtenerIdCanastaRetornable]);
        }


        ////// filtro combox y garegar por canastas create
        public function AgregarCanasta() 

        {
       $productoID= $_POST["ids"];
       $productoCantidad= $_POST["cantidad"];
       $productoCantidadCanasta= $_POST["cantidadCanasta"];
       $productoCantidadEnvase= $_POST["cantidadEnvase"];
       $productoTipoPaca= $_POST["tipoPaca"];
       $productoCantidadPlastico= $_POST["cantidadPlastico"];
       $cantidadCanasta=$_POST["cantidadcanasta"];
       $datos=$_POST["datosCanasta"];

//    dd($productoCantidad,$productoID);
       $IdVenta= session::get('IdVenta');
       $ObtenerCombo=DB::table('tipo_pacas')->where('id', $productoTipoPaca)->value('cantidad');
        $total=0;
        $tmp=0;
        $totalCanasta=$productoCantidadCanasta * $ObtenerCombo;
      
        $ObteneIDcanasta=DB::table('detalles_ventas')->where('fk_factura','=',$IdVenta)->max('Numero_canasta');
    //    $ContadorCanasta=0;

        if($ObteneIDcanasta==null)
        {
            $ObteneIDcanasta=0; 
        }
      
        for( $j = 0 ; $j < $cantidadCanasta ; $j++ ) {
            $ObteneIDcanasta=$ObteneIDcanasta + 1;
           
            for( $i = 0 ; $i < count($datos) ; $i++ ) 
            {

                 if($productoCantidad[$tmp] !=0)
                 {
                    $DatoPrecio= DB::table('precios_productos')                        
                    ->join('productos',
                        'precios_productos.fk_producto',
                        '=',
                        'productos.codigo'
                       ) 
                                         
                   ->where('productos.codigo','=', $productoID[$tmp])
                                 
                     ->min('precios_productos.valor');
               
         
                     DB::table('detalles_ventas')->insert([
                         ['precio' => $DatoPrecio, 'cantidad' =>$productoCantidad[$tmp],'fk_tipo_paca'=>0,'fk_factura'=>$IdVenta,'fk_producto'=>$productoID[$tmp],'Numero_canasta' =>$ObteneIDcanasta]]);
                     
         
                 }
               
             
                 $tmp++; 
               
            }
          
           
           
          }

      ////canasta y envases

       $consultaTipoPaca=DB::table('productos')->where('codigo',$productoID)->value('fk_tipo_paca');
      
      
       $consultaIDCanasta=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('fk_tipo_paca',$productoTipoPaca)->get();

      
      
       if($consultaTipoPaca!=null)
       {
           
           if($productoCantidadEnvase!=null && $productoCantidadEnvase!=0)
           {
             
           $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
      
         
          if(count($consultaIDCanasta)!=0)
          {
           // dd($consultaIDCanasta[0]-> cantidad,$productoCantidadEnvase);
          
               DB::table('detalles_ventas')
               ->where('fk_tipo_paca',$consultaTipoPaca)
               ->where('fk_factura',$IdVenta)
               ->where('precio',$consultarEnvases[0]->precio_envase)
               ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadEnvase]);
           
          }
           else
           {
              
           //  $TotaEnvases=$DividirPrecio * $precio;
            DB::table('detalles_ventas')->insert([
               ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$productoCantidadEnvase,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
             
           ]);
            }
           
           }

           if($productoCantidadPlastico!=null && $productoCantidadPlastico!=0 )
           {
               $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
               //    foreach($consultarEnvases as $consultarEnvase)
               //    {
               //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
                   
               //    }
                 
                  if(count($consultaIDCanasta)!=0)
                  {
                   // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
                  
                       DB::table('detalles_ventas')
                       ->where('fk_tipo_paca',$productoTipoPaca)
                       ->where('fk_factura',$IdVenta)
                       ->where('precio',$consultarEnvases[0]->precio)
                       ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadPlastico]);
                   
                  }
                   else
                   {
                      
                   //  $TotaEnvases=$DividirPrecio * $precio;
                    DB::table('detalles_ventas')->insert([
                       ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$productoCantidadPlastico,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                     
                   ]);
                    }


           }

       } 

$notificacion=("Se agrego exitosamente");

            return response()->json( ['items'=>$notificacion ] );            
        }



        //listar Canasta
      
        public function ConsultarCanasta($tipopaca) 

        {
            $marca = Session::get('IdMarca');
            $contenido = Session::get('IdContenido');
   

            if($tipopaca!=0)
            {
         
            $ObtenerProductos=DB::table('productos')->where('fk_tipo_paca',$tipopaca)->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();//obtengo los productos con una marca,tipo cotenido,tipo empaque
            $cantidadCanasta=DB::table('tipo_pacas')->where('id',$tipopaca)->value('cantidad');
        
            }
            else
            {
                $cantidadCanasta=0;
                $ObtenerProductos=0;
            }

// dd($cantidadCanasta);
            return response()->json( [ 'items'=>$ObtenerProductos,'cantidadCanasta'=>$cantidadCanasta ] );

        }

        public function tipoContenido($id) 
        {

             
            $ListarTipoContenido= DB::table('productos')                        
            ->join('marcas','productos.fk_marca','=','marcas.id')
            ->join('tipo_contenidos','productos.fk_tipo_contenido','=','tipo_contenidos.id')
            ->select('tipo_contenidos.id','tipo_contenidos.nombre')                
            ->where('productos.fk_marca','=',$id)
            ->groupBy('tipo_contenidos.id')
            ->get();
            Session::put('IdMarca',$id);
            $ListarMarcas=DB::table('productos')->where('fk_marca',$id)->select('codigo','nombre')->get(); 

            
            // console.log( $ListarMarcas );
            // $ListarComoboPorMarca = json_encode(array('user' => $id));
            // dd($ListarComoboPorMarca);
            
// dd($ListarTipoContenido);
          
           
            // $arrayN = array();
            // $arrayId = array();
            // Session::put('IdMarca',$id);
            
          

            // foreach($ObtenerTipoContenidos as $ObtenerTipoContenido)
            // {

            //     $agrupar=DB::table('tipo_contenidos')->where('id',$ObtenerTipoContenido->fk_tipo_contenido)->get();
            //     array_push($arrayN,$agrupar[0] -> nombre);
            //     array_push($arrayId,$agrupar[0] -> id);

            // }
            // $array = array( $arrayN , $arrayId );
            // foreach( $array as $valor ) {
            //     dd($valor);
            // }
           
            $array = Array();
            $array[ 0 ] = $ListarTipoContenido;
            $array[ 1 ] = $ListarMarcas;
            return response()->json( [ 'items'=>$array ] );
        }

        public function tipoPaca($id) 
        {
            $marca = Session::get('IdMarca');
            Session::put('IdContenido',$id);
            

     $ListarTipoPaca= DB::table('productos')                        
            ->join('marcas',
                   'productos.fk_marca',
                   '=',
                   'marcas.id'
                  )   
            ->join('tipo_pacas',
                    'productos.fk_tipo_paca',
                    '=',
                    'tipo_pacas.id'
                   )
            ->join('tipo_contenidos',
                    'productos.fk_tipo_contenido',
                    '=',
                    'tipo_contenidos.id'
                   )
            ->select('tipo_pacas.id',
                     'tipo_pacas.nombre'
                    ) 
            ->where([
                ['fk_marca', '=',$marca],
                ['fk_tipo_contenido', '=', $id]
            ])
            ->groupBy('tipo_pacas.id')                       
            ->get();
// dd($ListarTipoPaca);

            $ObtenerProductoTipoPaca=DB::table('productos')->where('fk_tipo_contenido',$id)->where('fk_marca',$marca)->get();//obtengo los productos con una marca
          
            // $arrayN = array();
            // $arrayId = array();
            // foreach($ObtenerProductoTipoPaca as $ObtenerTipoPaca)
            // {

            //     $agrupar=DB::table('tipo_pacas')->where('id',$ObtenerTipoPaca->fk_tipo_paca)->get();
            
            //     array_push($arrayN,$agrupar[0] -> nombre);
            //     array_push($arrayId,$agrupar[0] -> id);

            // }
            // $array = array( $arrayN , $arrayId );
                  
            return response()->json(['items'=> $ListarTipoPaca,'FiltroProducto'=>$ObtenerProductoTipoPaca]);
        }
        public function Producto($id) 
        {
         
            $marca = Session::get('IdMarca');
            $contenido = Session::get('IdContenido');
            Session::put('Tipo_paca',$id);




          
            if($id!=0)
            {
         
            $ObtenerProductos=DB::table('productos')->where('fk_tipo_paca',$id)->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();//obtengo los productos con una marca,tipo cotenido,tipo empaque
            }
            else
            {
                $ObtenerProductos=DB::table('productos')->where('fk_marca',$marca)->where('fk_tipo_contenido',$contenido)->get();
            }

            
           Session::put('producto', $ObtenerProductos);

            $arrayN = array();
            $arrayId = array();
            foreach($ObtenerProductos as $ObtenerProducto)
            {

         
            
                array_push($arrayN,$ObtenerProducto -> nombre);
                array_push($arrayId,$ObtenerProducto-> codigo);

            }

            $ObtenerIdCanastaRetornable=0;
            if(0 ==$id)
            {
                $ObtenerIdCanastaRetornable=$id;
            
            }
            else
            {
                $retornable=DB::table('tipo_pacas')->where('id',$id)->select('retornable')->get(); 
                $ObtenerIdCanastaRetornable=$retornable[0]->retornable;
            }

            $array = array( $arrayN , $arrayId );
                //   dd($ObtenerIdCanastaRetornable);
            return response()->json(['items'=>  $array,'id'=>$id,'retornable'=>$ObtenerIdCanastaRetornable]);
        }


        public function agregrarCantidad($cantidad,$id) 
        {
            // dd("aqui responde laravel " . $cantidad . " la id : " . $id );
            // 
            
            
            $ObtenerIdProducto= Session::get('IdVenta');
    
    
            DB::table('detalles_ventas')
            ->where('id',$id)
            ->where('fk_factura',$ObtenerIdProducto)
            ->update(['cantidad' => $cantidad]);
    
           return redirect('admin.venta.create') -> with( compact( 'ObtenerIdProducto' ) );
            // return response()->json(['reponse'=> $cantidad]);
    
        }
        public function agregrarCantidadEditar($cantidad,$id) 
        {
              $ObtenerIdProducto= Session::get('IdVentaEditar');
    
     // dd("aqui responde laravel " . $cantidad . " la id : " . $id ."Id compra ".$ObtenerIdProducto);
          
            // dd($ObtenerIdProducto);
            DB::table('detalles_ventas')
            ->where('id',$id)
            ->where('fk_factura',$ObtenerIdProducto)
            ->update(['cantidad' => $cantidad]);
    
           return redirect('admin.venta.edit') -> with( compact( 'ObtenerIdProducto' ) );
            // return response()->json(['reponse'=> $cantidad]);
    
        }
        public function agregrarCantidadDevolucion(Request $request ) 
        {
             $request->input('fk_cantidad');
             $request->input('id');
            //  dd($request->input('id'));

              $ObtenerIdProducto= Session::get('IdVentaEditar');
              $Resta=0;
              $SumaTotalVenta=0;
    
     // dd("aqui responde laravel " . $cantidad . " la id : " . $id ."Id compra ".$ObtenerIdProducto);
$consultarDetalleVenta= DB::table('detalles_ventas')->where('id',(int)$request->input('id'))->where('fk_factura',$ObtenerIdProducto)->get();
$consultarProducto= DB::table('productos')->where('codigo',$consultarDetalleVenta[0]->fk_producto)->get();
// dd($consultarDetalleVenta);

     if(count($consultarDetalleVenta) !=0)
        {
            
    if( (int)$request->input('fk_cantidad') <= $consultarDetalleVenta[0]->cantidad )
     {
     
      $Resta= $consultarDetalleVenta[0]->cantidad-(int)$request->input('fk_cantidad');

      if($Resta==0)
      {
        $detalles_venta= detalles_venta::find(  $request->input('id'));
        $detalles_venta -> delete();
      }
      else
      {
            DB::table('detalles_ventas')
            ->where('id',$request->input('id'))
            ->where('fk_factura',$ObtenerIdProducto)
            ->update(['cantidad' => $consultarDetalleVenta[0]->cantidad-$request->input('fk_cantidad')]);
      }

            DB::table('productos')
            ->where('codigo',$consultarDetalleVenta[0]->fk_producto)
            
            ->update(['cantidad' => $consultarProducto[0]->cantidad +$request->input('fk_cantidad')]);

           $SumaTotalVenta= $consultarDetalleVenta[0]->precio * $request->input('fk_cantidad');
        $ObtenerTotalCompra= Venta::where( 'id',$consultarDetalleVenta[0]->fk_factura)->value('total');

             DB::table('ventas')
            ->where('id',$consultarDetalleVenta[0]->fk_factura)
            
            ->update(['total' => $ObtenerTotalCompra -$SumaTotalVenta]);
            $notification = 'se devolvieron '.(int)$request->input('fk_cantidad').' del prodcuto '.$consultarProducto[0]->nombre.' al inventario';


           }
           else
           {
            $notification = 'la cantidad de devolucion no debe ser mayor a la cantidad actual';
           
           }

        }
        else
        {
            $notification = 'error inesperado vuelva cargar la pagina';
            
        }
    
        return back() -> with( compact( 'notification' ) );
            // return response()->json(['reponse'=> $cantidad]);
    
        }
    
       


        public function cerrarSesion($idSession) 
        {
            
    
            if(1==$idSession)
            {
                Session::forget('IdVenta');
            return back();
            }
            else if(2==$idSession)
            {
            Session::forget('IdVentaEditar');
            // dd($idSession);
             return redirect('venta/');
            }
            else if(3==$idSession)
            {
            Session::forget('IdVenta');
            // dd($idSession);
             return back();
            }
    
        }

        public function AgregarVenta(Request $request )
        {
              
            $ObtenerIdProdcuto=explode(',',$request->input('fk_producto'));
            //    dd($request->input('fk_producto'));
               
                $request['fk_producto']=$ObtenerIdProdcuto[0];
                // dd($request->input('fk_tipo_paca'));
         
                                 
                $DatoPrecio= DB::table('precios_productos')                        
                            ->join('productos',
                                   'precios_productos.fk_producto',
                                   '=',
                                   'productos.codigo'
                                  ) 
                                                    
                            // ->select('productos.nombre',
                            //          'productos.codigo'
                            //         ) 
                            ->where('productos.codigo','=', $ObtenerIdProdcuto[0])
                                            
                           ->max('precios_productos.valor');
    
                        //    dd($ObtenerPrecio);
    
    
            $productos=DB::table('productos')->where('codigo',$ObtenerIdProdcuto[0])->value('fk_tipo_paca');
        
            $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');

            
      

            $this->validate($request,detalles_venta::$rules,detalles_venta::$messages);
            $notification = 'se agrego exitosamente';
            $detalle_venta = new detalles_venta();
             if( $request->input('cantidad') == null ) {
                $request['cantidad'] = 0;
               }
               
            //    $this->validate( $DatosVentas,detalles_venta::$rules,detalles_venta::$messages);
             
            
            $idVenta=$request->session()->get('IdVenta');
            $request['fk_factura']= $idVenta;
         
           
            $detalle_venta -> fk_tipo_paca = 0;
   
            $detalle_venta -> fk_producto = $ObtenerIdProdcuto[0];
           
            $detalle_venta -> fk_factura = $request->input('fk_factura');
            // $detalle_venta -> precio = $request->input('fk_precio');
            $detalle_venta -> cantidad = $request->input('cantidad');
            $precioVenta=($DatoPrecio);
          

            // $precioVenta = DB::table('precios_productos')->where('id',$precio)->value('valor');
            // dd($precioVenta );
            $detalle_venta -> precio= $precioVenta;
            $IdVenta= session::get('IdVenta');
            $ConsultarIDProducto = DB::table('detalles_ventas')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_factura', $IdVenta)->where('precio',$precioVenta)->get();
            // dd($ConsultarIDProducto);
            // $consultarPrecioProducto=DB::table('precios_productos')->where('fk_producto', $ObtenerIdProdcuto[0])->value('valor');

            $consultaTipoPaca=DB::table('productos')->where('codigo',$request->input('fk_producto'))->value('fk_tipo_paca');
            $consultaPrecioDetalle=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('precio',$precioVenta)->where('fk_producto',$ObtenerIdProdcuto[0])->value('precio');
           
            $consultaIDCanasta=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('fk_tipo_paca',$consultaTipoPaca)->get();
            $DividirPrecio=0;
            $SaberCombo=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
            $TotaEnvases=0;
      ////para el envase y canastas
      
 
            if($consultaTipoPaca!=null)
            {
                
                if($request->input('cantidadEnvases')!=null && $request->input('cantidadEnvases')!=0)
                {
                  
                $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
            //    foreach($consultarEnvases as $consultarEnvase)
            //    {
            //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
                
            //    }
              
               if(count($consultaIDCanasta)!=0)
               {
                // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
               
                    DB::table('detalles_ventas')
                    ->where('fk_tipo_paca',$consultaTipoPaca)
                    ->where('fk_factura',$IdVenta)
                    ->where('precio',$consultarEnvases[0]->precio_envase)
                    ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadEnvases')]);
                
               }
                else
                {
                   
                //  $TotaEnvases=$DividirPrecio * $precio;
                 DB::table('detalles_ventas')->insert([
                    ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$request->input('cantidadEnvases'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                  
                ]);
                 }
                
                }

                if($request->input('cantidadPlastico')!=null && $request->input('cantidadPlastico')!=0 )
                {
                    $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
                    //    foreach($consultarEnvases as $consultarEnvase)
                    //    {
                    //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
                        
                    //    }
                      
                       if(count($consultaIDCanasta)!=0)
                       {
                        // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
                       
                            DB::table('detalles_ventas')
                            ->where('fk_tipo_paca',$consultaTipoPaca)
                            ->where('fk_factura',$IdVenta)
                            ->where('precio',$consultarEnvases[0]->precio)
                            ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadPlastico')]);
                        
                       }
                        else
                        {
                           
                        //  $TotaEnvases=$DividirPrecio * $precio;
                         DB::table('detalles_ventas')->insert([
                            ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$request->input('cantidadPlastico'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                          
                        ]);
                         }


                }

            }   
           



            if(count($ConsultarIDProducto) != 0 && $precioVenta == $consultaPrecioDetalle)
             {

             
                 
                DB::table('detalles_ventas')
                ->where('fk_producto',($ObtenerIdProdcuto[0]))
                ->where('fk_factura',$IdVenta)
                ->where('precio',$precioVenta )
                ->update(['cantidad' => $ConsultarIDProducto[0]-> cantidad + $request->input('cantidad')]);
            }
            else {
   
                $detalle_venta-> save();
            }
           
             //registrar Pre detalle de venta
           
            $notification = 'se agrego exitosamente';
    
      
          
            return redirect('/venta/create') -> with( compact( 'detalle_venta' ) );
            
        }
    
    
        public function AgregarVentaEditar( Request $request )
        {
     
            


           
  $ObtenerIdProdcuto=explode(',',$request->input('fk_producto'));
  //    dd($request->input('fk_producto'));
     
      $request['fk_producto']=$ObtenerIdProdcuto[0];
      // dd($request->input('fk_tipo_paca'));

                       
      $DatoPrecio= DB::table('precios_productos')                        
                  ->join('productos',
                         'precios_productos.fk_producto',
                         '=',
                         'productos.codigo'
                        ) 
                                          
                  // ->select('productos.nombre',
                  //          'productos.codigo'
                  //         ) 
                  ->where('productos.codigo','=', $ObtenerIdProdcuto[0])
                                  
                 ->max('precios_productos.valor');

              //    dd($ObtenerPrecio);


  $productos=DB::table('productos')->where('codigo',$ObtenerIdProdcuto[0])->value('fk_tipo_paca');

  $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');

  

// dd($DatoPrecio);


  $this->validate($request,detalles_venta::$rules,detalles_venta::$messages);
  $notification = 'se agrego exitosamente';
  $detalle_venta = new detalles_venta();
   if( $request->input('cantidad') == null ) {
      $request['cantidad'] = 0;
     }
     
  //    $this->validate( $DatosVentas,detalles_venta::$rules,detalles_venta::$messages);
   
  
  $idVenta=$request->session()->get('IdVentaEditar');
  $request['fk_factura']= $idVenta;

 
  $detalle_venta -> fk_tipo_paca = 0;

  $detalle_venta -> fk_producto = $ObtenerIdProdcuto[0];
 
  $detalle_venta -> fk_factura = $request->input('fk_factura');
  // $detalle_venta -> precio = $request->input('fk_precio');
  $detalle_venta -> cantidad = $request->input('cantidad');
  $precioVenta=($DatoPrecio);


  // $precioVenta = DB::table('precios_productos')->where('id',$precio)->value('valor');
  // dd($precioVenta );
  $detalle_venta -> precio= $precioVenta;
  $IdVenta= session::get('IdVentaEditar');
  $ConsultarIDProducto = DB::table('detalles_ventas')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_factura', $IdVenta)->where('precio',$precioVenta)->get();
  // dd($ConsultarIDProducto);
  // $consultarPrecioProducto=DB::table('precios_productos')->where('fk_producto', $ObtenerIdProdcuto[0])->value('valor');

  $consultaTipoPaca=DB::table('productos')->where('codigo',$request->input('fk_producto'))->value('fk_tipo_paca');
  $consultaPrecioDetalle=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('precio',$precioVenta)->where('fk_producto',$ObtenerIdProdcuto[0])->value('precio');
 
  $consultaIDCanasta=DB::table('detalles_ventas')->where('fk_factura', $IdVenta)->where('fk_tipo_paca',$consultaTipoPaca)->get();
  $DividirPrecio=0;
  $SaberCombo=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
  $TotaEnvases=0;
////para el envase y canastas


  if($consultaTipoPaca!=null)
  {
      
      if($request->input('cantidadEnvases')!=null && $request->input('cantidadEnvases')!=0)
      {
        
      $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
  //    foreach($consultarEnvases as $consultarEnvase)
  //    {
  //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
      
  //    }
    
     if(count($consultaIDCanasta)!=0)
     {
      // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
     
          DB::table('detalles_ventas')
          ->where('fk_tipo_paca',$consultaTipoPaca)
          ->where('fk_factura',$IdVenta)
          ->where('precio',$consultarEnvases[0]->precio_envase)
          ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadEnvases')]);
      
     }
      else
      {
         
      //  $TotaEnvases=$DividirPrecio * $precio;
       DB::table('detalles_ventas')->insert([
          ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$request->input('cantidadEnvases'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
        
      ]);
       }
      
      }

      if($request->input('cantidadPlastico')!=null && $request->input('cantidadPlastico')!=0 )
      {
          $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
          //    foreach($consultarEnvases as $consultarEnvase)
          //    {
          //      $DividirPrecio=$consultarEnvase->precio / $consultarEnvase->cantidad;
              
          //    }
            
             if(count($consultaIDCanasta)!=0)
             {
              // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
             
                  DB::table('detalles_ventas')
                  ->where('fk_tipo_paca',$consultaTipoPaca)
                  ->where('fk_factura',$IdVenta)
                  ->where('precio',$consultarEnvases[0]->precio)
                  ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadPlastico')]);
              
             }
              else
              {
                 
              //  $TotaEnvases=$DividirPrecio * $precio;
               DB::table('detalles_ventas')->insert([
                  ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$request->input('cantidadPlastico'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_factura'=>(int)$IdVenta,'fk_producto'=>0 ]
                
              ]);
               }


      }

  }   
 



  if(count($ConsultarIDProducto) != 0 && $precioVenta == $consultaPrecioDetalle)
   {

   
       
      DB::table('detalles_ventas')
      ->where('fk_producto',($ObtenerIdProdcuto[0]))
      ->where('fk_factura',$IdVenta)
      ->where('precio',$precioVenta )
      ->update(['cantidad' => $ConsultarIDProducto[0]-> cantidad + $request->input('cantidad')]);
  }
  else {

      $detalle_venta-> save();
  }
 
   //registrar Pre detalle de venta
 
  $notification = 'se agrego exitosamente';

    
      
          
            return redirect('/venta/'.$IdVenta.'/edit') -> with( compact( 'detalle_venta' ) );
            
        }
 ///////mostrar canasta indivdual create

        public function MostrarCanastaIndividualEditar($id)
        {
         // var lDepartamento = from c in db.Departamento where c.IdPais == IDPais select new { c.ID, c.Nombre };
         $tipopaca= session::get('tipo_paca');
 // dd($id);
         if($tipopaca==null)
         {
             // 'productos.fk_marca','=',$id
     //  $ObtenerPrecio= DB::table('precios_productos')->where('fk_producto',$id, DB::raw("(select max('valor') from precios_productos)"))->get();
         // $ObtenerPrecio=DB::table('precios_productos')->where('fk_producto',$id)->select(max('fk_producto'))->get();
         
         // $ObtenerPrecio= DB::table('precios_productos')                        
         //                 ->join('productos',
         //                        'precios_productos.fk_producto',
         //                        '=',
         //                        'productos.codigo'
         //                       ) 
                                                 
         //                 // ->select('productos.nombre',
         //                 //          'productos.codigo'
         //                 //         ) 
         //                 ->where('productos.codigo','=',$id)
                                         
         //                ->max('precios_productos.valor');
 
                     //    dd($ObtenerPrecio);
 
 
         $productos=DB::table('productos')->where('codigo',$id)->value('fk_tipo_paca');
     
         $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');
         
         // dd($ObtenerPaca);
         }
     
 
     //    dd($ObtenerPrecio);
         return response()->json(['paca'=>$ObtenerPaca]);
         
        }

    ///////mostrar canasta indivdual create
       public function MostrarCanastaIndividual($id)
       {
        // var lDepartamento = from c in db.Departamento where c.IdPais == IDPais select new { c.ID, c.Nombre };
        $tipopaca= session::get('tipo_paca');
// dd($id);
        if($tipopaca==null)
        {
            // 'productos.fk_marca','=',$id
    //  $ObtenerPrecio= DB::table('precios_productos')->where('fk_producto',$id, DB::raw("(select max('valor') from precios_productos)"))->get();
        // $ObtenerPrecio=DB::table('precios_productos')->where('fk_producto',$id)->select(max('fk_producto'))->get();
        
        // $ObtenerPrecio= DB::table('precios_productos')                        
        //                 ->join('productos',
        //                        'precios_productos.fk_producto',
        //                        '=',
        //                        'productos.codigo'
        //                       ) 
                                                
        //                 // ->select('productos.nombre',
        //                 //          'productos.codigo'
        //                 //         ) 
        //                 ->where('productos.codigo','=',$id)
                                        
        //                ->max('precios_productos.valor');

                    //    dd($ObtenerPrecio);


        $productos=DB::table('productos')->where('codigo',$id)->value('fk_tipo_paca');
    
        $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');
        
        // dd($ObtenerPaca);
        }
    

    //    dd($ObtenerPrecio);
        return response()->json(['paca'=>$ObtenerPaca]);
        
       }

        //
        public function index() {
            $ventas = Venta::orderBy('id') -> get();
           
           


            return view('admin.venta.index')->with(compact('ventas')); //listado de tipos movimientos
        }
    
        //mostrar un tipo de movimiento
        public function show( $id ) {

            $Cargarventas = Venta::where('id',$id )->get();
            $Detalle_ventas=detalles_venta::where('fk_factura',$id)->get();
           
            return view('admin.venta.show')->with(compact('Detalle_ventas','Cargarventas'));
        }
    
        public function create( $id_cliente ) {

          

          
            $marcas = Marca::orderBy('nombre') -> get();
            $tipocontenidos = TipoContenido::orderBy('nombre') -> get();          
            // traigo el nombre del cliente
            $clientes = Cliente::orderBy('name') -> get();
            //traigo el nombre del vendedor
            // $idUsuario=(auth()->user()->cart->id);
            // $vendedores = User::orderBy('name',$idUsuario) -> get();
            //traigo el nombre del estadoventa
            $estadoEntregaVentas = EstadoDeVenta::orderBy('id') -> get();
            //traifo el nombre de la bodega
            $bodegas = Bodega::orderBy('nombre') -> get();
            //traigo el nombre  de formapago
            $formaPagos=formapago::orderby('nombre')->get();
            //traigo el id de la variable sesion
            $value= session::get('IdVenta');
            //traigo todos los productos
            $productos=producto::all();
            //traigo el id de la venta relacionadas con esas ventas
            $Detalles_ventas=detalles_venta::where('fk_factura',$value)->get();
            //traigo el id de la compra
            $CargarVentas = Venta::where('id',$value)->get();

            $PrecioDeVentas=PreciosProducto::orderby('fk_producto')->get();
            $tipopacas=TipoPaca::orderby('id')->get();
            //consultar los productos mas vendidos
            //
            // $fechaActual= Carbon::now()->toDateString();
            // $fechaatras= new Carbon( $fechaActual )->addDay(-30)->toDateString();
            // $losmasvendidos =  DB::table(DB::raw('productos','clientes','ventas',
            //                             'detalles_ventas'))
            //                     ->where('clientes.number_id',$clientes->number_id) 
            //                     ->where('ventas.fk_cliente',$clientes->number_id)
            //                     ->where('detalles_ventas.fk_factura',$CargarVentas->id)
            //                     ->where('productos.codigo',$Detalles_ventas->fk_producto)
            //                     ->where('ventas.fk_estado_venta',3)
            //                     ->whereBetween('ventas.fecha_entrega',[$fechaatras,$CargarVentas->fecha_entrega ])
            //                     ->groupBy('detalles_ventas.fk_producto')
            //                     ->get();
                          
            

           

            //retorna a al vista create de ventas y envio los valores de la varaiables a las vista
            if( $id_cliente == 0 )
                return view('admin.venta.create')->with(compact('clientes','estadoEntregaVentas','bodegas','formaPagos','productos','Detalles_ventas','CargarVentas','PrecioDeVentas','Empaques','marcas','tipocontenidos','tipopacas'));
            else
                return view('admin.venta.create')->with(compact('id_cliente','clientes','estadoEntregaVentas','bodegas','formaPagos','productos','Detalles_ventas','CargarVentas','PrecioDeVentas','Empaques','marcas','tipocontenidos','tipopacas'));
        }
    
        public function store( Request $request ) {
            //dd($request->all());//el metodo permite imprimir todos los datos del request
            // return view(); //almacenar el registro de un producto
            //validar datos con reglas de laravel en documentacion hay mas
            //mensajes personalizados para cada campo
        
            $idUsuario=(auth()->user()->id);
            $request['fk_vendedor']= $idUsuario;
            $request['total']=0;
            
            $this->validate($request,Venta::$rules,Venta::$messages);
            //crear una nuevo venta
            $ObtenerIdCliente=explode(',',$request->input('fk_cliente'));
            $venta = new Venta();
            $venta -> total = $request->input('total');

            $Empaques=TipoPaca::orderby('nombre')->get();


            $venta -> fk_vendedor = $request->input('fk_vendedor');
            $venta -> fk_estado_venta = $request->input('fk_estado_venta');
            $venta -> fk_cliente =  $ObtenerIdCliente[0];
            $venta -> fk_bodega = $request->input('fk_bodega');
            $venta -> fk_forma_de_pago = $request->input('fk_forma_de_pago');
            $venta -> save(); //registrar producto
            $notification = 'Venta Agregada Exitosamente';
            $id=$request->session()->get('id');
            $IdFactura= Venta::all()->last()->id;
            Session::put('IdVenta', $IdFactura);

            
            $idVenta = Session::get('IdVenta');
            return redirect('/venta/create') -> with( compact( 'notification' ) );
        }
    
        public function edit( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para producto con id $id";
            $marcas = Marca::orderBy('nombre') -> get();
            $tipocontenidos = TipoContenido::orderBy('nombre') -> get();
            $PrecioDeVentas=PreciosProducto::orderby('fk_producto')->get();

            $venta = Venta::find( $id );
            $clientes = Cliente::orderBy('name') -> get();
            $idUsuario=(auth()->user()->id);
            $vendedores = $idUsuario;
            
            $estadosventa = EstadoDeVenta::orderBy('nombre') -> get();
            $bodegas = Bodega::orderBy('nombre') -> get();
            $formapagos=FormaPago::orderby('nombre')->get();

            Session::put('IdVentaEditar', $id);
            $productos=producto::all();
            $Detalles_ventas=detalles_venta::where('fk_factura',$id)->get();
            $CargarVentas = Venta::where('id',$id)->get();
            $tipopacas=TipoPaca::orderby('id')->get();
            

            return view('admin.venta.edit')->with(compact('venta','clientes','estadosventa','bodega','formapagos','Detalles_ventas','CargarVentas','productos','marcas','tipocontenidos','tipopacas','PrecioDeVentas')); //formulario de registro
        }
    
        public function update($id,$estado ) 
        {
            
            $ObtenerEstadoVenta=venta::where('id',$id)->get();
            if($ObtenerEstadoVenta[0]->fk_estado_venta==1)
            {
            
         $Detalles_ventas=detalles_venta::where('fk_factura',$id)->get();

         $cantidad=0;
         $subtotal=0;
         $total=0;
         $CondicionVenta=0;
         $AcomularProducto=0;
         $error = array(); 
         $contadorErrores=0;
         foreach( $Detalles_ventas as  $Detalles_venta)
         {
        

            $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalles_venta->fk_producto)->get();
            $BuscarProductos=DB::table('detalles_ventas')->where('fk_producto',$Detalles_venta->fk_producto)->where('fk_factura',$id)->get();
            if(count($ObtenerCantidadActual)!=0)
            {
            foreach( $BuscarProductos as  $BuscarProducto)
            {
                $AcomularProducto=$BuscarProducto->cantidad + $AcomularProducto;

            }
          
            $ComprobarDisponibilidadProducto= $ObtenerCantidadActual[0]->cantidad-$AcomularProducto;
           ////condicion de si existe o falta de productos para le venta
            if( $ObtenerCantidadActual[0]->cantidad==0)
            {
                $CondicionVenta=1;
                ////mensajes de productos faltantes a la venta
                $error[$contadorErrores] ='-el producto '.$ObtenerCantidadActual[0]->nombre.' esta agotado';
            }            
            elseif( $ComprobarDisponibilidadProducto < 0)
            {
                ////mensajes de productos faltantes a la venta
                $CondicionVenta=1;
                $error[$contadorErrores]='-el producto '.$ObtenerCantidadActual[0]->nombre.' solo hay '.$ObtenerCantidadActual[0]->cantidad.' disponible';
                
            }
         
            $contadorErrores=  $contadorErrores+1;
        }
        $AcomularProducto=0;
         }
////////condicon de venta si falta productos no genere factura
         if( $CondicionVenta==0)
         {
////////se cumple la condicon de venta comienza hacer el recorrido             
         foreach( $Detalles_ventas as  $Detalles_venta)
         {
          $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalles_venta->fk_producto)->value('cantidad');
 
             $subtotal=$Detalles_venta->precio * $Detalles_venta->cantidad;
             $total=$total+$subtotal;
 ////////comienza a restar del  inventario 
             DB::table('productos')
             ->where('codigo',$Detalles_venta->fk_producto)
            
             ->update(['cantidad' =>$ObtenerCantidadActual-$Detalles_venta->cantidad ]);
             
 
         }
         // dd($id);
         
         $fechaActual= new DateTime();
////////se actualiza la venta cambiando el estado y total de la factura
///la condicon estado==4 hacer referencia al estado (por entregar) fk_estado_venta # 2
//////si no cumple llega al else donde se cambia estado  (entregado) Fk_estado_venta #3
         if($estado==4)
         {
            DB::table('ventas')
            ->where('id',$id)      
            ->update(['fk_estado_venta' => 2,'total' => $total,'fecha_entrega'=>$fechaActual]);
            $notification = 'ya se registro con el estado por entregar la compra # ' . $id ;
            Session::forget('IdVentaEditar');
            return back() -> with( compact( 'notification' ) );

         }

            else
            {

                // DB::table('ventas')->where('id',$id)->update(['fk_estado_venta' => 3,'total' => $total]);
        
                // Session::forget('IdVentaEditar');
        
                // $CargarVentas = Venta::where('id',$id)->get();
                // $DetalleVentas = detalles_venta::where('fk_factura',$id)->get();
                
                // $view=view('admin.venta.recibo',compact('CargarVentas','DetalleVentas'));
                // $pdf=\App::make('dompdf.wrapper');
                // $pdf->loadHTML($view);
                
                // return $pdf->stream();
                Session::forget('IdVentaEditar');
                $notification = 'ya se registro la venta # ' . $id ;
                return back() -> with('/venta') -> with( compact( 'notification' ) );
            }
        }
        else
        {
            // dd($error);
            //// muestra los mensajes de los productos faltantes
            return back() -> with( compact( 'error' ) );

        }
     }
     else
     {
        //// muestra los mensajes mensaje que se factura para no halla conflicto cuando le unde dos veces
             $notification = 'ya se registro la venta # ' . $id ;
             return back() -> with( compact( 'notification' ) );
     
         
 
     }

    }
    
        public function destroy( $id ) {
            // dd( $request -> input( 'idDelte' ) );
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para producto con id $id";
            $idVenta=Session::get('IdVenta');
            if($idVenta==$id)
            {
              
               $detalleVentas=detalles_venta::where('fk_factura',$id)->get();
               // dd($detalleVentas);
               if($detalleVentas !=null)
               {
               foreach($detalleVentas as $detalleVenta)
               {
                  $IdDetallesVenta= $detalleVenta->id;
                   $DetalleVenta = detalles_venta::find($IdDetallesVenta);
                   $DetalleVenta -> delete();
   
               }
               $ventas = Venta::find( $id );
               $ventas -> delete();
               Session::forget('IdVenta');
           }
               
            }
            else
            {
   
          
           $detalleVentas=detalles_venta::where('fk_factura',$id)->get();
           // dd($detalleVentas);
           if($detalleVentas !=null)
           {
           foreach($detalleVentas as $detalleVenta)
           {
              $IdDetallesVenta= $detalleVenta->id;
               $DetalleVenta = detalles_venta::find($IdDetallesVenta);
               $DetalleVenta -> delete();
   
           }
           $ventas = Venta::find( $id );
           $ventas -> delete(); //ELIMINAR
          }
          
   
            }
           $notification = 'pre venta' . $ventas -> nombre . ' Eliminado Exitosamente';
            
           return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior //nos devuelve a la pagina anterior
        }

        public function editcabeza( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para formapago con id $id";
            // $ObtenetDatosActual=Compra::where('id',$id);
           
            $ventas = Venta::find( $id );
            //$estadoCompras = EstadoCompra::orderBy('nombre') -> get();
            $formaPagos = FormaPago::orderBy('nombre',$ventas->fk_forma_pago) -> get();
            $clientes = Cliente::orderBy('name',$ventas->fk_cliente) -> get();
            $bodegas = Bodega::orderBy('nombre',$ventas->fk_bodega) -> get(); 
            //dd($clientes);
            return view('admin.venta.cabezaedit')->with(compact('formaPagos','clientes','bodegas','ventas')); //formulario de editar
        }
    
       public function updatecabeza( Request $request , $id ) {
           
           // $this->validate($request,FormaPago::$rules,formapago::$messages);
            //crear un prodcuto nuevo
            //
           
            
            $ventas = Venta::find( $id );
            $ventas -> fk_bodega = $request->input('bodega');     
            $ventas -> fk_forma_pago = $request->input('formapago');
            $ventas -> fk_cliente = $request->input('cliente');
            $ventas -> save(); //registrar forma pago
         
            $notification = 'el encabezado del pedido' .$request->input('id'). ' se Actualizado Exitosamente';
            return redirect('/venta/'.$id.'/edit');
        }
    
         public function editcabezacrear( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para formapago con id $id";
            
            $ventas = Venta::find( $id );
            //$estadoventas = EstadoCompra::orderBy('nombre') -> get();
            $formaPagos = FormaPago::orderBy('nombre',$ventas->fk_forma_de_pago) -> get();
            $clientes = Cliente::orderBy('number_id','name',$ventas->fk_cliente) -> get();
            $bodegas = Bodega::orderBy('nombre',$ventas->fk_bodega) -> get(); 
            //dd($clientes);
            return view('admin.venta.cabezaeditcrear')->with(compact('ventas','formaPagos','clientes','bodegas')); //formulario de editar
        }
    
       public function updatecabezacrear( Request $request , $id ) {
           
           // $this->validate($request,FormaPago::$rules,formapago::$messages);
            //crear un prodcuto nuevo
            
            $ventas = Venta::find( $id );
            $ventas -> fk_bodega = $request->input('bodega');     
            $ventas -> fk_forma_de_pago = $request->input('formapago');
            $ventas -> fk_cliente = $request->input('cliente');
            $ventas -> save(); //registrar forma pago
         
            
            return redirect('/venta/create');
        }
//////////////////////////////////////////////////////////////////////////////////////////////7
///
///
///
 public function imprimir($id,$estado)
{
   
   if($estado==3)
            {
                $fechaActual= new DateTime();
                DB::table('ventas')
                ->where('id',$id)      
                ->update(['fk_estado_venta' => 3,'fecha_entrega'=>$fechaActual]);

            }
    
    $Cargarventas = Venta::where('id',$id)->get();
    $array = array();
    $arrayCanasta = array();
    $arrayIndividual=array();
    $arrayDescripcion=array();
    $acomulador = array(); 
    $contador=0;
    $canasta=0;
    $descripcion=0;
    $Detalleventas = detalles_venta::where('fk_factura',$id)->orderBy('Numero_canasta','asc')->get();

    foreach ($Detalleventas as $Detalleventa) 
    {
     
    
          if($canasta!=$Detalleventa->Numero_canasta && $Detalleventa->Numero_canasta!=null)
          {
          array_push($arrayCanasta,$Detalleventa->Numero_canasta);
          // $canasta=$Detalleventa->Numero_canasta;
          $canasta=$Detalleventa->Numero_canasta;
          }


     
         if($Detalleventa->Numero_canasta == null)
          {

            
              array_push($arrayIndividual,$Detalleventa->id);

          }


    } 

  
    $view=view('admin.venta.recibo',compact('Cargarventas','Detalleventas','arrayCanasta'));
    $pdf=\App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream();
  }
     

 ////////////////////////////////////////777777
    public function recibo($id,$estado,$abono)
    {
     
        $ObtenerEstadoVenta=venta::where('id',$id)->get();
        if($ObtenerEstadoVenta[0]->fk_estado_venta==1)
        {
     
        $Detalles_ventas=detalles_venta::where('fk_factura',$id)->get();

        $cantidad=0;
        $subtotal=0;
        $total=0;
        $CondicionVenta=0;
        $AcomularProducto=0;
        $error = array(); 
        $contadorErrores=0;
        
        foreach( $Detalles_ventas as  $Detalles_venta)
        {
        

            $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalles_venta->fk_producto)->get();
            $BuscarProductos=DB::table('detalles_ventas')->where('fk_producto',$Detalles_venta->fk_producto)->where('fk_factura',$id)->get();
              if(count($ObtenerCantidadActual)!=0)
              {
                  foreach( $BuscarProductos as  $BuscarProducto)
                  {
                      $AcomularProducto=$BuscarProducto->cantidad + $AcomularProducto;

                  }
                    // dd( $ObtenerCantidadActual);
                  $ComprobarDisponibilidadProducto= $ObtenerCantidadActual[0]->cantidad-$AcomularProducto;
                   ////condicion de si existe o falta de productos para le venta
                  if( $ObtenerCantidadActual[0]->cantidad==0)
                  {
                      $CondicionVenta=1;
                      ////mensajes de productos faltantes a la venta
                      $error[$contadorErrores] ='-el producto '.$ObtenerCantidadActual[0]->nombre.' esta agotado';
                  }            
                  elseif( $ComprobarDisponibilidadProducto < 0)
                  {
                      ////mensajes de productos faltantes a la venta
                      $CondicionVenta=1;
                      $error[$contadorErrores]='-el producto '.$ObtenerCantidadActual[0]->nombre.' solo hay '.$ObtenerCantidadActual[0]->cantidad.' disponible';
                      
                  }
          
              $contadorErrores=  $contadorErrores+1;
             }
        $AcomularProducto=0;

        }
        ////////condicon de venta si falta productos no genere factura
        if( $CondicionVenta==0)
        {




        ////////se cumple la condicon de venta comienza hacer el recorrido      

        foreach( $Detalles_ventas as  $Detalles_venta)
        {
        $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalles_venta->fk_producto)->value('cantidad');
        $ObtenerIvaProducto=DB::table('ivas_productos')->where('fk_producto',$Detalles_venta->fk_producto)->value('valor');

            $subtotal=$Detalles_venta->precio * $Detalles_venta->cantidad;
            $total=$total+$subtotal;
        ////////comienza a restar del  inventario 
            DB::table('productos')
            ->where('codigo',$Detalles_venta->fk_producto)            
            ->update(['cantidad' =>$ObtenerCantidadActual-$Detalles_venta->cantidad ]);

            

        }
        // dd($id);
        $fechaActual= Carbon::now()->addDay(1)->toDateString();
        $fechaAbono= Carbon::now()->toDateString();

        
        ////////se actualiza la venta cambiando el estado y total de la factura
        ///la condicon estado==4 hacer referencia al estado (por entregar) fk_estado_venta # 2
        //////si no cumple llega al else donde se cambia estado  (entregado) Fk_estado_venta #3
        if($estado==4)
        {
        
        if($abono !=0)
        {

            if($abono >$total)
            {

                $notification = 'el abono no puede ser mayor al saldo de la factura'; 
                return redirect('venta/create') -> with( compact( 'notification' ) );
            
            }
            else
            {
            if($total == $abono && $ObtenerEstadoVenta[0] -> fk_forma_de_pago==2)
            {

                $objAbono = new abonoVenta();
                $objAbono -> valor = (float)$abono; 
                $objAbono -> fecha = $fechaAbono;                  
                $objAbono -> fk_venta = $id;
                $objAbono->save();
                //inicio de la factura

                $resta= floatval($total -$abono);

                DB::table('ventas')
                ->where('id',$id)      
                ->update(['fk_estado_venta' => 2,'fk_forma_de_pago' => 1,'total' => $total,
                'saldo' => $resta,'fecha_entrega'=>$fechaActual]);
                $notification = 'la factura fue pagada exitosamente'. $ObtenerEstadoVenta[0]->id;
                Session::forget('IdVenta');
                return redirect('venta') -> with( compact( 'notification' ));
            }
            else
            {
                if($ObtenerEstadoVenta[0] -> fk_forma_de_pago==2)
                    {


                    $objAbono = new abonoVenta();
                    $objAbono -> valor = (float)$abono; 
                    $objAbono -> fecha = $fechaAbono;     
                    
                    $objAbono -> fk_venta = $id;
                    $objAbono->save();

                    $resta= floatval($total -$abono);

                    DB::table('ventas')
                    ->where('id',$id)      
                    ->update(['fk_estado_venta' => 2,'fk_forma_de_pago' => 2,'total' => $total,
                    'saldo' => $resta,'fecha_entrega'=>$fechaActual]);                  

                    $notification = 'la factura fue agregada exitosamente  con su abono'. $ObtenerEstadoVenta[0]->id;
                    Session::forget('IdVenta');
                    return redirect('venta') -> with( compact( 'notification' ));



                    }

            }
            

            }
        

        }

        else
        {
        
            if($ObtenerEstadoVenta[0] -> fk_forma_de_pago==2 && (int)$abono==0)
                    {

                    $resta= floatval($total -(int)$abono);

                    DB::table('ventas')
                    ->where('id',$id)      
                    ->update(['fk_estado_venta' => 2,'fk_forma_de_pago' => 2,'total' => $total,
                    'saldo' => $resta,'fecha_entrega'=>$fechaActual]);                  

                    $notification = 'la factura fue agregada exitosamente sin abono'. $ObtenerEstadoVenta[0]->id;
                    Session::forget('IdVenta');
                    return redirect('venta') -> with( compact( 'notification' ));



                    }
            

        }

        $obtenerFecha=DB::table('ventas')->where('id',$id)->value('fecha_entrega');

        if($obtenerFecha !=null)
        {
            $fechaActual=$obtenerFecha; 


        }
        


            DB::table('ventas')
            ->where('id',$id)      
            ->update(['fk_estado_venta' => 2,'total' => $total,'fecha_entrega'=>$fechaActual]);
            $notification = 'ya se registro con el estado por entregar la compra # ' . $id ;
            Session::forget('IdVenta');
            return back() -> with('/venta') -> with( compact( 'notification' ) );

        }

        else
        {
            if($abono !=0)
        {

            if($abono >$total)
            {

                $notification = 'el abono no puede ser mayor al saldo de la factura'; 
                return redirect('venta/create') -> with( compact( 'notification' ) );
            
            }
            else
            {
            if($total == $abono && $ObtenerEstadoVenta[0] -> fk_forma_de_pago==2)
            {

                $objAbono = new abonoVenta();
                $objAbono -> valor = (float)$abono; 
                $objAbono -> fecha = $fechaAbono;                  
                $objAbono -> fk_venta = $id;
                $objAbono->save();
                //inicio de la factura

                $resta= floatval($total -$abono);

                DB::table('ventas')
                ->where('id',$id)      
                ->update(['fk_estado_venta' => 3,'fk_forma_de_pago' => 1,'total' => $total,
                'saldo' => $resta,'fecha_entrega'=>$fechaActual2]);
                $notification = 'la factura fue pagada exitosamente'. $ObtenerEstadoVenta[0]->id;
                Session::forget('IdVenta');
                return redirect('venta') -> with( compact( 'notification' ));
            }
            else
            {
                if($ObtenerEstadoVenta[0] -> fk_forma_de_pago==2)
                    {

                    $objAbono = new abonoVenta();
                    $objAbono -> valor = (float)$abono; 
                    $objAbono -> fecha = $fechaAbono;     
                    
                    $objAbono -> fk_venta = $id;
                    $objAbono->save();

                    $resta= floatval($total -$abono);

                    DB::table('ventas')
                    ->where('id',$id)      
                    ->update(['fk_estado_venta' => 3,'fk_forma_de_pago' => 2,'total' => $total,
                    'saldo' => $resta,'fecha_entrega'=>$fechaActual2]);                  

                    $notification = 'la factura fue agregada exitosamente  con su abono'. $ObtenerEstadoVenta[0]->id;
                    Session::forget('IdVenta');
                    return redirect('venta') -> with( compact( 'notification' ));



                    }

            }
            

            }
            

        }
        else
        {
            if($ObtenerEstadoVenta[0] -> fk_forma_de_pago==2 && (int)$abono==0)
                    {

                    $resta= floatval($total -(int)$abono);

                    DB::table('ventas')
                    ->where('id',$id)      
                    ->update(['fk_estado_venta' => 3,'fk_forma_de_pago' => 2,'total' => $total,
                    'saldo' => $resta,'fecha_entrega'=>$fechaActual]);                  

                    $notification = 'la factura fue agregada exitosamente sin su abono'. $ObtenerEstadoVenta[0]->id;
                    Session::forget('IdVenta');
                    return redirect('venta') -> with( compact( 'notification' ));



                    }
        }
        

        $fechaActual2= Carbon::now()->toDateString();
        DB::table('ventas')
        ->where('id',$id)      
        ->update(['fk_estado_venta' => 3,'total' => $total,'fecha_entrega'=>$fechaActual2]);

        Session::forget('IdVenta');

        // $CargarVentas = Venta::where('id',$id)->get();
        // $DetalleVentas = detalles_venta::where('fk_factura',$id)->get();
        
        // $view=view('admin.venta.recibo',compact('CargarVentas','DetalleVentas'));
        // $pdf=\App::make('dompdf.wrapper');
        // $pdf->loadHTML($view);

        // return $pdf->stream();
        // $notification = 'ya se registro la venta # ' . $id ;
        return back() -> with( compact( 'notification' ) );

        }
        }
        else
        {
        
        
            //// muestra los mensajes de los productos faltantes
            return back() -> with( compact( 'error' ) );

        }
        }
        else
        {
        //// muestra los mensajes mensaje que se factura para no halla conflicto cuando le unde dos veces
        Session::forget('IdVenta');     
        $notification = 'ya se registro la venta # ' . $id ;
        return back() -> with( compact( 'notification' ) );

        

        }

        }
}
    

