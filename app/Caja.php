<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;

class Caja extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'estado.required' => 'El estado es un campo obligatorio',
        'fk_bodega.required' => 'La Bodega es un campo obligatorio'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100|unique:cajas,nombre',
            'estado' => 'required',
            'fk_bodega' => 'required'
    ];

    //1 caja pertenece a una bodega
    public function bodega()
    {
    	return $this->belongsTo(Bodega::class);
    }

}
