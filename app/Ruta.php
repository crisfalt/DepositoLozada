<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zona;
use App\OrdenRuta;
use App\DiasRutas;
use DB;

class Ruta extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        // 'nombre.unique' => 'El nombre ya existe',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        'estado.required' => 'El estado es un campo obligatorio',
        'dias_almacenados.required' => 'Debes asignar al menos 1 dia de la semana a la ruta'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'max:300',
            'estado' => 'required',
            'dias_almacenados' => 'required'
    ];

    public static function diasSemana() {
        return $dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
    }

    public function zona() {
        return Zona::where('id',$this -> zona_id) -> first(); //1 pdoducto pertene a una categoria
    }

    public function diasCargados() {
        return DiasRutas::where('ruta_id',$this -> id ) -> get();
    }

    public function clientes() {
        return Cliente::where('ruta_id',$this -> id ) -> get();
    }

    public function union() {
        $unidas = DB::table('orden_rutas')
                            ->join('clientes','orden_rutas.cliente_id','=','clientes.number_id')
                            ->where('orden_rutas.ruta_id','=',$this->id)
                            ->orderBy('orden_rutas.orden')
                            ->distinct()
                            ->get();
        return $unidas;
    }

    public function listaOrdenada() {
        $users = OrdenRuta::where('ruta_id',$this -> id ) ->orderBy('orden' , 'ASC') -> get();
        return $users;
    }

}
