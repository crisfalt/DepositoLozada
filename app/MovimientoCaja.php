<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoMovimiento;

class MovimientoCaja extends Model
{
    //
    //relacion con tipo de movimiento
    // public function tipoMovimiento() {
    //     return TipoMovimiento::where( 'id' , $this -> tipo_movimiento )->first();
    // }
}
