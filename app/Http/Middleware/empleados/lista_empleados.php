<?php namespace App\Http\Middleware\empleados;

use Closure;

class lista_empleados {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	##no utilizado debido a que todos tienen acceso
	public function handle($request, Closure $next)
	{
		$usuario_actual=\Auth::user();
        	if($usuario_actual->role!="superusuario" && $usuario_actual->role!="coordinador" && $usuario_actual->role!="recepcion" && $usuario_actual->role!="filtro"){
         		return view("errors/restringido");
        	}
		return $next($request);
	}

}
