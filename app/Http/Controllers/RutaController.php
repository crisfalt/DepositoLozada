<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use App\Ruta;
use App\Zona;
use App\DiasRutas;

class RutaController extends Controller
{


    public function details( $id )  {
        $ruta = Ruta::where('id',$id)->where('estado','A')->first();
//        dd($ruta);
        $count = Cliente::where('ruta_id',$id)->where('estado','A')->count();
        return view('admin.ruta.details')->with(compact('ruta','count')); //listado de tipos movimientos
    }

    //metodo para reordenar la lista de la ruta
    public function reordenar() {
        $data = json_decode($_POST['array']);
        // dd($data);
        $ruta_id = $_POST['ruta_id'];
        $ruta = Ruta::find( $ruta_id );
        $listaOrdenada = $ruta -> listaOrdenada();
        //mi metodo de busqueda binaria y secuencial voraz
        for( $i = 0 ; $i < count( $listaOrdenada ) ; $i++ ) {
            $cambiarOrden = $listaOrdenada[ $i ];
            for( $j = 0 ; $j < count( $data ) ; $j++ ) {
                if( $cambiarOrden -> id == $data[ $j ][ 0 ] ) {
                    // echo "<script>console.log( 'lo encontro' );</script>";
                    $cambiarOrden -> orden = $data[ $j ][ 1 ];
                    $cambiarOrden -> save();
                    break;
                }
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Ruta Ordenada Correctamente ',
        );
        return response()->json($response); 
    }

    //cargar todas las rutas existentes
    public function allRutas() {
        $rutas = Ruta::where('estado','A')->orderBy('nombre') -> get();
        return view('admin.ruta.alls')->with(compact('rutas')); //listado de tipos movimientos
    }

    //cargar el mapa de una ruta
    public function loadMap( $id ) {
        $ruta = Ruta::find($id);
        // dd( $ruta -> clientes() );
        return view('admin.ruta.map')->with(compact('ruta'));
    }

    //
    public function index( $id ) {
        $zona = Zona::find($id);
        $rutas = $zona -> rutas() -> orderBy('nombre') -> get();
        return view('admin.ruta.index')->with(compact('zona','rutas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $ruta = Ruta::find( $id );
        return view('admin.ruta.show')->with(compact('ruta'));
    }

    public function create( $id ) {
        $zona = Zona::find( $id );
        $diasSemana = Ruta::diasSemana();
        return view('admin.ruta.create')->with( compact( 'zona','diasSemana' ) );
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
//        dd($request->input('dias_almacenados'));
        $this->validate($request,Ruta::$rules,Ruta::$messages);
        // dd( $request->input('zona_id') );
        //crear un prodcuto nuevo
        $ruta = new ruta();
        $ruta -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $ruta -> descripcion = $request->input('descripcion');
        $ruta -> estado = $request->input('estado');
        $ruta -> zona_id = $request->input('zona_id');
//        $ruta -> user_id = ;
        $ruta -> save(); //registrar producto
        //agregar los dias de esa ruta
        $arrayDias = explode("," , $request->input('dias_almacenados') );
        foreach( $arrayDias as $index => $dia ) {
            $diaRuta = new DiasRutas();
            $diaRuta -> dia = $dia;
            $diaRuta -> ruta_id = $ruta -> id;
            $diaRuta -> save();
        }
        $notification = 'ruta Agregada Exitosamente';
        return redirect('/zona/'.$request->input('zona_id').'/rutas') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $ruta = Ruta::find( $id );
        $diasSemana = Ruta::diasSemana();
        return view('admin.ruta.edit')->with(compact('ruta','diasSemana')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Ruta::$rules,Ruta::$messages);
        //crear un prodcuto nuevo
        $ruta = Ruta::find( $id );
        $ruta -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $ruta -> descripcion = $request->input('descripcion');
        $ruta -> zona_id = $request->input('zona_id');
        $ruta -> estado = $request->input('estado');
        $ruta -> save(); //registrar producto
        //agregar los dias de esa ruta
        if( !empty( $request->input('dias_almacenados') ) ) {
            $arrayDias = explode("," , $request->input('dias_almacenados') );
            foreach( $arrayDias as $index => $dia ) {
                $diaRuta = new DiasRutas();
                $diaRuta -> dia = $dia;
                $diaRuta -> ruta_id = $ruta -> id;
                $diaRuta -> save();
            }
        }
        $notification = 'Ruta ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/zona/'.$request->input('zona_id').'/rutas') -> with( compact( 'notification' ) );
    }

    //funcion para eliminar un dia de la ruta
    public function deleteDay() {
        $id = $_POST['id'];
        $diaRuta = DiasRutas::find($id);
        if( empty($diaRuta) ) {
            $response = array(
                'status' => 'false',
                'msg' => 'No se pudo Eliminar el Dia',
            );
        }
        else {
            $diaRuta -> delete();
            $response = array(
                'status' => 'true',
                'msg' => 'Dia Eliminado Correctamente',
            );
        }
        return response()->json($response);
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $ruta = Ruta::find( $id );
        $ruta->estado = 'I';
        //eliminar en cascada
        $ruta -> save(); //ELIMINAR
        $notification = 'Ruta ' . $ruta -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
