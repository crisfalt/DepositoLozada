<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;

class Zona extends Model
{
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

}
