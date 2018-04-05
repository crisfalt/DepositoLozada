<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;

class MarcaController extends Controller
{
    //
    public function index() {
        $Marcas = Marca::orderBy('nombre') -> get();
        return view('admin.marca.index')->with(compact('Marcas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $marca = Marca::find( $id );
        return view('admin.marca.show')->with(compact('marca'));
    }

    public function create() {
        return view('admin.marca.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Marca::$rules,Marca::$messages);
        //crear un prodcuto nuevo
        $marca = new Marca();
        $marca -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $marca -> descripcion = $request->input('descripcion');
        $marca -> estado = $request->input('estado');
        $marca -> save(); //registrar producto
        $notification = 'Marca Agregada Exitosamente';
        return redirect('/marca') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $marca = Marca::find( $id );
        return view('admin.marca.edit')->with(compact('marca')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Marca::$rules,Marca::$messages);
        //crear un prodcuto nuevo
        $marca = Marca::find( $id );
        $marca -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $marca -> descripcion = $request->input('descripcion');
        $marca -> estado = $request->input('estado');
        $marca -> save(); //registrar producto

        $notification = 'Marca ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/marca') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $marca = Marca::find( $id );
        $marca -> delete(); //ELIMINAR
        $notification = 'Marca ' . $marca -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
