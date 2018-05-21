<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoPaca;

class TipoPacaController extends Controller
{
    //
    public function index() {
        $tiposPacas = TipoPaca::orderBy('nombre') -> get();
        return view('admin.tipopaca.index')->with(compact('tiposPacas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $tipoPaca = TipoPaca::find( $id );
        return view('admin.tipopaca.show')->with(compact('tipoPaca'));
    }

    public function create() {
        return view('admin.tipopaca.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoPaca::$rules,TipoPaca::$messages);
        //crear un prodcuto nuevo
        $tipoPaca = new TipoPaca();
        $tipoPaca -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoPaca -> descripcion = $request->input('descripcion');
        $tipoPaca -> cantidad = $request->input('cantidad');
        if( $request->input('precio') == null ) {
            $tipoPaca -> precio = 0;
        }
        else {
            $tipoPaca -> precio = $request->input('precio');
        }
        if( $request->input('precio_envase') == null ) {
            $tipoPaca -> precio_envase = 0;
        }
        else {
            $tipoPaca -> precio_envase = $request->input('precio_envase');
        }
        // dd($request->input('retornable'));
        if( $request->input('retornable') == 'SI' ) {
            $tipoPaca -> retornable = true;
        }
        else {
            $tipoPaca -> retornable = false;
        }
        $tipoPaca -> estado = $request->input('estado');
        $tipoPaca -> save(); //registrar producto
        $notification = 'Tipo de Paca Agregado Exitosamente';
        return redirect('/tipopaca') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoPaca = TipoPaca::find( $id );
        return view('admin.tipopaca.edit')->with(compact('tipoPaca')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoPaca::$rules,TipoPaca::$messages);
        //crear un prodcuto nuevo
        $tipoPaca = TipoPaca::find( $id );
        $tipoPaca -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoPaca -> descripcion = $request->input('descripcion');
        $tipoPaca -> cantidad = $request->input('cantidad');
        $tipoPaca -> precio = $request->input('precio');
        $tipoPaca -> precio_envase = $request->input('precio_envase');
        if( $request->input('retornable') == 'SI' ) {
            $tipoPaca -> retornable = true;
        }
        else {
            $tipoPaca -> retornable = false;
        }
        $tipoPaca -> estado = $request->input('estado');
        $tipoPaca -> save(); //registrar producto

        $notification = 'Tipo de Paca ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/tipopaca') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoPaca = TipoPaca::find( $id );
        $tipoPaca -> delete(); //ELIMINAR
        $notification = 'Tipo de Paca ' . $tipoPaca -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
