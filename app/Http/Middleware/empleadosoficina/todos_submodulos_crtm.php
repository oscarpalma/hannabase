<?php namespace App\Http\Middleware\empleadosoficina;

use Closure;

class todos_submodulos_crtm {

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
        	if($usuario_actual->role!="superusuario" && $usuario_actual->role!="administrador" && $usuario_actual->role!="gerente"){
         		return view("errors/restringido");
        	}
		return $next($request);
	}

}
