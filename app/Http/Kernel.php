<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'App\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'todossubmodulosfiltro' => 'App\Http\Middleware\filtro\todos_submodulos_filtro',
		'todossubmoduloscandidatos' => 'App\Http\Middleware\candidatos\todos_submodulos_candidatos',
		'consultas' => 'App\Http\Middleware\empleados\consultas',
		'checadas' => 'App\Http\Middleware\empleados\alta_checadas',
		'buscarchecadas' => 'App\Http\Middleware\empleados\buscar_checadas',
		'altadescuentoscomedor' => 'App\Http\Middleware\empleados\alta_descuentos_comedor',
		'buscardescuentoscomedor' => 'App\Http\Middleware\empleados\buscar_descuentos_comedor',
		'generarreporte' => 'App\Http\Middleware\empleados\generar_reporte',
		'listaasistencia' => 'App\Http\Middleware\empleados\lista_asistencia',
		'todossubmoduloscrtm' => 'App\Http\Middleware\empleadosoficina\todos_submodulos_crtm',
		'generarreportecrtm' => 'App\Http\Middleware\empleadosoficina\generar_reporte_crtm',
		'todossubmodulosclientes' => 'App\Http\Middleware\clientes\todos_submodulos_clientes',
		'altakpi' => 'App\Http\Middleware\administracion\alta_kpi',
		'actualizarformato' => 'App\Http\Middleware\administracion\actualizar_formato_kpi',
		'administrarusuarios' => 'App\Http\Middleware\administracion\administrar_usuarios',
		'enviarmensaje' => 'App\Http\Middleware\administracion\enviar_mensaje',
		'directorio' => 'App\Http\Middleware\administracion\directorio',
		'todossubmodulosproveedores' => 'App\Http\Middleware\proveedores\todos_submodulos_proveedores',
		'todossubmodulosnomina' => 'App\Http\Middleware\nomina\todos_submodulos_nomina',
		'todossubmodulosinventario' => 'App\Http\Middleware\inventario\todos_submodulos_inventario',
		'sinPrivilegio' => 'App\Http\Middleware\sinRol',
		'coordinador' => 'App\Http\Middleware\coordinador',
		'contabilidad' => 'App\Http\Middleware\contabilidad',
		'filtro' => 'App\Http\Middleware\filtro',
		'recepcion' => 'App\Http\Middleware\recepcion',
	];

}