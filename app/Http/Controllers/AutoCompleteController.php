<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Zona;
use App\Ruta;

class AutoCompleteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        $zonas = Zona::where('estado' , 'A')->get();
        return view('autocomplete.search_vendedor')->with( compact('zonas') );
    }

    public function autoComplete(Request $request) {
        $query = $request->get('term','');
        $vendedores=User::where('name','LIKE','%'.$query.'%')->orWhere('number_id','LIKE','%'.$query.'%')->where('perfil_id','=','2')->get();//autocompletar para vendedore
        $data=array();
        foreach ($vendedores as $vendedor) {
            $data[]=array('value'=>$vendedor->name,'id'=>$vendedor->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron resultados','id'=>''];
    }

}
