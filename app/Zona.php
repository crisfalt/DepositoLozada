<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;
use App\Ruta;
use App\DiasRutas;
use DB;

class Zona extends Model
{
    protected $fillable = [
        'id', 'nombre', 'descripcion','bodega_id','estado'
    ];
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        'fk_bodega.required' => 'La Bodega es un campo obligatorio',
        'estado.required' => 'El estado es un campo obligatorio'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100',
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'max:300',
            'fk_bodega' => 'required',
            'estado' => 'required'
    ];

    public function bodega() {
        return $bodega = Bodega::where('id',$this->bodega_id) -> first();
    }

    public function rutas() {
        return $this->hasMany(Ruta::class); //1 zona tiene muchas rutas
    }

    public function rutasDelDia($diaActual) {
        return Ruta::with('dias_rutas')
                            ->join('dias_rutas as dr','rutas.id','=','dr.ruta_id')
                            ->where('dr.dia','=',$diaActual)
                            ->where('rutas.estado','=','A')
                            ->where('rutas.zona_id','=',$this->id)
                            ->select("dr.id as dias_rutas_id","dr.dia as dia","dr.ruta_id as dias_rutas_ruta_id","rutas.id as ruta_id","rutas.nombre as ruta_nombre","rutas.zona_id as ruta_zona_id")
                            ->orderBy('rutas.nombre')
                            ->distinct()
                            ->get();
    }

}
