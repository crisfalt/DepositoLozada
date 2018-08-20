<?php

namespace App;

use App\Ruta;
use Illuminate\Database\Eloquent\Model;

class DiasRutas extends Model
{
    //
    public function rutas() {
        return $this->belongsTo( Ruta::class );
    }

}
