<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    public static $rules = [
        'name' => 'required|string|max:255',
        'number_id' => 'required|max:30',
        'tipo_documento_id' => 'required',
        'address' => 'required|max:150',
        'phone' => 'required|numeric|between:0,99999999999999999999',
    ];

    public static $rulesEmail = [
        'name' => 'required|string|max:255',
        'number_id' => 'required|max:30',
        'tipo_documento_id' => 'required',
        'address' => 'required|max:150',
        'phone' => 'required|numeric|between:0,99999999999999999999',
        'email' => 'sometimes|string|email|max:255|unique:proveedors,email',
    ];

    public static $rulesCelular = [
        'name' => 'required|string|max:255',
        'number_id' => 'required|max:30',
        'tipo_documento_id' => 'required',
        'address' => 'required|max:150',
        'phone' => 'required|numeric|between:0,99999999999999999999',
        'celular' => 'numeric|between:0,99999999999999999999',
    ];

}
