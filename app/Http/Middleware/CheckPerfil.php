<?php

namespace App\Http\Middleware;

use Closure;

class CheckPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perfil)
    {
        try{
            if ($request->user()->tipo==$perfil){
                return $next($request);
            }else{
                abort(403, 'No tienes autorización para ingresar.');
            }

        }catch(\Exception $e){
            abort(403, 'No tienes autorización para ingresar.');
        }
    }
}
