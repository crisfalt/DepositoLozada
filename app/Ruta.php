<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Zona;
use App\OrdenRuta;
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
        'estado.required' => 'El estado es un campo obligatorio'
    ];

    public static $rules = [
            // 'nombre' => 'required|min:3|max:100', |unique:rutas,nombre'
            'descripcion' => 'max:300',
            'estado' => 'required'
    ];

    public function zona() {
        return $this->belongsTo(Zona::class); //1 pdoducto pertene a una categoria
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
