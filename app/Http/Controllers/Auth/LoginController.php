<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        if( Auth::user() -> perfil_id == 1 ) {
         $this->redirectTo = '/home';
        }
        if( Auth::user() -> perfil_id == 2 ) {
            $this->redirectTo = '/vendedor/ruta/'.Auth::user()->id.'/rutas_por_vendedor';
        }
        if( Auth::user() -> perfil_id == 4 ) {
            $this->redirectTo = '/caja';
        }
        if (session()->has('redirect_to'))
            return session()->pull('redirect_to');

        return $this->redirectTo;
    }
    
    

}
