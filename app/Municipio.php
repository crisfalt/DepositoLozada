<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    //
    public function bodegas()
    {
        return $this->hasMany(Bodega::class);
    }
}
