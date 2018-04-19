<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use App\Bodega;

class ZonaController extends Controller
{
    //
    public function index() {
        $zonas = Zona::orderBy('nombre') -> get();
        return view('admin.zona.index')->with(compact('zonas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $zona = Zona::find( $id );
        return view('admin.zona.show')->with(compact('zona'));
    }

    public function create() {
        $bodegas = Bodega::orderBy('nombre') -> get();
        return view('admin.zona.create')->with(compact('bodegas')); //listado de tipos movimientos;
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        $this->validate($request,Zona::$rules,Zona::$messages);
        //crear un prodcuto nuevo
        $zona = new Zona();
        $zona -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $zona -> descripcion = $request->input('descripcion');
        $zona -> bodega_id = $request['fk_bodega'];
        $zona -> estado = $request->input('estado');
        $zona -> save(); //registrar producto
        $notification = 'zona Agregada Exitosamente';
        return redirect('/zona') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $zona = Zona::find( $id );
        return view('admin.zona.edit')->with(compact('zona')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Zona::$rules,Zona::$messages);
        //crear un prodcuto nuevo
        $zona = Zona::find( $id );
        $zona -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $zona -> descripcion = $request->input('descripcion');
        $zona -> bodega_id = $request['fk_bodega'];
        $zona -> estado = $request->input('estado');
        $zona -> save(); //registrar producto

        $notification = 'zona ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/zona') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $zona = Zona::find( $id );
        //inicio eliminar todas las rutas de la zona que se eliminara
        $rutas = $zona -> rutas() -> get();
        foreach( $rutas as $ruta ) {
            $ruta -> delete();
        }
        //fin eliminiar rutas
        $zona -> delete(); //ELIMINAR
        $notification = 'zona ' . $zona -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
