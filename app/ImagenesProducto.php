<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImagenesProducto;

class ImagenesProducto extends Model
{
    //
    //metodo que muestra la nueva image subida en el foreach donde tambien se cargan imagenes
    public function getUrlAttribute() {
        if( substr( $this->image , 0 , 4 ) == "http" ) {
            return $this -> image;
        }
        return '/imagenes/productos/' . $this -> url_imagen;
    }

    public function producto() {
        return $this->belongsTo(ImagenesProducto::class); //1 pdoducto pertene a una categoria
    }

}
