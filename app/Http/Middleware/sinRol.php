<?php namespace App\Http\Middleware;

use Closure;

class sinRol {

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
        	if($usuario_actual->role=="noAsignado"){
         		return view("errors/noAsignado");
        	}
		return $next($request);
	}

}
