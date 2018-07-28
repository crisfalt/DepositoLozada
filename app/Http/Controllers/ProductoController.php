<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Marca;
use App\SizeBotella;
use App\TipoEnvase;
use App\TipoContenido;
use App\TipoPaca;
use App\Bodega;
use App\DescripcionPrecio;
use App\DescripcionIva;
use App\PreciosProducto;
use App\IvasProductos;
use App\ImagenesProducto;

class ProductoController extends Controller
{

    //metodo para eliminar un iva o precio
    public function deletePrecioOIva() {
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        if( $tipo == 'precio' ) {
            $precio = PreciosProducto::find( $id );
            $precio -> delete();
        }
        if( $tipo == 'iva' ) {
            $iva = IvasProductos::find( $id );
            $iva -> delete();
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Precio o IVa Eliminada Correctamente',
        );
        return response()->json($response); 
    }

    //
    public function index() {
        $Productos = Producto::where( 'estado', 'A' )->orderBy('nombre')-> get(); // traigo los producto activos
        return view('admin.producto.index')->with(compact('Productos')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $Producto = Producto::where( 'codigo' , $id ) -> first();
        // $Imagenes = ImagenesProducto::where('fk_producto',$Producto->codigo) -> orderBy('featured','desc') -> get(); //para mostrar las imagenes ordenadas por las destacada
        return view('admin.producto.show')->with(compact('Producto'));
    }

    public function create() {
        $marcas = Marca::orderBy('nombre') -> get();
        $sizes = SizeBotella::orderBy('nombre') -> get();
        $tiposEnvase = TipoEnvase::orderBy('nombre') -> get();
        $tiposContenido = TipoContenido::orderBy('nombre') -> get();
        $tiposPaca = TipoPaca::orderBy('nombre') -> get();
        $bodegas = Bodega::orderBy('nombre') -> get();
        $descripcionesPrecio = DescripcionPrecio::orderBy('nombre') -> get();
        $descripcionesIva = DescripcionIva::orderBy('nombre') -> get();
        return view('admin.producto.create')->with(compact('marcas','sizes','tiposEnvase','tiposContenido','tiposPaca','bodegas','descripcionesPrecio','descripcionesIva'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        if( $request->input('fk_marca') == 'I' ) {
            $request['fk_marca'] = null;
        }
        if( $request->input('fk_size') == 'I' ) {
            $request['fk_size'] = null;
        }
        if( $request->input('fk_tipo_envase') == 'I' ) {
            $request['fk_tipo_envase'] = null;
        }
        if( $request->input('fk_tipo_contenido') == 'I' ) {
            $request['fk_tipo_contenido'] = null;
        }
        if( $request->input('fk_tipo_paca') == 'I' ) {
            $request['fk_tipo_paca'] = null;
        }
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        if( $request->input('cantidad') == null ) {
            $request['cantidad'] = 0;
        }
        // dd($arrayIvas." - ".$arrayDescripcionesIva);
        // foreach( $arrayPrecios as $precio ) {
        //     dd($precio);
        // }
        $this->validate($request,Producto::$rules,Producto::$messages);
        //crear un prodcuto nuevo
        $producto = new Producto();
//        dd($request->input('codigo'));
        $producto -> codigo = $request->input('codigo');
        $producto -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $producto -> descripcion = $request->input('descripcion');
        $producto -> cantidad = $request->input('cantidad');
        $producto -> cantidad_reserva = $request->input('cantidad_reserva');
        $producto -> precio_compra = $request->input('precio_compra');
        $producto -> fk_marca = $request->input('fk_marca');
        $producto -> fk_size = $request->input('fk_size');
        $producto -> fk_tipo_envase = $request->input('fk_tipo_envase');
        $producto -> fk_tipo_contenido = $request->input('fk_tipo_contenido');
        $producto -> fk_tipo_paca = $request->input('fk_tipo_paca');
        $producto -> fk_bodega = $request->input('fk_bodega');
        $producto -> estado = $request->input('estado');
        $producto -> save(); //registrar producto
        //fin de nuevo producto
        $arrayPrecios = explode("," , $request->input('input_precio') );
        $arrayDescripcionesPrecio = explode( "," , $request->input('input_descripcion_precio') );
        $arrayIvas = explode( "," , $request->input('input_iva') );
        $arrayDescripcionesIva = explode( "," , $request->input('input_descripcion_iva') );
        //insertar los precios del producto con su respectiva descripcion
        foreach( $arrayPrecios as $index => $precio ) {
            $precioProducto = new PreciosProducto();
            $precioProducto -> fk_producto = $producto->codigo;
            $precioProducto -> valor = $precio;
            $precioProducto -> fk_descripcion_precio = $arrayDescripcionesPrecio[$index];
            $precioProducto -> save();
        }
        // //fin insertar precios
        // //insertar los ivas del producto con su respectiva descripcion
        foreach( $arrayIvas as $index => $iva ) {
            $ivaProducto = new IvasProductos();
            $ivaProducto -> fk_producto = $producto->codigo;
            $ivaProducto -> valor = $iva;
            $ivaProducto -> fk_descripcion_iva = $arrayDescripcionesIva[$index];
            $ivaProducto -> save();
        }
        //fin insertar precios
        $notification = 'Producto Agregado Exitosamente';
        return redirect('/producto') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        $marcas = Marca::orderBy('nombre') -> get();
        $sizes = SizeBotella::orderBy('nombre') -> get();
        $tiposEnvase = TipoEnvase::orderBy('nombre') -> get();
        $tiposContenido = TipoContenido::orderBy('nombre') -> get();
        $tiposPaca = TipoPaca::orderBy('nombre') -> get();
        $bodegas = Bodega::orderBy('nombre') -> get();
        $descripcionesPrecio = DescripcionPrecio::orderBy('nombre') -> get();
        $descripcionesIva = DescripcionIva::orderBy('nombre') -> get();
        $producto = Producto::where( 'codigo' , $id ) -> first();
        return view('admin.producto.edit')->with(compact('producto','marcas','sizes','tiposEnvase','tiposContenido','tiposPaca','bodegas','descripcionesPrecio','descripcionesIva')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        if( $request->input('fk_marca') == 'I' ) {
            $request['fk_marca'] = null;
        }
        if( $request->input('fk_size') == 'I' ) {
            $request['fk_size'] = null;
        }
        if( $request->input('fk_tipo_envase') == 'I' ) {
            $request['fk_tipo_envase'] = null;
        }
        if( $request->input('fk_tipo_contenido') == 'I' ) {
            $request['fk_tipo_contenido'] = null;
        }
        if( $request->input('fk_tipo_paca') == 'I' ) {
            $request['fk_tipo_paca'] = null;
        }
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        if( $request->input('cantidad') == null ) {
            $request['cantidad'] = 0;
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Producto::$rules2,Producto::$messages2);
        //crear un prodcuto nuevo
        $producto = Producto::where( 'codigo',$id )->first();
        // $producto -> codigo = $request->input('codigo');
        $producto -> nombre = $request->input('nombre');
        // dd($request->input('fk_tipo_contenido'));
        //$product -> description = $request->input('description');
        $producto -> descripcion = $request->input('descripcion');
        $producto -> cantidad = $request->input('cantidad');
        $producto -> cantidad_reserva = $request->input('cantidad_reserva');
        $producto -> precio_compra = $request->input('precio_compra');
        $producto -> fk_marca = $request->input('fk_marca');
        $producto -> fk_size = $request->input('fk_size');
        $producto -> fk_tipo_envase = $request->input('fk_tipo_envase');
        $producto -> fk_tipo_contenido = $request->input('fk_tipo_contenido');
        $producto -> fk_tipo_paca = $request->input('fk_tipo_paca');
        $producto -> fk_bodega = $request->input('fk_bodega');
        $producto -> estado = $request->input('estado');
        $producto -> save(); //registrar producto
        //fin de nuevo producto
        if( !empty( $request->input('input_precio') ) ) {
            $arrayPrecios = explode("," , $request->input('input_precio') );
            $arrayDescripcionesPrecio = explode( "," , $request->input('input_descripcion_precio') );
            //insertar los precios del producto con su respectiva descripcion
            foreach( $arrayPrecios as $index => $precio ) {
                $precioProducto = new PreciosProducto();
                $precioProducto -> fk_producto = $producto->codigo;
                $precioProducto -> valor = $precio;
                $precioProducto -> fk_descripcion_precio = $arrayDescripcionesPrecio[$index];
                $precioProducto -> save();
            }
        }
        if( !empty($request->input('input_iva') ) ) {
            $arrayIvas = explode( "," , $request->input('input_iva') );
            $arrayDescripcionesIva = explode( "," , $request->input('input_descripcion_iva') );
            // //insertar los ivas del producto con su respectiva descripcion
            foreach( $arrayIvas as $index => $iva ) {
                $ivaProducto = new IvasProductos();
                $ivaProducto -> fk_producto = $producto->codigo;
                $ivaProducto -> valor = $iva;
                $ivaProducto -> fk_descripcion_iva = $arrayDescripcionesIva[$index];
                $ivaProducto -> save();
            }
        }   
        $notification = 'Producto ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/producto') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $producto = Producto::find( $id );
        $producto -> estado = 'I'; //Inactivo el estado del producto
        $producto -> save(); // guardo el producto con el estado inactivo
        $notification = 'El producto ' . $producto -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
