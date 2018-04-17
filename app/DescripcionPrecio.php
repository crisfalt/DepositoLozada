<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionPrecio extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        'estado.required' => 'El estado es un campo obligatorio'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'max:300',
            'estado' => 'required'
    ];

}
