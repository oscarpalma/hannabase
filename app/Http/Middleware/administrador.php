<?php namespace App\Http\Middleware;

use Closure;

class administrador {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$usuario_actual=\Auth::user();
        	if($usuario_actual->role!="administrador"){
         		return view("errors/restringido");
        	}
		return $next($request);
	}

}
