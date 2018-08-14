<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoNegocio;

class TipoNegocioController extends Controller
{
     public function index() {
    	
        $tiposNegocios = TipoNegocio::where('estado','A')->orderBy('nombre') -> get();
        return view('admin.tiponegocio.index')->with(compact('tiposNegocios')); 
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        
        $tiposNegocio = TipoNegocio::where( 'id' , $id ) -> first();
        return view('admin.tiponegocio.show')->with(compact('tiposNegocio'));
    }

    public function create() {
        return view('admin.tiponegocio.create');
    }

    public function store( Request $request ) {
       
        $this->validate($request,TipoNegocio::$rules,TipoNegocio::$messages);
        //crear un prodcuto nuevo
        $tiposNegocio = new TipoNegocio();
        $tiposNegocio -> nombre = $request->input('nombre');        
        $tiposNegocio -> descripcion = $request->input('descripcion');
        $tiposNegocio -> estado = $request->input('estado');
        $tiposNegocio -> save();
        $notification = 'Tipo de Negocio Agregado Exitosamente';
        return redirect('tiponegocio') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        
        $tiposNegocio =  TipoNegocio::find($id);
        return view('admin.tiponegocio.edit')->with(compact('tiposNegocio')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        
        $this->validate($request,TipoNegocio::$rules,TipoNegocio::$messages);
        //crear un prodcuto nuevo
        $tiposNegocio = TipoNegocio::find( $id );
        $tiposNegocio -> nombre = $request->input('nombre');       
        $tiposNegocio -> descripcion = $request->input('descripcion');
        $tiposNegocio -> estado = $request->input('estado');
        $tiposNegocio -> save();
        $notification = 'Tipo de Negocio ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/tiponegocio') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {

    	$tiposNegocio = TipoNegocio::find( $id );
        $tiposNegocio -> estado = 'I'; //Inactivo el estado del producto
        $tiposNegocio -> save(); // guardo el producto con el estado inactivo
        $notification = 'El Tipo de Negocio  ' . $tiposNegocio -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
       
    }
}
