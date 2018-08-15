<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;
use App\Ruta;
use App\Venta;
use App\TipoDocumento;
use App\TipoNegocio;

class Cliente extends Model
{
    protected $primaryKey = 'number_id'; //cambiar nombre de llave primaria

    public static $messages = [
        'photo.max' => 'la imagen supera el tamaño maximo permitido de 2048 Kb',
        'photo.mimes' => 'la imagen debe tener un tipo de archivo jpeg,bmp,png o jpg',
        'photo.required' => '',
        'number_id.required' => '',

        
    ];

    public static $rules = [
        'number_id' => '',
        'name' => 'required|string|max:255',
        'tipo_documento_id' => 'required',        
        'address' => 'required|max:150',
        'phone' => '',
        'celular' => '',
        'email' => '',
        'ruta_id' => 'required',
        
        'bodega_id' => 'required',
        'valor_credito' => 'numeric',
        'photo' => 'max:2000|mimes:jpeg,bmp,png'
    ];

    public function bodega() {
        return Bodega::where('id',$this->bodega_id) -> first();
    }

    public function tipoDocumento() {
        return TipoDocumento::where('id',$this->tipo_documento_id) -> first();
    }

    public function ventas() {
        return $this->hasMany(Venta::class);
    }

    //obtener el nombre del tipo de documento
    public function getNombreTipoDocumentoAttribute() {
        return $this -> tipoDocumento() -> nombre;
    }

    public function ruta() {
        return $this->belongsTo(Ruta::class);
    }

    public function rutas() {
        return $this->belongsTo(Ruta::class);
    }

    public function tipoNegocio() {
        return $this->belongsTo(TipoNegocio::class);
    }

        
    
}
