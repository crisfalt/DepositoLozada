<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvasProductos extends Model
{
    //
    protected $fillable = [
        'fk_producto', 'valor', 'fk_descripcion_iva'
    ];

    public function nombreDescripcion() {
        return DescripcionIva::where('id',$this->fk_descripcion_iva)->first();
    }

}
