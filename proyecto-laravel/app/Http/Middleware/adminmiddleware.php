<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user->hasRole('cliente')){
            return redirect('/')->with('Error', 'No tienes los permisos necesarios para acceder ahi.');
        }

        return $next($request);
    }
}
