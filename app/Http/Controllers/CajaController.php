<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Caja;
use App\CajaEmpleado;
use App\User;
use App\Bodega;

class CajaController extends Controller
{

    public function asignarCaja( $caja , $valor ) {
        $cajaAsignar = Caja::where( 'id' , $caja ) -> first();
        $cajaAsignar -> ocupada = true;
        $cajaAsignar -> save();
        $empleadoCaja = new CajaEmpleado();
        $empleadoCaja -> caja_id = $caja;
        $empleadoCaja -> user_id = auth() -> user()->id;
        $empleadoCaja -> fecha = Carbon::now();
        $empleadoCaja -> save();
        $response = array(
            'status' => 'success',
            'msg' => 'Caja ' . $caja . ' Asignada Correctamente ',
        );
        return response()->json($response); 
    }

    //metodo para cargar las cajas al iniciar sesion el cajero
    public function getCajas() {
        $empleadoCaja = CajaEmpleado::where('user_id',auth()->user()->id ) -> first();
        if( $empleadoCaja != null ) {
            $fechaActual = new \DateTime('now');;
            $fechaConsulta = \DateTime::createFromFormat('Y-m-d', $empleadoCaja -> fecha );
            if( $fechaActual == $fechaConsulta ) {
                $cajaAsignada = Caja::where( 'id' , $empleadoCaja -> caja_id ) -> first();
                if( $cajaAsignada -> ocupada ) { //si la caja esta ocupada
                    return response()->json(array('success' => false, 'msg' => 'Ya tiene una caja asignada'));
                }
                else {
                    $Cajas = Caja::where('ocupada' , false ) -> get();//me trae las cajas que esten desocupadas
                    return response()->json(array('success' => true, 'msg' => $fechaActual, 'Cajas' => $Cajas));
                }
            }
            else {
                $Cajas = Caja::where('ocupada' , false ) -> get();//me trae las cajas que esten desocupadas
                return response()->json(array('success' => true, 'msg' => $fechaActual, 'Cajas' => $Cajas));
            }
        }
        else {
            $Cajas = Caja::where('ocupada' , false ) -> get();//me trae las cajas que esten desocupadas
            return response()->json(array('success' => true, 'Cajas' => $Cajas));
        }
    }
    //
    public function index() {
        $Cajas = Caja::orderBy('nombre') -> get();
        return view('caja.index')->with(compact('Cajas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $caja = Caja::find( $id );
        return view('caja.show')->with(compact('caja'));
    }

    public function create() {
        $bodegas = Bodega::orderBy('nombre') -> get();
        return view('caja.create') -> with(compact('bodegas'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        $this->validate($request,Caja::$rules,Caja::$messages);
        //crear un prodcuto nuevo
        $caja = new Caja();
        $caja -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $caja -> bodega_id = $request->input('fk_bodega');
        $caja -> estado = $request->input('estado');
        $caja -> save(); //registrar producto
        $notification = 'caja Agregada Exitosamente';
        return redirect('/caja') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $caja = Caja::find( $id );
        return view('caja.edit')->with(compact('caja')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Caja::$rules,Caja::$messages);
        //crear un prodcuto nuevo
        $caja = Caja::find( $id );
        $caja -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $caja -> descripcion = $request->input('descripcion');
        $caja -> estado = $request->input('estado');
        $caja -> save(); //registrar producto

        $notification = 'caja ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/caja') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $caja = Caja::find( $id );
        $caja -> delete(); //ELIMINAR
        $notification = 'caja ' . $caja -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
