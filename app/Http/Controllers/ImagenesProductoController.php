<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Producto;
use App\ImagenesProducto;
use File; //clase file php

class ImagenesProductoController extends Controller
{
    //
    public function index( $codigo ) {
        $producto = Producto::where('codigo',$codigo)->first();
        // dd($producto->codigo);
        $imagenes = ImagenesProducto::where('fk_producto',$producto->codigo) -> orderBy('featured','desc') -> get(); //para mostrar las imagenes ordenadas por las destacada
        return view('admin.producto.imagenes.index')->with(compact('producto','imagenes')); //listado de productos
    }

    //guardar imagen
    public function store( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        // dd($request->file('photo'));
        $messages = [
            'photo.required' => 'No se ha seleccionado ninguna imagen'
            // 'photo.image' => 'Debe ser una imagen con formato (jpg, png, bmp, gif, or svg))'
        ];
        $rules = [
                'photo' => 'required'
        ];
        $this->validate($request,$rules,$messages);
        //crear un prodcuto nuevo
        $file = $request->file('photo');
        if (App::environment('local')) {
            $path = public_path() . '/imagenes/productos'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
        }
        else {
            $path = 'imagenes/productos';
        }
        $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
        $moved = $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor
        $notification = "";
        if( $moved ) {
            $productImage = new ImagenesProducto();
            $productImage -> url_imagen = $fileName;
            $productImage -> fk_producto = $id;
            $productImage -> save(); //registrar imagen del producto
            $notification = "La Imagen se ha subido sastifactoriamente";
        }
        else {
            $notification = "Hubo un error subiendo la imagen";
        }
        return back() -> with(compact('notification'));
        //crear registro para imagen de producto
        // return dd($request->file('photo'));
    }

    //Eliminar
    public function destroy( Request $request , $id ) {
//        $categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";

        //eliminar archivo imagen de la carpeta public
        $productImage = ImagenesProducto::find( $request -> input('image_id') );
        if( substr( $productImage -> url_imagen , 0 , 4  ) === "http" ) {
            $deleted = true;
        }
        else {
            if (App::environment('local')) {
                $fullPath = public_path() . '/imagenes/productos/' . $productImage -> url_imagen; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            }
            else {
                $fullPath = 'imagenes/productos/' . $productImage -> url_imagen; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            }
            $deleted = File::delete( $fullPath ); //nos devuelve si la imagen ha sido eliminada o no del public
        }
        //eliminar registro de la bd
        $notification = "";
        if( $deleted ) {
            $productImage -> delete(); //ELIMINAR
            $notification = "Imagen eliminda Correctamente";
        }
        return back()->with(compact('notification') ); //nos devuelve a la pagina anterior
    }

    //poner imagen destacada
    public function select( $idProduct , $idImage ) {
        // dd("llego al select");
        //quitar la anterior imagen destacada
        ImagenesProducto::where( 'fk_producto' , $idProduct ) -> update( [
            'featured' => false
        ]);

        //poner la imagen destacada
        $productImage = ImagenesProducto::find( $idImage );
        $productImage -> featured = true;
        $productImage -> save(); //guardar cambios
        return back();
    }

}
