<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\TipoDocumento;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','tipo_documento_id','number_id','address','phone','celular','perfil_id','bodega_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tipoDocumento() {
        return $this -> belongsTo( TipoDocumento::class );
    }

    public function perfil() {
        return $this->belongsTo(Perfil::class);
    }

    public function bodega() {
        return $this->belongsTo(Bodega::class);
    }

}
