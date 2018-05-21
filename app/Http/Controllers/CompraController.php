<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\compra;
use App\Bodega;
use App\EstadoCompra;
use App\User;
use App\formapago;
use Session;
use App\Producto;
use DateTime;
use App\detalle_compra;
use  App\CartDetail;
use App\Proveedor;
use App\PreciosProducto;
use App\TipoPaca;
use App\Marca; 
use App\TipoContenido;


use Auth;


class compraController extends Controller

    {

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

//    dd($productoCantidad,$productoID);
       $IdCompra= session::get('IdCompraEditar');
       $ObtenerCombo=DB::table('tipo_pacas')->where('id', $productoTipoPaca)->value('cantidad');
        $total=0;
        $tmp=0;
        $totalCanasta=$productoCantidadCanasta * $ObtenerCombo;
      
        $ObteneIDcanasta=DB::table('detalle_compras')->where('fk_compra','=',$IdCompra)->max('Numero_canasta');
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
                    $DatoPrecio= DB::table('productos')        
                                         
                   ->where('productos.codigo','=', $productoID[$tmp])
                                 
                     ->value('precio_compra');
               
         
                     DB::table('detalle_compras')->insert([
                         ['precio' => $DatoPrecio, 'cantidad' =>$productoCantidad[$tmp],'fk_tipo_paca'=>0,'fk_compra'=>$IdCompra,'fk_producto'=>$productoID[$tmp],'Numero_canasta' =>$ObteneIDcanasta]]);
                     
         
                 }
               
             
                 $tmp++; 
               
            }
          
           
           
          }

      ////canasta y envases Editar

       $consultaTipoPaca=DB::table('productos')->where('codigo',$productoID)->value('fk_tipo_paca');
      
      
       $consultaIDCanasta=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('fk_tipo_paca',$productoTipoPaca)->get();

      
      
       if($consultaTipoPaca!=null)
       {
           
           if($productoCantidadEnvase!=null && $productoCantidadEnvase!=0)
           {
             
           $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
      
         
          if(count($consultaIDCanasta)!=0)
          {
           // dd($consultaIDCanasta[0]-> cantidad,$productoCantidadEnvase);
          
               DB::table('detalle_compras')
               ->where('fk_tipo_paca',$consultaTipoPaca)
               ->where('fk_compra',$IdCompra)
               ->where('precio',$consultarEnvases[0]->precio_envase)
               ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadEnvase]);
           
          }
           else
           {
              
           //  $TotaEnvases=$DividirPrecio * $precio;
            DB::table('detalle_compras')->insert([
               ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$productoCantidadEnvase,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
             
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
                  
                       DB::table('detalle_compras')
                       ->where('fk_tipo_paca',$productoTipoPaca)
                       ->where('fk_compra',$IdCompra)
                       ->where('precio',$consultarEnvases[0]->precio)
                       ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadPlastico]);
                   
                  }
                   else
                   {
                      
                   //  $TotaEnvases=$DividirPrecio * $precio;
                    DB::table('detalle_compras')->insert([
                       ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$productoCantidadPlastico,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
                     
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
       $IdCompra= session::get('IdCompra');
       $ObtenerCombo=DB::table('tipo_pacas')->where('id', $productoTipoPaca)->value('cantidad');
        $total=0;
        $tmp=0;
        $totalCanasta=$productoCantidadCanasta * $ObtenerCombo;
      
        $ObteneIDcanasta=DB::table('detalle_compras')->where('fk_compra','=',$IdCompra)->max('Numero_canasta');
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
                    $DatoPrecio= DB::table('productos')                        
                  
                                         
                   ->where('productos.codigo','=', $productoID[$tmp])
                                 
                     ->value('precio_compra');
               
         
                     DB::table('detalle_compras')->insert([
                         ['precio' => $DatoPrecio, 'cantidad' =>$productoCantidad[$tmp],'fk_tipo_paca'=>0,'fk_compra'=>$IdCompra,'fk_producto'=>$productoID[$tmp],'Numero_canasta' =>$ObteneIDcanasta]]);
                     
         
                 }
               
             
                 $tmp++; 
               
            }
          
           
           
          }

      ////canasta y envases

       $consultaTipoPaca=DB::table('productos')->where('codigo',$productoID)->value('fk_tipo_paca');
      
      
       $consultaIDCanasta=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('fk_tipo_paca',$productoTipoPaca)->get();

      
      
       if($consultaTipoPaca!=null)
       {
           
           if($productoCantidadEnvase!=null && $productoCantidadEnvase!=0)
           {
             
           $consultarEnvases=DB::table('tipo_pacas')->where('id',$consultaTipoPaca)->get();
      
         
          if(count($consultaIDCanasta)!=0)
          {
           // dd($consultaIDCanasta[0]-> cantidad,$productoCantidadEnvase);
          
               DB::table('detalle_compras')
               ->where('fk_tipo_paca',$consultaTipoPaca)
               ->where('fk_compra',$IdCompra)
               ->where('precio',$consultarEnvases[0]->precio_envase)
               ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadEnvase]);
           
          }
           else
           {
              
           //  $TotaEnvases=$DividirPrecio * $precio;
            DB::table('detalle_compras')->insert([
               ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$productoCantidadEnvase,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
             
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
                  
                       DB::table('detalle_compras')
                       ->where('fk_tipo_paca',$productoTipoPaca)
                       ->where('fk_compra',$IdCompra)
                       ->where('precio',$consultarEnvases[0]->precio)
                       ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$productoCantidadPlastico]);
                   
                  }
                   else
                   {
                      
                   //  $TotaEnvases=$DividirPrecio * $precio;
                    DB::table('detalle_compras')->insert([
                       ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$productoCantidadPlastico,'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
                     
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
            
            // dd($id);
            $ObtenerIdProducto= Session::get('IdCompra');
  
    
            DB::table('detalle_compras')
            ->where('id',$id)
            ->where('fk_compra',$ObtenerIdProducto)
            ->update(['cantidad' => $cantidad]);
    
           return redirect('admin.compra.create') -> with( compact('ObtenerIdProducto') );
            // return response()->json(['reponse'=> $cantidad]);
    
        }
        public function agregrarCantidadEditar($cantidad,$id) 
        {
              $ObtenerIdProducto= Session::get('IdCompraEditar');
    
     // dd("aqui responde laravel " . $cantidad . " la id : " . $id ."Id compra ".$ObtenerIdProducto);
          
            // dd($ObtenerIdProducto);
            DB::table('detalle_compras')
            ->where('id',$id)
            ->where('fk_compra',$ObtenerIdProducto)
            ->update(['cantidad' => $cantidad]);
    
           return redirect('admin.compra.edit') -> with( compact( 'ObtenerIdProducto' ) );
            // return response()->json(['reponse'=> $cantidad]);
    
        }
        public function agregrarCantidadDevolucion(Request $request ) 
        {
             $request->input('fk_cantidad');
             $request->input('id');
            //  dd($request->input('id'));

              $ObtenerIdProducto= Session::get('IdCompraEditar');
              $Resta=0;
    // dd($ObtenerIdProducto);
     // dd("aqui responde laravel " . $cantidad . " la id : " . $id ."Id compra ".$ObtenerIdProducto);
$consultarDetallecompra= DB::table('detalle_compras')->where('id',(int)$request->input('id'))->where('fk_compra',$ObtenerIdProducto)->get();
$consultarProducto= DB::table('productos')->where('codigo',$consultarDetallecompra[0]->fk_producto)->get();
// dd($consultarDetallecompra);

     if(count($consultarDetallecompra) !=0)
        {
            
    if( (int)$request->input('fk_cantidad') <= $consultarDetallecompra[0]->cantidad )
     {
     
      $Resta= $consultarDetallecompra[0]->cantidad-(int)$request->input('fk_cantidad');

      if($Resta==0)
      {
        $detalle_compra= detalle_compra::find(  $request->input('id'));
        $detalle_compra -> delete();
      }
      else
      {
            DB::table('detalle_compras')
            ->where('id',$request->input('id'))
            ->where('fk_compra',$ObtenerIdProducto)
            ->update(['cantidad' => $consultarDetallecompra[0]->cantidad-$request->input('fk_cantidad')]);
      }

            DB::table('productos')
            ->where('codigo',$consultarDetallecompra[0]->fk_producto)
            
            ->update(['cantidad' => $consultarProducto[0]->cantidad +$request->input('fk_cantidad')]);

            $notification = 'se devolvieron '.(int)$request->input('fk_cantidad').' del prodcuto '.$consultarProducto[0]->nombre.' al incomprario';
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
                Session::forget('IdCompra');
            return back();
            }
            else if(2==$idSession)
            {
            Session::forget('IdCompraEditar');
            // dd($idSession);
             return redirect('compra/');
            }
            else if(3==$idSession)
            {
            Session::forget('IdCompra');
            // dd($idSession);
             return back();
            }
    
        }

        public function AgregarCompra(Request $request )
        {
            

           
            $ObtenerIdProdcuto=explode(',',$request->input('fk_producto'));
            //    dd($request->input('fk_producto'));
               
                $request['fk_producto']=$ObtenerIdProdcuto[0];
                // dd($request->input('fk_tipo_paca'));
         
                     
                $DatoPrecio= DB::table('productos')                        
                            
                            ->where('codigo', $ObtenerIdProdcuto[0])
                                            
                           ->value('precio_compra');
    
                        //    dd($DatoPrecio);
                     
    
            $productos=DB::table('productos')->where('codigo',$ObtenerIdProdcuto[0])->value('fk_tipo_paca');
        
            $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');

            
        



            $this->validate($request,detalle_compra::$rules,detalle_compra::$messages);
            $notification = 'se agrego exitosamente';
            $detalle_compra = new detalle_compra();
             if( $request->input('cantidad') == null ) {
                $request['cantidad'] = 0;
               }
               
            //    $this->validate( $Datoscompras,detalle_compra::$rules,detalle_compra::$messages);
             
            
            $idCompra=$request->session()->get('IdCompra');
            $request['fk_compra']= $idCompra;
         
           
            $detalle_compra -> fk_tipo_paca = 0;
   
            $detalle_compra -> fk_producto = $ObtenerIdProdcuto[0];
           
            $detalle_compra -> fk_compra = $request->input('fk_compra');
            // $detalle_compra -> precio = $request->input('fk_precio');
            $detalle_compra -> cantidad = $request->input('cantidad');
            $preciocompra=($DatoPrecio);
          
          
            // $preciocompra = DB::table('precios_productos')->where('id',$precio)->value('valor');
            // dd($preciocompra );
            $detalle_compra -> precio= $preciocompra;
            $IdCompra= session::get('IdCompra');

          
            $ConsultarIDProducto = DB::table('detalle_compras')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_compra', $IdCompra)->where('precio',$preciocompra)->get();
            // dd($ConsultarIDProducto);
            // $consultarPrecioProducto=DB::table('precios_productos')->where('fk_producto', $ObtenerIdProdcuto[0])->value('valor');

            $consultaTipoPaca=DB::table('productos')->where('codigo',$request->input('fk_producto'))->value('fk_tipo_paca');
            $consultaPrecioDetalle=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('precio',$preciocompra)->where('fk_producto',$ObtenerIdProdcuto[0])->value('precio');
           
            $consultaIDCanasta=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('fk_tipo_paca',$consultaTipoPaca)->get();
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
            //    dd($consultarEnvases)
              
               if(count($consultaIDCanasta)!=0)
               {
                // dd($consultaIDCanasta[0]-> cantidad,$request->input('cantidadEnvases'));
               
                    DB::table('detalle_compras')
                    ->where('fk_tipo_paca',$consultaTipoPaca)
                    ->where('fk_compra',$IdCompra)
                    ->where('precio',$consultarEnvases[0]->precio_envase)
                    ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadEnvases')]);
                
               }
                else
                {
                   
                //  $TotaEnvases=$DividirPrecio * $precio;
                 DB::table('detalle_compras')->insert([
                    ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$request->input('cantidadEnvases'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
                  
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
                       
                            DB::table('detalle_compras')
                            ->where('fk_tipo_paca',$consultaTipoPaca)
                            ->where('fk_compra',$IdCompra)
                            ->where('precio',$consultarEnvases[0]->precio)
                            ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadPlastico')]);
                        
                       }
                        else
                        {
                           
                        //  $TotaEnvases=$DividirPrecio * $precio;
                         DB::table('detalle_compras')->insert([
                            ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$request->input('cantidadPlastico'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
                          
                        ]);
                         }


                }

            }   
           



            if(count($ConsultarIDProducto) != 0 && $preciocompra == $consultaPrecioDetalle)
             {

             
                 
                DB::table('detalle_compras')
                ->where('fk_producto',($ObtenerIdProdcuto[0]))
                ->where('fk_compra',$IdCompra)
                ->where('precio',$preciocompra )
                ->update(['cantidad' => $ConsultarIDProducto[0]-> cantidad + $request->input('cantidad')]);
            }
            else {
   
                $detalle_compra-> save();
            }
           
             //registrar Pre detalle de compra
           
            $notification = 'se agrego exitosamente';
    
      
          
            return redirect('/compra/create') -> with( compact( 'detalle_compra' ) );
            
        }
    
    
        public function AgregarCompraEditar( Request $request )
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


  $this->validate($request,detalle_compra::$rules,detalle_compra::$messages);
  $notification = 'se agrego exitosamente';
  $detalle_compra = new detalle_compra();
   if( $request->input('cantidad') == null ) {
      $request['cantidad'] = 0;
     }
     
  //    $this->validate( $Datoscompras,detalle_compra::$rules,detalle_compra::$messages);
   
  
  $idCompra=$request->session()->get('IdCompraEditar');
  $request['fk_compra']= $idCompra;

 
  $detalle_compra -> fk_tipo_paca = 0;

  $detalle_compra -> fk_producto = $ObtenerIdProdcuto[0];
 
  $detalle_compra -> fk_compra = $request->input('fk_compra');
  // $detalle_compra -> precio = $request->input('fk_precio');
  $detalle_compra -> cantidad = $request->input('cantidad');
  $preciocompra=($DatoPrecio);


  // $preciocompra = DB::table('precios_productos')->where('id',$precio)->value('valor');
  // dd($preciocompra );
  $detalle_compra -> precio= $preciocompra;
  $IdCompra= session::get('IdCompraEditar');
  $ConsultarIDProducto = DB::table('detalle_compras')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_compra', $IdCompra)->where('precio',$preciocompra)->get();
  // dd($ConsultarIDProducto);
  // $consultarPrecioProducto=DB::table('precios_productos')->where('fk_producto', $ObtenerIdProdcuto[0])->value('valor');

  $consultaTipoPaca=DB::table('productos')->where('codigo',$request->input('fk_producto'))->value('fk_tipo_paca');
  $consultaPrecioDetalle=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('precio',$preciocompra)->where('fk_producto',$ObtenerIdProdcuto[0])->value('precio');
 
  $consultaIDCanasta=DB::table('detalle_compras')->where('fk_compra', $IdCompra)->where('fk_tipo_paca',$consultaTipoPaca)->get();
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
     
          DB::table('detalle_compras')
          ->where('fk_tipo_paca',$consultaTipoPaca)
          ->where('fk_compra',$IdCompra)
          ->where('precio',$consultarEnvases[0]->precio_envase)
          ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadEnvases')]);
      
     }
      else
      {
         
      //  $TotaEnvases=$DividirPrecio * $precio;
       DB::table('detalle_compras')->insert([
          ['precio' => $consultarEnvases[0]->precio_envase, 'cantidad' =>(int)$request->input('cantidadEnvases'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
        
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
             
                  DB::table('detalle_compras')
                  ->where('fk_tipo_paca',$consultaTipoPaca)
                  ->where('fk_compra',$IdCompra)
                  ->where('precio',$consultarEnvases[0]->precio)
                  ->update(['cantidad' => (int)$consultaIDCanasta[0]-> cantidad + (int)$request->input('cantidadPlastico')]);
              
             }
              else
              {
                 
              //  $TotaEnvases=$DividirPrecio * $precio;
               DB::table('detalle_compras')->insert([
                  ['precio' => $consultarEnvases[0]->precio , 'cantidad' =>(int)$request->input('cantidadPlastico'),'fk_tipo_paca'=>(int)$consultaTipoPaca,'fk_compra'=>(int)$IdCompra,'fk_producto'=>0 ]
                
              ]);
               }


      }

  }   
 



  if(count($ConsultarIDProducto) != 0 && $preciocompra == $consultaPrecioDetalle)
   {

   
       
      DB::table('detalle_compras')
      ->where('fk_producto',($ObtenerIdProdcuto[0]))
      ->where('fk_compra',$IdCompra)
      ->where('precio',$preciocompra )
      ->update(['cantidad' => $ConsultarIDProducto[0]-> cantidad + $request->input('cantidad')]);
  }
  else {

      $detalle_compra-> save();
  }
 
   //registrar Pre detalle de compra
 
  $notification = 'se agrego exitosamente';

    
      
          
            return redirect('/compra/'.$IdCompra.'/edit') -> with( compact( 'detalle_compra' ) );
            
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

        if($tipopaca==null)
        {
         


        $productos=DB::table('productos')->where('codigo',$id)->value('fk_tipo_paca');
    
        $ObtenerPaca=DB::table('tipo_pacas')->where('id',$productos)->value('retornable');
        
        // dd($ObtenerPaca);
        }
    

    //    dd($ObtenerPrecio);
        return response()->json(['paca'=>$ObtenerPaca]);
        
       }

        //
        public function index() {
            $compras = compra::orderBy('id','desc') -> get();
           
           


            return view('admin.compra.index')->with(compact('compras')); //listado de tipos movimientos
        }
    
        //mostrar un tipo de movimiento
        public function show( $id ) {
            $Cargarcompras = compra::find($id);
            $Detalle_compras=detalle_compra::where('fk_compra',$id)->orderBy('Numero_canasta','desc')->get();
            $Cargarcompras = compra::where('id',$id)->get();
            return view('admin.compra.show')->with(compact('Cargarcompras','Detalle_compras','Cargarcompras'));
        }
    
        public function create() {

          

          
            $marcas = Marca::orderBy('nombre') -> get();
            $tipocontenidos = TipoContenido::orderBy('nombre') -> get();
          
            // traigo el nombre del Proveedor
            $Proveedors = Proveedor::orderBy('name') -> get();
            //traigo el nombre del vendedor
            // $idUsuario=(auth()->user()->cart->id);
            // $vendedores = User::orderBy('name',$idUsuario) -> get();
            //traigo el nombre del estadocompra
            $estadoEntregacompras = EstadoCompra::orderBy('id') -> get();
            //traifo el nombre de la bodega
            $bodegas = Bodega::orderBy('nombre') -> get();
            //traigo el nombre  de formapago
            $formaPagos=formapago::orderby('nombre')->get();
            //traigo el id de la variable sesion
            $value= session::get('IdCompra');
            //traigo todos los productos
            $productos=producto::all();
            //traigo el id de la compra relacionadas con esas compras
            $Detalle_compras=detalle_compra::where('fk_compra',$value)->orderby('Numero_canasta')->get();
            //traigo el id de la compra
            $Cargarcompras = compra::where('id',$value)->get();

            $PrecioDecompras=PreciosProducto::orderby('fk_producto')->get();
            $tipopacas=TipoPaca::orderby('id')->get();

           

            //retorna a al vista create de compras y envio los valores de la varaiables a las vista
            return view('admin.compra.create')->with(compact('Proveedors','estadoEntregacompras','bodegas','formaPagos','productos','Detalle_compras','Cargarcompras','PrecioDecompras','marcas','tipocontenidos','tipopacas'));
        }
    
        public function store( Request $request ) {
            //dd($request->all());//el metodo permite imprimir todos los datos del request
            // return view(); //almacenar el registro de un producto
            //validar datos con reglas de laravel en documentacion hay mas
            //mensajes personalizados para cada campo
        
            $idUsuario=(auth()->user()->id);
            $request['fk_vendedor']= $idUsuario;
            $request['total']=0;
            
            $this->validate($request,compra::$rules,compra::$messages);
            //crear una nuevo compra
            $ObtenerIdProveedor=explode(',',$request->input('fk_proveeedors'));
            $compra = new compra();
            $compra -> total = $request->input('total');

            $Empaques=TipoPaca::orderby('nombre')->get();


            $compra -> fk_vendedor = $request->input('fk_vendedor');
            $compra -> fk_estado_compra = $request->input('fk_estado_compra');
            $compra -> fk_proveeedors =  $ObtenerIdProveedor[0];
            $compra -> fk_bodega = $request->input('fk_bodega');
            $compra -> fk_forma_pago = $request->input('fk_forma_pago');
            $compra -> save(); //registrar producto
            $notification = 'compra Agregada Exitosamente';
            $id=$request->session()->get('id');
            $IdFactura= compra::all()->last()->id;
            Session::put('IdCompra', $IdFactura);
            
            $idCompra = Session::get('IdCompra');
            return redirect('/compra/create') -> with( compact( 'notification' ) );
        }
    
        public function edit( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para producto con id $id";
            $marcas = Marca::orderBy('nombre') -> get();
            $tipocontenidos = TipoContenido::orderBy('nombre') -> get();
            $PrecioDecompras=PreciosProducto::orderby('fk_producto')->get();

            $compra = compra::find( $id );
            $Proveedors = Proveedor::orderBy('name') -> get();
            $idUsuario=(auth()->user()->id);
            $vendedores = $idUsuario;
            
            $estadoscompra = EstadoCompra::orderBy('nombre') -> get();
            $bodegas = Bodega::orderBy('nombre') -> get();
            $formapagos=FormaPago::orderby('nombre')->get();

            Session::put('IdCompraEditar', $id);
            $productos=producto::all();
            $Detalle_compras=detalle_compra::where('fk_compra',$id)->get();
            $Cargarcompras = compra::where('id',$id)->get();
            $tipopacas=TipoPaca::orderby('id')->get();
            

            return view('admin.compra.edit')->with(compact('compra','Proveedors','estadoscompra','bodega','formapagos','Detalle_compras','Cargarcompras','productos','marcas','tipocontenidos','tipopacas','PrecioDecompras')); //formulario de registro
        }
    
        public function update($id,$estado ) 
        {
            
            $ObtenerEstadoCompra=compra::where('id',$id)->get();
          if($ObtenerEstadoCompra[0]->fk_estado_compra==1)
          
        {
            
         $Detalle_compras=detalle_compra::where('fk_compra',$id)->get();

         $cantidad=0;
         $subtotal=0;
         $total=0;
         $Condicioncompra=0;
         $AcomularProducto=0;
         $error = array(); 
         $contadorErrores=0;
       
////////condicon de compra si falta productos no genere factura
        //  if( $Condicioncompra==0)
        //  {
////////se cumple la condicon de compra comienza hacer el recorrido             
         foreach( $Detalle_compras as  $Detalle_compra)
         {
          $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalle_compra->fk_producto)->value('cantidad');
 
             $subtotal=$Detalle_compra->precio * $Detalle_compra->cantidad;
             $total=$total+$subtotal;
 ////////estado cero recbido su al inventario
               if($estado==0)
           {
             DB::table('productos')
             ->where('codigo',$Detalle_compra->fk_producto)
            
             ->update(['cantidad' =>$ObtenerCantidadActual+$Detalle_compra->cantidad ]);
           }
             
 
         }
         // dd($id);
         
         $fechaActual= new DateTime();
////////se actualiza la compra cambiando el estado y total de la factura
///la condicon estado==4 hacer referencia al estado (por entregar) fk_estado_compra # 2
//////si no cumple llega al else donde se cambia estado  (entregado) Fk_estado_compra #3
if($estado==0)
{
    DB::table('compras')
    ->where('id',$id)      
    ->update(['fk_estado_compra' => 3,'total' => $total,'fecha_compra'=>$fechaActual]);
    Session::forget('IdCompraEditar');
    $notification = 'ya se registro con el estado recibido la compra # ' . $id ;
    return back() -> with( compact( 'notification' ) );

}         


if($estado==4)
         {
            DB::table('compras')
            ->where('id',$id)      
            ->update(['fk_estado_compra' => 2,'total' => $total,'fecha_compra'=>$fechaActual]);
            $notification = 'ya se registro con el estado por recibir la compra # ' . $id ;
            Session::forget('IdCompraEditar');
           
            return back() -> with ( compact( 'notification' ) );

         }

            else
            {

               
                Session::forget('IdCompraEditar');
                $notification = 'ya se registro la compra # ' . $id ;
                return back() -> with( compact( 'notification' ) );
            }
        }
        else
        {
            $notification = 'error inesperado vuelva intenterlo ;) ';
            //// muestra los mensajes de los productos faltantes
            return back() -> with( compact( 'notification' ) );

        }
 

    }
    
        public function destroy( $id ) {
            // dd( $request -> input( 'idDelte' ) );
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para producto con id $id";
            $idCompra=Session::get('IdCompra');
            if($idCompra==$id)
            {
              
               $detallecompras=detalle_compra::where('fk_compra',$id)->get();
               // dd($detallecompras);
               if($detallecompras !=null)
               {
               foreach($detallecompras as $detallecompra)
               {
                  $IdDetallescompra= $detallecompra->id;
                   $Detallecompra = detalle_compra::find($IdDetallescompra);
                   $Detallecompra -> delete();
   
               }
               $compras = compra::find( $id );
               $compras -> delete();
               Session::forget('IdCompra');
           }
               
            }
            else
            {
   
          
           $detallecompras=detalle_compra::where('fk_compra',$id)->get();
           // dd($detallecompras);
           if($detallecompras !=null)
           {
           foreach($detallecompras as $detallecompra)
           {
              $IdDetallescompra= $detallecompra->id;
               $Detallecompra = detalle_compra::find($IdDetallescompra);
               $Detallecompra -> delete();
   
           }
           $compras = compra::find( $id );
           $compras -> delete(); //ELIMINAR
          }
          
   
            }
           $notification = 'pre compra' . $compras -> nombre . ' Eliminado Exitosamente';
            
           return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior //nos devuelve a la pagina anterior
        }

        public function editcabeza( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para formapago con id $id";
            // $ObtenetDatosActual=Compra::where('id',$id);
           
            $compras = compra::find( $id );
            //$estadoCompras = EstadoCompra::orderBy('nombre') -> get();
            $formaPagos = FormaPago::orderBy('nombre',$compras->fk_forma_pago) -> get();
            $Proveedors = Proveedor::orderBy('name',$compras->fk_proveeedors) -> get();
            $bodegas = Bodega::orderBy('nombre',$compras->fk_bodega) -> get(); 
            //dd($Proveedors);
            return view('admin.compra.cabezaedit')->with(compact('formaPagos','Proveedors','bodegas','compras')); //formulario de editar
        }
    
       public function updatecabeza( Request $request , $id ) {
           
           // $this->validate($request,FormaPago::$rules,formapago::$messages);
            //crear un prodcuto nuevo
            //
           
            
            $compras = compra::find( $id );
            $compras -> fk_bodega = $request->input('bodega');     
            $compras -> fk_forma_pago = $request->input('formapago');
            $compras -> fk_proveeedors = $request->input('Proveedor');
            $compras -> save(); //registrar forma pago
         
            $notification = 'el encabezado del pedido' .$request->input('id'). ' se Actualizado Exitosamente';
            return redirect('/compra/'.$id.'/edit');
        }
    
         public function editcabezacrear( $id ) {
            //$categories = Category::all(); //traer categorias
            // return "Mostrar aqui formulario para formapago con id $id";
            
            $compras = compra::find( $id );
            //$estadocompras = EstadoCompra::orderBy('nombre') -> get();
            $formaPagos = FormaPago::orderBy('nombre',$compras->fk_forma_pago) -> get();
            $Proveedors = Proveedor::orderBy('number_id','name',$compras->fk_proveeedors) -> get();
            $bodegas = Bodega::orderBy('nombre',$compras->fk_bodega) -> get(); 
            //dd($Proveedors);
            return view('admin.compra.cabezaeditcrear')->with(compact('compras','formaPagos','Proveedors','bodegas')); //formulario de editar
        }
    
       public function updatecabezacrear( Request $request , $id ) {
           
           // $this->validate($request,FormaPago::$rules,formapago::$messages);
            //crear un prodcuto nuevo
            
            $compras = compra::find( $id );
            $compras -> fk_bodega = $request->input('bodega');     
            $compras -> fk_forma_pago = $request->input('formapago');
            $compras -> fk_proveeedors = $request->input('Proveedor');
            $compras -> save(); //registrar forma pago
         
            
            return redirect('/compra/create');
        }
////////////////////////////////////////////////////////////////////////////////////////////7
public function imprimir($id,$estado)
{
   
    if($estado==3)
    {
       $ObtenerEstadoCompra=compra::where('id',$id)->get();
            if($ObtenerEstadoCompra[0]->fk_estado_compra==2)
     {
            
         $Detalle_compras=detalle_compra::where('fk_compra',$id)->get();
         $cantidad=0;
         $subtotal=0;
         $total=0;
         $Condicioncompra=0;
         $AcomularProducto=0;
         $error = array(); 
         $contadorErrores=0;
     
////////condicon de compra si falta productos no genere factura
        //  if( $Condicioncompra==0)
        //  {
////////se cumple la condicon de compra comienza hacer el recorrido             
         foreach( $Detalle_compras as  $Detalle_compra)
         {

        $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalle_compra->fk_producto)->value('cantidad');
 
             $subtotal=$Detalle_compra->precio * $Detalle_compra->cantidad;
             $total=$total+$subtotal;
 ////////estado cero recbido su al inventario
               if($estado==3)
              {
                   DB::table('productos')
                   ->where('codigo',$Detalle_compra->fk_producto)
                  
                   ->update(['cantidad' =>$ObtenerCantidadActual+$Detalle_compra->cantidad ]);
              }
             
 
        }
         // dd($id);
         
        $fechaActual= new DateTime();
////////se actualiza la compra cambiando el estado y total de la factura
///la condicon estado==4 hacer referencia al estado (por entregar) fk_estado_compra # 2
//////si no cumple llega al else (0) donde se cambia estado  (entregado) Fk_estado_compra #3
          if($estado==3)
          {
              DB::table('compras')
              ->where('id',$id)      
              ->update(['fk_estado_compra' => 3,'total' => $total,'fecha_compra'=>$fechaActual]);
              // Session::forget('IdCompra');
              // $notification = 'ya se registro con el estado recibido la compra # ' . $id ;
              // return view('compra') -> with( compact( 'notification' ) );

          }           


      }


    }
    
    $Cargarcompras = compra::where('id',$id)->get();
    $array = array();
    $arrayCanasta = array();
    $arrayIndividual=array();
    $arrayDescripcion=array();
    $acomulador = array(); 
    $contador=0;
    $canasta=0;
    $descripcion=0;
    $Detallecompras = detalle_compra::where('fk_compra',$id)->orderBy('Numero_canasta','asc')->get();

    foreach ($Detallecompras as $Detallecompra) 
    {
     
    
          if($canasta!=$Detallecompra->Numero_canasta && $Detallecompra->Numero_canasta!=null)
          {
          array_push($arrayCanasta,$Detallecompra->Numero_canasta);
          // $canasta=$Detallecompra->Numero_canasta;
          $canasta=$Detallecompra->Numero_canasta;
          }

     
         if($Detallecompra->Numero_canasta == null)
          {

            
              array_push($arrayIndividual,$Detallecompra->id);

          }


    } 

   
    $view=view('admin.compra.recibo',compact('Cargarcompras','Detallecompras','arrayCanasta'));
    $pdf=\App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream();
  }


///////////////////////////////////////////////
        public function recibo($id,$estado)
    {
            
            $ObtenerEstadoCompra=compra::where('id',$id)->get();
            if($ObtenerEstadoCompra[0]->fk_estado_compra==1)
        {
            
         $Detalle_compras=detalle_compra::where('fk_compra',$id)->get();

         $cantidad=0;
         $subtotal=0;
         $total=0;
         $Condicioncompra=0;
         $AcomularProducto=0;
         $error = array(); 
         $contadorErrores=0;
       
////////condicon de compra si falta productos no genere factura
        //  if( $Condicioncompra==0)
        //  {
////////se cumple la condicon de compra comienza hacer el recorrido             
         foreach( $Detalle_compras as  $Detalle_compra)
         {
          $ObtenerCantidadActual=DB::table('productos')->where('codigo',$Detalle_compra->fk_producto)->value('cantidad');
 
             $subtotal=$Detalle_compra->precio * $Detalle_compra->cantidad;
             $total=$total+$subtotal;
 ////////estado cero recbido su al inventario
         if($estado==0)
        {
             DB::table('productos')
             ->where('codigo',$Detalle_compra->fk_producto)
            
             ->update(['cantidad' =>$ObtenerCantidadActual+$Detalle_compra->cantidad ]);
        }
             
 
         }
         // dd($id);
         
         $fechaActual= new DateTime();
////////se actualiza la compra cambiando el estado y total de la factura
///la condicon estado==4 hacer referencia al estado (por rcebir) fk_estado_compra # 2
//////si no cumple llega al else (0) donde se cambia estado  (recbido) Fk_estado_compra #3
if($estado==0)
{
    DB::table('compras')
    ->where('id',$id)      
    ->update(['fk_estado_compra' => 3,'total' => $total,'fecha_compra'=>$fechaActual]);
    Session::forget('IdCompra');
    $notification = 'ya se registro con el estado recibido la compra # ' . $id ;
    return back() -> with( compact( 'notification' ) );

}           


if($estado==4)
          {
            DB::table('compras')
            ->where('id',$id)      
            ->update(['fk_estado_compra' => 2,'total' => $total,'fecha_compra'=>$fechaActual]);
            Session::forget('IdCompra');
            $notification = 'ya se registro con el estado por recibir la compra # ' . $id ;
            return back() -> with( compact( 'notification' ) );
         }

            else
            {
                 
               
                Session::forget('IdCompra');
                $notification = 'ya se registro la compra # ' . $id ;
               return back() -> with( compact( 'notification' ) );
            }
        }
        else
        {
            $notification = 'ocurrio error inesperado';
            //// muestra los mensajes de los productos faltantes
            return back() -> with( compact( '$notificatio' ) );

        }

  
}
    

}