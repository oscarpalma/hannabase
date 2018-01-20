<?php namespace App\Http\Middleware\candidatos;

use Closure;

class todos_submodulos_candidatos {

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
        	if($usuario_actual->role!="superusuario" && $usuario_actual->role!="administrador" && $usuario_actual->role!="coordinador" && $usuario_actual->role!="filtro"){
         		return view("errors/restringido");
        	}
		return $next($request);
	}

}
