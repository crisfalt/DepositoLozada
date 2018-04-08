<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Municipio;

class Bodega extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'nombre.unique' => 'El nombre que elegiste ya existe',
        'direccion.required' => 'La direccion es un campo obligatorio',
        'direccion.max' => 'La direccion debe tener maximo 100 caracteres',
        'telefono.required' => 'El Telefono es un campo obligatorio',
        'telefono.numeric' => 'El telefono solo acepta numeros',
        'telefono.max' => 'El telefono debe tener maximo 16 numeros',
        'celular.numeric' => 'El celular solo acepta numeros',
        'celular.max' => 'El celular debe tener maximo 16 numeros',
        'fk_municipio.required' => 'El Municipio es un campo obligatorio'
    ];

    public static $rules = [
            'nombre' => 'required|max:100|unique:bodegas,nombre',
            'direccion' => 'required|max:100',
            'telefono' => 'numeric|required|max:9999999999999999',
            'celular' => 'numeric|max:9999999999999999',
            'fk_municipio' => 'required'
    ];

    public function municipio() {
        return $this->belongsTo( Municipio::class );
    }

}
