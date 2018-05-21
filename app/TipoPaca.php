<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPaca extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        'cantidad.required' => 'La cantidad es un campo obligatorio',
        'cantidad.numeric' => 'La cantidad es un campo que solo acepta numeros',
        'precio.min' => 'El precio no debe ser menor de cero',
        'precio.numeric' => 'El precio es un campo que solo acepta numeros',
        'precio_envase.min' => 'El precio no debe ser menor de cero',
        'precio_envase.numeric' => 'El precio es un campo que solo acepta numeros',
        'retornable.required' => 'El campo Retornable es un campo obligatorio',
        'estado.required' => 'El estado es un campo obligatorio'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'max:300',
            'cantidad' => 'required|numeric',
            'precio' => 'numeric|min:0',
            'precio_envase' => 'numeric|min:0',
            'retornable' => 'required',
            'estado' => 'required'
    ];

}
