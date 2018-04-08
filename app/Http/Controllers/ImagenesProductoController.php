<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\ImagenesProducto;
use File; //clase file php

class ImagenesProductoController extends Controller
{
    //
    public function index( $codigo ) {
        $producto = Producto::where('codigo',$codigo)->get();
        // dd($producto[0]->codigo);
        $imagenes = ImagenesProducto::where('fk_producto',$producto[0]->codigo) -> orderBy('featured','desc') -> get(); //para mostrar las imagenes ordenadas por las destacada
        dd($imagenes[0]->nombre);
        return view('admin.producto.imagenes.index')->with(compact('producto','imagenes')); //listado de productos
    }

    //guardar imagen
    public function store( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $messages = [
            'photo.required' => 'La imagen es un campo obligatorio'
            // 'photo.image' => 'Debe ser una imagen con formato (jpg, png, bmp, gif, or svg))'
        ];
        $rules = [
                'photo' => 'required'
        ];
        $this->validate($request,$rules,$messages);
        //crear un prodcuto nuevo
        $file = $request->file('photo');
        $path = public_path() . '/images/products'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
        $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
        $moved = $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor

        if( $moved ) {
            $productImage = new ProductImage();
            $productImage -> image = $fileName;
            $productImage -> product_id = $id;
            $productImage -> save(); //registrar imagen del producto
        }
        return back();
        //crear registro para imagen de producto
        // return dd($request->file('photo'));
    }

    //Eliminar
    public function destroy( Request $request , $id ) {
//        $categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";

        //eliminar archivo imagen de la carpeta public
        $productImage = ProductImage::find( $request -> input('image_id') );
        if( substr( $productImage -> image , 0 , 4  ) === "http" ) {
            $deleted = true;
        }
        else {
            $fullPath = public_path() . '/images/products/' . $productImage -> image; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            $deleted = File::delete( $fullPath ); //nos devuelve si la imagen ha sido eliminada o no del public
        }
        //eliminar registro de la bd
        if( $deleted ) {
            $productImage -> delete(); //ELIMINAR
        }
        return back(); //nos devuelve a la pagina anterior
    }

    //poner imagen destacada
    public function select( $idProduct , $idImage ) {
        //quitar la anterior imagen destacada
        ProductImage::where( 'product_id' , $idProduct ) -> update( [
            'featured' => false
        ]);

        //poner la imagen destacada
        $productImage = ProductImage::find( $idImage );
        $productImage -> featured = true;
        $productImage -> save(); //guardar cambios
        return back();
    }

}
