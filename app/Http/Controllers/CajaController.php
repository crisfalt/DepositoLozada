<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Caja;
use App\MovimientoCaja;
use App\CajaEmpleado;
use App\User;
use App\Bodega;
use App\TipoMovimiento;

class CajaController extends Controller
{
    public function entrada() {
        $movimientos = TipoMovimiento::all();
        return view('caja.entrada')->with(compact('movimientos'));
    }

    public function salida() {
        $movimientos = TipoMovimiento::all();
        return view('caja.salida')->with(compact('movimientos'));
    }

    public function storeMovimiento( Request $request ) {
        $messages = [
            'descripcion.required' => 'La descripción del movimiento es un campo obligatorio.',
            'descripcion.max' => 'La descripción del movimiento solo admite hasta 200 caracteres.',
            'valor.required' => 'Es obligatorio definir un precio para la entrada de movimiento en caja.',
            'valor.numeric' => 'Ingrese un precio válido.',
            'valor.min' => 'No se admiten valores negativos.'
        ];
        $rules = [
            'descripcion' => 'required|max:200',
            'valor' => 'required|numeric|min:0'
        ];
        $this->validate($request, $rules, $messages);
        $movimientoCaja = new MovimientoCaja();
        $movimientoCaja -> fecha = Carbon::now()->format('Y-m-d');
        $movimientoCaja -> hora = Carbon::now()->toTimeString();
        $movimientoCaja -> valor = $request->input('valor');
        $movimientoCaja -> tipo_movimiento = $request->input('tipo_movimiento_id');
        $movimientoCaja -> caja_id = 1;
        $movimientoCaja -> descripcion = $request->input('descripcion');
        $movimientoCaja -> save();
        $notification = 'Entrada a Caja Agregada Exitosamente';
        return redirect('/movimientocaja') -> with( compact( 'notification' ) );
    }

    public function closed() {
        $salidas = MovimientoCaja::where('fecha',Carbon::now()->format('Y-m-d'))->where('tipo_movimiento',2)->get();
        $entradas = MovimientoCaja::where('fecha',Carbon::now()->format('Y-m-d'))->where('tipo_movimiento',1)->get();
        return view('caja.closed')->with(compact('entradas','salidas'));
    }

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
            $cajaAsignada = Caja::where('id',$empleadoCaja->caja_id)->first();
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

    //recibo de salida de caja

    

}
