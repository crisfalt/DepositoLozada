<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DescripcionPrecio;

class PreciosProducto extends Model
{
    //
    protected $fillable = [
        'fk_producto', 'valor', 'fk_descripcion_precio'
    ];

    public function nombreDescripcion() {
        return DescripcionPrecio::where('id',$this->fk_descripcion_precio)->first();
    }

}
