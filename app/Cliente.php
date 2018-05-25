<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;
use App\Ruta;

class Cliente extends Model
{
    // 'phone' => 'sometimes|numeric|between:0,99999999999999999999',
    //     'celular' => 'sometimes|numeric|between:0,99999999999999999999',
    //     'email' => 'sometimes|string|email|max:255|unique:users',
    //
    public static $messages = [
        'number_id.unique' => 'Ya hay un usuario registrado con el mismo numero de documento',
        'photo.required' => 'No se ha seleccionado ninguna imagen'
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'number_id' => 'required|max:30|unique:clientes,number_id',
        'tipo_documento_id' => 'required',
        'address' => 'required|max:150',
        'phone' => '',
        'celular' => '',
        'email' => '',
        'ruta_id' => 'required',
        'bodega_id' => 'required',
        'valor_credito' => 'numeric',
        'photo' => 'required'
    ];

    public function bodega() {
        return Bodega::where('id',$this->bodega_id) -> first();
    }

    public function ruta() {
        return Ruta::where('id',$this->ruta_id) -> first();
    }
    
}
