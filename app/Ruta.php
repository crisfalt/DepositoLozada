<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Zona;
use App\OrdenRuta;
use App\DiasRutas;
use App\detalles_venta;
use App\User;
use DB;

class Ruta extends Model
{
    //
    public static $messages = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        // 'nombre.unique' => 'El nombre ya existe',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        'estado.required' => 'El estado es un campo obligatorio',
        'dias_almacenados.required' => 'Debes asignar al menos 1 dia de la semana a la ruta'
    ];

    public static $rules = [
            'nombre' => 'required|min:3|max:100',
            'descripcion' => 'max:300',
            'estado' => 'required',
            'dias_almacenados' => 'required'
    ];

    public static function diasSemana() {
        return $dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
    }

    public function zona() {
        return $this->belongsTo(Zona::class);
//        return Zona::where('id',$this -> zona_id) -> first(); //1 pdoducto pertene a una categoria
    }

    public function diasCargados() {
        return DiasRutas::where('ruta_id',$this -> id ) -> get();
    }

    public function dias_rutas() {
        return $this->hasMany(DiasRutas::class);
    }

    public function clientes() {
        return $this->hasMany(Cliente::class);
    }

    public function vendedor() {
        return $this->belongsTo(User::class);
    }

    public function union() {
        $unidas = DB::table('orden_rutas')
                            ->join('clientes','orden_rutas.cliente_id','=','clientes.number_id')
                            ->where('orden_rutas.ruta_id','=',$this->id)
                            ->orderBy('orden_rutas.orden')
                            ->distinct()
                            ->get();
        return $unidas;
    }

    public function detallesPorRuta($fecha_inicio,$fecha_final,$idRuta) {
        setlocale(LC_ALL,"es_ES");
//        dd(Carbon::now()->format('Y-m-d').' '.$idRuta);
        $tmp = detalles_venta::with('ventas')
            ->join('ventas','detalles_ventas.fk_factura','=','ventas.id')
            ->join('clientes','ventas.fk_cliente','=','clientes.number_id')
            ->join('rutas','rutas.id','=','clientes.ruta_id')
            ->join('productos as p','p.codigo','=','detalles_ventas.fk_producto')
            ->join('marcas as m','m.id','=','p.fk_marca')
            ->join('size_botellas as s','s.id','=','p.fk_size')
            ->whereBetween('ventas.fecha_entrega', array($fecha_inicio, $fecha_final))
            ->where('rutas.id','=',$idRuta)
            ->select('detalles_ventas.fk_producto',DB::raw('SUM(detalles_ventas.cantidad) as cantidad'),'p.nombre as producto_nombre','m.nombre as marca_nombre','s.nombre as size_nombre')
            ->groupBy('detalles_ventas.fk_producto')
            ->get();
//        dd($tmp);
        return $tmp;
    }

    public function facturasPorRuta($fecha_inicio,$fecha_final,$idRuta) {
        return Venta::with('clientes')
                            ->join('clientes as c','ventas.fk_cliente','=','c.number_id')
                            ->join('rutas as r','r.id','=','c.ruta_id')
                            ->where('ventas.fk_estado_venta','=',2)
                            ->where('r.id','=',$idRuta)
                            ->whereBetween('ventas.fecha_entrega', array($fecha_inicio, $fecha_final))
                            ->select("c.*","r.*","ventas.id as factura_id","ventas.fk_cliente as fk_cliente","ventas.fk_vendedor as fk_vendedor","ventas.fk_estado_venta as fk_estado_venta","ventas.fk_bodega as fk_bodega","ventas.fk_forma_de_pago as fk_forma_de_pago","ventas.total as total","ventas.fecha_entrega as fecha_entrega")
                            ->orderBy('r.nombre')
                            ->distinct()
                            ->get();
    }

    public function listaOrdenada() {
        $users = OrdenRuta::where('ruta_id',$this -> id ) ->orderBy('orden' , 'ASC') -> get();
//        dd($users);
        return $users;
    }

}
