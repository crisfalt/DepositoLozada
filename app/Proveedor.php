<?php

namespace App;

use App\TipoDocumento;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $primaryKey = 'number_id'; //cambiar nombre de llave primaria
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


    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumento::class);
//        return TipoDocumento::where('id',$this->tipo_documento_id) -> first();
    }

    //obtener el nombre del tipo de documento
    public function getNombreTipoDocumentoAttribute() {
        return $this -> tipoDocumento -> nombre;
    }

}
