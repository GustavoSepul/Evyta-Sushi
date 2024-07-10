<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

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
    //protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = '/portal';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
      protected $redirectTo = '/';


    public function authenticated($request , $user){
        if($user->hasRole('administrador')){
            return redirect()->route('administrador') ;
        }else if($user->hasRole('cliente')){
            return redirect()->route('index');
        }else if($user->hasRole('repartidor')){
            return redirect()->route('pedidos');
        }else if($user->hasRole('vendedor')){
            return redirect()->route('catalogo');
        }
    }
}