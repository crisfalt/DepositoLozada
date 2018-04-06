<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bodega;

class Municipio extends Model
{
    //
    public function bodegas() {
        return $this->hasMany( Bodega::class );
    }

}
