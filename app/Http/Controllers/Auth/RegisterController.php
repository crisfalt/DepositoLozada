<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\TipoDocumento;
use App\Perfil;
use App\Bodega;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/auth/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'number_id' => 'required|max:30',
            'tipo_documento_id' => 'required',
            'address' => 'required|max:150',
            'phone' => 'numeric|between:0,99999999999999999999',
            'celular' => 'numeric|between:0,99999999999999999999',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'perfil_id' => 'required',
            'bodega_id' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd( $data['name']);
        return User::create([
            'name' => $data['name'],
            'tipo_documento_id' => $data['tipo_documento_id'],
            'number_id' => $data['number_id'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'celular' => $data['celular'],
            'email' => $data['email'],
            'perfil_id' => $data['perfil_id'],
            'bodega_id' => $data['bodega_id'],
            'password' => bcrypt($data['password']),//encriptar passwrod
        ]);
    }

    public function index() {
        $empleados = User::where('estado','A')->get();
        return view('auth.index') -> with( compact('empleados') );
    }

    public function destroy( $id ) {
        $empleado = User::find( $id );
        $empleado->estado = 'I'; //ELIMINAR
        $empleado->save();
        $notification = 'Empleado ' . $empleado -> name . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

    //sobreescribir metodo de RegisterUsers
    public function showRegistrationForm()
    {
        $tiposDocumento = TipoDocumento::orderBy('nombre')->get();
        $perfiles = Perfil::orderBy('nombre')->get();
        $bodegas = Bodega::orderBy('nombre')->get();
        return view('auth.register') -> with( compact('tiposDocumento','perfiles','bodegas') );
    }

    //sobreescribir metodo register de clase RegistersUsers
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        return $this->registered($request, $user);
    }

    //metodo que se sobreescribe para redireccionar despues de crear un usuario
    protected function registered(Request $request, $user)
    {
        $empleados = User::where('estado','A')->get();
        return view('auth.index')-> with( compact('empleados') );
    }

}
