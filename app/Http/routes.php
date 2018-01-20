<?php
use App\Modelos\Cliente;
use App\Modelos\Turno;
use App\Modelos\Empleado;
use App\Modelos\Notificacion;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/





#Route::controllers([
#	'auth' => 'Auth\AuthController',
#	'password' => 'Auth\PasswordController',
#]);

#### AUTENTIFICACION ####

Route::get('auth/login',
	['uses' => 'Auth\AuthController@getLogin',
	'as'    => 'login']);

Route::post('auth/login', 
	['as' =>'login', 
	'uses' => 'Auth\AuthController@postLogin']);

Route::get('auth/logout', 
	['as' => 'logout', 
	'uses' => 'Auth\AuthController@getLogout']);
 
// Registration routes...
Route::get('auth/register', [
	'uses' => 'Auth\AuthController@getRegister',
	'as'   => 'registro']
	);
Route::post('auth/register', 
	['as' => 'registro', 
	'uses' => 'Auth\AuthController@postRegister']);

Route::get('password/email', [
	'uses' => 'Auth\PasswordController@getReset',
	'as'   => 'restaurar_password'
	]);
 
 // Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
//Se verifica si el usuario aun no tiene un privilegio para evitar que accese
Route::group(['middleware' => ['auth','sinPrivilegio']], function () {

Route::get('/', 'WelcomeController@index');


#### Candidatos ####
Route::group(['middleware' => 'todossubmoduloscandidatos'], function () {
Route::get('candidatos/alta',
 ['as' => 'registro_candidato', 
 'uses' => 'CandidatoController@alta_get']);

Route::post('candidatos/alta',
	['as'   => 'registro_candidato',
	'uses' => 'CandidatoController@alta_post']);

Route::get('candidatos/lista',
 ['as' => 'lista_candidatos', 
 'uses' => 'CandidatoController@lista_get']);

Route::get('candidatos/editar/{id}',
 ['as' => 'editar_candidato', 
 'uses' => 'CandidatoController@editar_get']);

Route::post('candidatos/editar/{id}',
 ['as' => 'editar_candidato',
 'uses' => 'CandidatoController@editar_post']);

Route::post('candidatos/enviar/lista-negra',
 ['as' => 'enviar_lista_negra', 
 'uses' => 'CandidatoController@enviar_lista_negra']);

Route::get('candidatos/no-contratable',
 ['as' => 'lista_negra', 
 'uses' => 'CandidatoController@lista_negra_get']);

Route::post('candidatos/baja',
 ['as' => 'baja', 
 'uses' => 'CandidatoController@baja']);

Route::post('candidatos/convertir',
 ['as' => 'convertir', 
 'uses' => 'CandidatoController@convertir']);

Route::post('candidatos/datos',
 ['as' => 'datos', 
 'uses' => 'CandidatoController@datos']);

});

#### Empleados Indirectos ####
	## Todos los roles tienen acceso ##
	Route::get('empleados/lista',
	 ['as' => 'lista_empleados', 
	 'uses' => 'EmpleadoController@lista_get']);

	Route::get('empleados/editar/{id}',
	 ['as' => 'editar_empleado', 
	 'uses' => 'EmpleadoController@editar_get']);

	Route::post('empleados/editar/{id}',
	 ['as' => 'editar_empleado', 
	 'uses' => 'EmpleadoController@editar_post']);

	Route::post('empleados/limpiar',
	 ['as' => 'limpiar_empleados', 
	 'uses' => 'EmpleadoController@limpiar_post_ajax']);

Route::group(['middleware' => 'consultas'], function () {
	

	Route::get('empleados/consultas', [
		'uses' => 'EmpleadoController@buscar',
		'as'   => 'consultas_empleados'
		]);

	Route::post('empleados/consultas', [
		'uses' => 'EmpleadoController@resultados',
		'as'   => 'consultas_empleados'
		]);

	# Busquedas rapidas #
	Route::get('empleados/sin_cuenta', 'EmpleadoController@sinCuenta');
	Route::get('empleados/incompletos' , 'EmpleadoController@incompletos');
	Route::get('empleados/cumple', 'EmpleadoController@cumple');

});

Route::group(['middleware' => 'checadas'], function () {

	Route::get('empleados/checada/individual',
	 ['as' => 'get_checada_empleados', 
	 'uses' => 'EmpleadoController@checada_get']);

	Route::post('empleados/checada/individual',
	 ['as' => 'post_checada_empleados', 
	 'uses' => 'EmpleadoController@checada_post_ajax']);

	Route::get('empleados/checada/grupal',
	 ['as' => 'get_checadaG_empleados', 
	 'uses' => 'EmpleadoController@checadaG_get']);

	Route::post('empleados/checada/grupal',
	 ['as' => 'post_checadaG_empleados', 
	 'uses' => 'EmpleadoController@checadaG_post_ajax']);

	
});


Route::group(['middleware' => 'generarreporte'], function () {

	Route::get('empleados/reporte',
	 ['as' => 'reporte_checadas', 
	 'uses' => 'EmpleadoController@reporte_get']);

	Route::post('empleados/reporte',
	 ['as' => 'reporte_checadas', 
	 'uses' => 'EmpleadoController@reporte_post']);

});

Route::group(['middleware' => 'buscarchecadas'], function () {	

	Route::get('empleados/checadas', [
		'uses' => 'EmpleadoController@buscar_checadas_get',
		'as'   => 'buscar_checadas'
		]);

	Route::post('empleados/checadas', [
		'uses' => 'EmpleadoController@buscar_checadas_post',
		'as'   => 'buscar_checadas'
		]);

	Route::post('empleados/baja_checadas',
	 ['as' => 'baja_checadas', 
	 'uses' => 'EmpleadoController@baja_checadas_ajax']);

});

Route::group(['middleware' => 'altadescuentoscomedor'], function () {

	Route::get('empleados/comedores/alta', [
		'uses' => 'EmpleadoController@comedores_get',
		'as'   => 'comedores'
		]);
	Route::post('empleados/comedores/alta', [
		'uses' => 'EmpleadoController@comedores_post',
		'as'   => 'comedores'
		]);

});

Route::group(['middleware' => 'buscardescuentoscomedor'], function () {

	Route::get('empleados/comedores/buscar', [
		'uses' => 'EmpleadoController@buscar_comedores_get',
		'as'   => 'buscar_comedores'
		]);
	Route::post('empleados/comedores/buscar', [
		'uses' => 'EmpleadoController@buscar_comedores_post',
		'as'   => 'buscar_comedores'
		]);
	Route::post('empleados/comedores/eliminar', [
		'uses' => 'EmpleadoController@eliminar_comedores_post',
		'as'   => 'eliminar_comedores'
		]);

	##Cambiar privilegios##

	Route::get('lista-asistencia', [
	'uses' => 'EmpleadoController@listaAsistencia',
	'as'   => 'lista_asistencia'
	]);

	Route::post('lista-asistencia', [
		'uses' => 'EmpleadoController@mostrarListaAsistencia',
		'as'   => 'lista_asistencia'
		]);

});

## Funcionan para mas de un módulo
	Route::get('empleados/verificar',
	 ['as' => 'verificar', 
	 'uses' => 'EmpleadoController@verificar_ajax']);

	Route::get('empleados/turnos',
	 ['as' => 'turnos', 
	 'uses' => 'EmpleadoController@turnos']);

	//para actualizar las horas de entrada al actualizar la empresa 
Route:: get('/ajax-cliente-turno',function(){
	$idCliente = Input::get('idCliente');
	//hay que revertir el orden, pues el jquery funciona con un foreach y el valor que muestra en el textbox es el ultimo
	$horas = Turno::where('idCliente','=',$idCliente)->orderBy('idTurno','desc')->get();

	return Response::json($horas);
});

## Revisar ##
Route:: get('/ajax-turno',function(){
	$idTurno = Input::get('idTurno');
	$horas = Turno::where('idTurno','=',$idTurno)->orderBy('hora_entrada','asc')->get();
	
	return Response::json($horas);
});
Route::post('/ajax-turno', [
		'uses' => 'EmpleadoController@turnos',
		'as'   => 'obtener_turnos'
		]);



Route:: get('/ajax-cliente',function(){
	$idCliente = Input::get('idCliente');
	$turnos = Turno::where('idCliente','=',$idCliente)->get();

	return Response::json($turnos);
});

##Filtro##
Route::group(['middleware' => 'todossubmodulosfiltro'], function () {

	Route::get('filtro/verificacion',
	 ['as' => 'filtro_verificacion', 
	 'uses' => 'FiltroController@verificar_get']);

	Route::post('filtro/verificacion', [
		'uses' => 'FiltroController@verificar_post',
		'as'   => 'filtro_verificacion'
		]);

	Route::get('filtro/credencial',
	 ['as' => 'filtro_credencial', 
	 'uses' => 'FiltroController@credencial_get']);

	Route::post('filtro/credencial', [
		'uses' => 'FiltroController@credencial_post',
		'as'   => 'filtro_credencial'
		]);

	Route::get('filtro/detalle_credencial/{noempleado}', [
		'uses' => 'FiltroController@detalleCredencial',
		'as'   => 'filtro_nuevaCredencial'
		]);

	Route::get('filtro/descuento', [
		'uses' => 'FiltroController@descuento_get',
		'as'   => 'descuento_empleado'
		]);
	Route::post('filtro/descuento', [
		'uses' => 'FiltroController@descuento_post',
		'as'   => 'descuento_empleado'
		]);

	Route::get('filtro/reembolso', [
		'uses' => 'FiltroController@reembolso_get',
		'as'   => 'reembolso_empleado'
		]);
	Route::post('filtro/reembolso', [
		'uses' => 'FiltroController@reembolso_post',
		'as'   => 'reembolso_empleado'
		]);

	Route::get('filtro/tomar-foto', [
		'uses' => 'FiltroController@tomarFoto_get',
		'as'   => 'tomar_foto_empleado'
		]);
	Route::post('filtro/tomar-foto', [
		'uses' => 'FiltroController@tomarFoto_post',
		'as'   => 'tomar_foto_empleado'
		]);


	Route::get('filtro/subir-foto', [
		'uses' => 'FiltroController@subirFoto_get',
		'as'   => 'subir_foto_empleado'
		]);
	Route::post('filtro/subir-foto', [
		'uses' => 'FiltroController@subirFoto_post',
		'as'   => 'subir_foto_empleado'
		]);

	Route::get('filtro/lista/descuentos',[
		'as' => 'lista_descuentos',
		'uses' => 'FiltroController@lista_descuentos_get'
		]);

	Route::post('filtro/lista/descuentos',[
		'as' => 'lista_descuentos',
		'uses' => 'FiltroController@lista_descuentos_post'
		]);

	Route::post('filtro/baja/descuento/', [
		'uses' => 'FiltroController@eliminar_descuento_ajax',
		'as'   => 'eliminar_descuento'
		]);
});







##Rutas para empleados de oficina##

Route::group(['middleware' => 'todossubmoduloscrtm'], function () {

	Route::get('empleados/crtm/alta', [
		'uses' => 'EmpleadoCrtmController@alta_get',
		'as'   => 'registro_empleado_crtm'
		]);

	Route::post('empleados/crtm/alta', [
		'uses' => 'EmpleadoCrtmController@alta_post',
		'as'   => 'registro_empleado_crtm'
		]);

	Route::get('empleados/crtm/lista', [
		'uses' => 'EmpleadoCrtmController@lista_get',
		'as'   => 'lista_empleados_crtm'
		]);

	Route::post('empleados/crtm/datos',
	 ['as' => 'empleados_crtm_datos', 
	 'uses' => 'EmpleadoCrtmController@datos_ajax']);

	Route::post('empleados/crtm/baja',
	 ['as' => 'empleados_crtm_baja', 
	 'uses' => 'EmpleadoCrtmController@baja_ajax']);

	Route::get('empleados/crtm/editar/{id}',
	 ['as' => 'empleado_crtm_editar', 
	 'uses' => 'EmpleadoCrtmController@editar_empleado_get']);

	Route::post('empleados/crtm/editar/{id}',
	 ['as' => 'empleado_crtm_editar', 
	 'uses' => 'EmpleadoCrtmController@editar_empleado_post']);


	Route::get('empleados/crtm/checada/individual',
	 ['as' => 'checada_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@alta_checada_get']);

	Route::post('empleados/crtm/checada/individual',
	 ['as' => 'checada_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@checada_post_ajax']);

	Route::get('empleados/crtm/checada/grupal',
	 ['as' => 'checadaG_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@alta_checadaG_get']);

	Route::post('empleados/crtm/checada/grupal',
	 ['as' => 'checadaG_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@checadaG_post_ajax']);

	Route::get('empleados/crtm/verificar',
	 ['as' => 'verificar_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@verificar_ajax']);


	Route::get('empleados/crtm/buscar-checadas',
	 ['as' => 'buscarC_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@buscar_checadas_get']);

	Route::post('empleados/crtm/buscar-checadas',
	 ['as' => 'buscarC_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@buscar_checadas_post']);

	Route::post('empleados/crtm/baja_checadas',
	 ['as' => 'baja_checadas_crtm', 
	 'uses' => 'EmpleadoCrtmController@baja_checadas_ajax']);

	Route::get('empleados/crtm/descuento',
	 ['as' => 'descuento_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@descuento_get']);

	Route::post('empleados/crtm/descuento',
	 ['as' => 'descuento_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@descuento_post']);

	Route::get('empleados/crtm/prestamo',
	 ['as' => 'prestamo_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@prestamo_get']);

	Route::post('empleados/crtm/prestamo',
	 ['as' => 'prestamo_empleados_crtm', 
	 'uses' => 'EmpleadoCrtmController@prestamo_post']);

	Route::get('empleados/crtm/subir-foto', [
		'uses' => 'EmpleadoCrtmController@subirFoto_get',
		'as'   => 'subir_foto_empleados_crtm'
		]);

	Route::post('empleados/crtm/subir-foto', [
		'uses' => 'EmpleadoCrtmController@subirFoto_post',
		'as'   => 'subir_foto_empleados_crtm'
		]);

	## Consultas ##
	Route::get('empleados/crtm/consultas', [
		'uses' => 'EmpleadoCrtmController@buscar',
		'as'   => 'consultas_empleados_crtm'
		]);
	
	Route::post('empleados/crtm/consultas', [
		'uses' => 'EmpleadoCrtmController@resultados',
		'as'   => 'consultas_empleados_crtm'
		]);

	# Busquedas rapidas #
	Route::get('empleados/crtm/sin_cuenta', 'EmpleadoCrtmController@sinCuenta');
	Route::get('empleados/crtm/incompletos' , 'EmpleadoCrtmController@incompletos');
	Route::get('empleados/crtm/cumple', 'EmpleadoCrtmController@cumple');

});


Route::group(['middleware' => 'generarreportecrtm'], function () {
		
		Route::get('empleados/crtm/reporte',
		 ['as' => 'reporte_empleados_crtm', 
		 'uses' => 'EmpleadoCrtmController@reporte_get']);

		Route::post('empleados/crtm/reporte',
		 ['as' => 'reporte_empleados_crtm', 
		 'uses' => 'EmpleadoCrtmController@reporte_post']);
});

##Clientes##
Route::group(['middleware' => 'todossubmodulosclientes'], function () {

	Route::get('clientes/alta',
	 ['as' => 'alta_cliente', 
	 'uses' => 'ClienteController@alta_get']);
	Route::post('clientes/alta',
	 ['as' => 'alta_cliente', 
	 'uses' => 'ClienteController@alta_post']);

	Route::get('clientes/lista',
	 ['as' => 'lista_cliente', 
	 'uses' => 'ClienteController@lista_get']);

	Route::post('clientes/baja',
	 ['as' => 'baja_cliente', 
	 'uses' => 'ClienteController@baja_post_ajax']);

	Route::get('clientes/turnos',
	 ['as' => 'turnos_cliente', 
	 'uses' => 'ClienteController@turnos_get_ajax']);
	Route::post('clientes/turnos',
	 ['as' => 'turnos_cliente', 
	 'uses' => 'ClienteController@turnos_post_ajax']);

});

## Administracion ##
Route::group(['middleware' => 'administrarusuarios'], function () {
	
	Route::get('usuarios/lista',
	 ['as' => 'lista_usuarios', 
	 'uses' => 'UsuarioController@lista_get']);

	Route::post('usuarios/baja',
	 ['as' => 'baja_usuarios', 
	 'uses' => 'UsuarioController@baja_post_ajax']);

	Route::post('usuarios/privilegio',
	 ['as' => 'privilegio_usuarios', 
	 'uses' => 'UsuarioController@privilegio_post_ajax']);

});


	### rutas para KPI ###
Route::group(['middleware' => 'altakpi'], function () {

	//Rutas para el registro de KPI por semana
	Route::get('kpi/alta/registro', [
		'uses' => 'KpiController@registro_kpi_get',
		'as'   => 'kpi_alta_registro'
		]);
	Route::post('kpi/alta/registro', [
		'uses' => 'KpiController@registro_kpi_ajax',
		'as'   => 'kpi_alta_registro'
		]);

	//Rutas para el registro de KPI por semana
	Route::get('rh/editar', [
		'uses' => 'RHController@registro_requerimiento_get',
		'as'   => 'rh_editar'
		]);

});

Route::group(['middleware' => 'actualizarformato'], function () {

	//Rutas para la actualización del formato general.
	Route::get('kpi/actualizar/formato', [
		'uses' => 'KpiController@actualizar_formato_get',
		'as'   => 'kpi_actualizar_formato'
		]);
	Route::post('kpi/actualizar/formato', [
		'uses' => 'KpiController@actualizar_formato_ajax',
		'as'   => 'kpi_actualizar_formato'
		]);

});

	//Ruta para realizar la busqueda del formato general o formato por semana
	//Utilizando AJAX
	Route::get('kpi/obtener_tabla_ajax', [
		'uses' => 'KpiController@obtener_tabla_ajax',
		'as'   => 'kpi_obtener_tabla'
		]);

Route::group(['middleware' => 'directorio'], function () {

	Route::get('directorio/personal', [
		'uses' => 'EmpleadoCrtmController@directorio_get',
		'as'   => 'directorio_empleados_crtm'
		]);

});

Route::group(['middleware' => 'enviarmensaje'], function () {

	Route::get('administracion/enviar-mensaje', [
		'uses' => 'MensajeController@index',
		'as'   => 'mensaje'
		]);

	Route::post('administracion/enviar-mensaje', [
		'uses' => 'MensajeController@create',
		'as'   => 'mensaje'
		]);

});


	## Disponible para todos los roles ##
	Route::get('ver-mensaje-{id}', [
		'uses' => 'MensajeController@ver',
		'as'   => 'ver_mensaje'
		]);

	Route::get('ver-mensajes', [
		'uses' => 'MensajeController@verTodos',
		'as'   => 'ver_mensajes'
		]);



	Route:: get('/ajax-notificacion',function(){
		
		$notificacion = Notificacion::where('destinatario','=',Auth::user()->id)->orderBy('fecha', 'desc')->get();
		$cantidad = Notificacion::where('visto','=','0')->where('destinatario','=',Auth::user()->id)->get()->count();
		return Response::json(['notificacion' => $notificacion,'cantidad' => $cantidad]);
	});

	Route:: get('/ajax-visto',function(){
		
		Notificacion::where('destinatario', Auth::user()->id)->update(array('visto'=> 1));
		$cantidad = Notificacion::where('visto','=','0')->where('destinatario','=',Auth::user()->id)->get()->count();
		return Response::json(['cantidad' => $cantidad]);
	});

	Route::get('ajax-empleadosActivos', function(){
		$empleados = Empleado::where('estado','empleado')->where('contratable',true)->get()->count();
		return Response::json(['empleados' => $empleados]);
	});

/*
Route::get('usuarios/password',
 ['as' => 'password_usuarios', 
 'uses' => 'UsuarioController@password_post_ajax']);*/


##  Rutas sin modificaciones ##

#### PROVEEDORES #####
Route::group(['middleware' => 'todossubmodulosproveedores'], function () {

	Route::get('proveedores/nuevo', [
		'uses' => 'ProveedorController@index',
		'as'   => 'nuevo_proveedor'
		]);

	Route::post('proveedores/nuevo', [
		'uses' => 'ProveedorController@create',
		'as'   => 'nuevo_proveedor'
		]);

	Route::get('provedores/transaccion', [
		'uses' => 'ProveedorController@transaccion',
		'as'   => 'proveedores_transaccion'
		]);

	Route::post('provedores/transaccion', [
		'uses' => 'ProveedorController@guardarTransaccion',
		'as'   => 'proveedores_transaccion'
		]);

	Route::get('proveedores/lista', [
		'uses' => 'ProveedorController@listaProveedores',
		'as'   => 'lista_proveedores'
		]);

	Route::get('proveedores/editar-{id}', [
		'uses' => 'ProveedorController@editar',
		'as'   => 'editar_proveedor'
		]);

	Route::post('proveedores/editar-{id}', [
		'uses' => 'ProveedorController@actualizarProveedor',
		'as'   => 'editar_proveedor'
		]);

	Route::get('proveedores/eliminar-{id}', [
		'uses' => 'ProveedorController@eliminar',
		'as'   => 'eliminar_proveedor'
		]);

	Route::post('proveedores/eliminar-{id}', [
		'uses' => 'ProveedorController@destroy',
		'as'   => 'eliminar_proveedor'
		]);

	Route::get('proveedores/transacciones', [
		'uses' => 'ProveedorController@buscar',
		'as'   => 'transacciones'
		]);

	Route::post('proveedores/transacciones', [
		'uses' => 'ProveedorController@mostrar',
		'as'   => 'transacciones'
		]);

	Route::get('proveedores/celiminar-transaccion-{id}', [
		'uses' => 'ProveedorController@borrarTransaccion',
		'as'   => 'celiminar_transaccion'
		]);

	Route::post('proveedores/celiminar-transaccion-{id}', [
		'uses' => 'ProveedorController@eliminarTransaccion',
		'as'   => 'celiminar_transaccion'
		]);



	Route::get('proveedores/reporte', [
		'uses' => 'ProveedorController@buscarReporte',
		'as'   => 'proveedores/reporte'
		]);

	Route::post('proveedores/reporte', [
		'uses' => 'ProveedorController@generarReporte',
		'as'   => 'proveedores/reporte'
		]);

	Route::get('proveedores/detalle/reporte', [
		'uses' => 'ProveedorController@detalleReporte',
		'as'   => 'proveedores/imprimir_reporte' //cambie el nombre de la ruta
		]);

	Route::get('proveedores/editar_transaccion-{id}', [
		'uses' => 'ProveedorController@editarT',
		'as'   => 'proveedores/editar-transaccion'
		]);

	Route::post('proveedores/guardar-cambios-{id}', [
		'uses' => 'ProveedorController@guardarCambios',
		'as'   => 'proveedores/guardar-cambios' //cambie el nombre de la ruta
		]);

	Route::get('proveedores/subirTransaccion', [
		'uses' => 'ProveedorController@subirArchivo',
		'as'   => 'proveedores/subirTransaccion'
		]);

	Route::post('proveedores/subirTransaccion', [
		'uses' => 'ProveedorController@subirTransacciones',
		'as'   => 'proveedores/subirTransaccion' //cambie el nombre de la ruta
		]);

############################ Rutas para cambiar Saldo a Abono ##########################################
	Route::post('proveedores/mostrar_saldos-$transaccion-{id}',[
		'uses' => 'ProveedorController@ConvertirSaldo',
		'as' => 'convertirsaldo'
		]);

	Route::get('proveedores/mostrar_saldos-transaccion-{id}',[
		'uses' => 'ProveedorController@MostrarSaldo',
		'as' => 'mostrarsaldo'
		]);
#########################################################################################################

});

#### rutas para nomina####

Route::group(['middleware' => 'todossubmodulosnomina'], function () {

	Route::get('nomina/exportar', [
		'uses' => 'NominaController@exportar',
		'as' => 'exportar_nomina'
		]);

	Route::post('nomina/exportar', [
		'uses' => 'NominaController@datosNomina',
		'as' => 'exportar_nomina']);

	Route::get('nomina/indicadores', [
		'uses' => 'NominaController@buscarContadores',
		'as'   => 'indicadores'
		]);

	Route::post('nomina/indicadores', [
		'uses' => 'NominaController@mostrarContadores',
		'as'   => 'indicadores'
		]);

});

#### Inventario ####

Route::group(['middleware' => 'todossubmodulosinventario'], function () {

	Route::get('inventario/alta',[
		'uses' => 'MaterialController@alta_get',
		'as'   => 'inventario_alta'
		]);

	Route::post('inventario/alta',[
		'uses' => 'MaterialController@alta_post',
		'as'   => 'inventario_alta'
	]);

	Route::get('inventario/administrar',[
		'uses' => 'MaterialController@administrar_get',
		'as'   => 'inventario_administrar'
		]);
	Route::post('inventario/administrar',[
		'uses' => 'MaterialController@administrar_post',
		'as'   => 'inventario_administrar'
		]);

	Route::get('inventario/cantidad',[
		'uses' => 'MaterialController@cantidad_get',
		'as'   => 'inventario_cantidad'
		]);

	Route::post('inventario/cantidad',[
		'uses' => 'MaterialController@cantidad_post',
		'as'   => 'inventario_cantidad'
		]);

	Route::get('inventario/lista', [
		'uses' => 'MaterialController@mostrarInventario_get',
		'as'   => 'inventario_lista'
		]);

	Route::post('inventario/lista', [
		'uses' => 'MaterialController@mostrarInventario_post',
		'as'   => 'inventario_lista'
		]);

	Route::get('inventario/eliminar-{id}', [
		'uses' => 'MaterialController@eliminar',
		'as'   => 'eliminar_inventario'
		]);

	Route::post('inventario/eliminar-{id}', [
		'uses' => 'MaterialController@destroy',
		'as'   => 'eliminar_inventario'
		]);

	Route::post('inventario/actualizar', [
		'uses' => 'MaterialController@actualizar_post',
		'as'   => 'actualizar_inventario'
		]);

	Route::get('crear_reporte_inventario/{tipo}', 'MaterialController@crear_reporte_inventario');

});


Route::group(['middleware' => 'todossubmoduloscandidatos'], function () {
	Route::get('empleados_proyecto/alta', [
		'uses' => 'EmpleadoProyectoController@alta_empleado_get',
		'as'   => 'alta_empleado_proyecto'
		]);

	Route::post('empleados_proyecto/alta', [
		'uses' => 'EmpleadoProyectoController@alta_empleado_post',
		'as'   => 'alta_empleado_proyecto'
		]);

	Route::get('empleados_proyecto/lista', [
		'uses' => 'EmpleadoProyectoController@lista_empleados_get',
		'as'   => 'lista_empleados_proyecto_get'
		]);

	Route::get('empleados_proyecto/editar/{id}', [
		'uses' => 'EmpleadoProyectoController@editar_empleado_get',
		'as'   => 'editar_empleado_proyecto'
		]);

	Route::post('empleados_proyecto/editar/{id}', [
		'uses' => 'EmpleadoProyectoController@editar_empleado_post',
		'as'   => 'editar_empleado_proyecto'
		]);

	Route::post('empleados_proyecto/ajax/ver_datos', [
		'uses' => 'EmpleadoProyectoController@ver_datos_ajax',
		'as'   => 'ver_datos_ajax'
		]);

	Route::post('empleados_proyecto/ajax/eliminar_empleado', [
		'uses' => 'EmpleadoProyectoController@eliminar_empleado_ajax',
		
		]);

});

Route::group(['middleware' => 'checadas'], function () {
	Route::get('empleados_proyecto/checada/alta', [
		'uses' => 'EmpleadoProyectoController@alta_checada_get',
		'as'   => 'alta_checada_proyecto'
		]);

	Route::post('empleados_proyecto/checada/alta', [
		'uses' => 'EmpleadoProyectoController@alta_checada_post',
		'as'   => 'alta_checada_proyecto'
		]);
});
	Route::get('empleados_proyecto/ajax/turnos',
	 ['as' => 'turnos', 
	 'uses' => 'EmpleadoProyectoController@turnos_ajax']);

Route::group(['middleware' => 'buscarchecadas'], function () {	
	Route::get('empleados_proyecto/checada/buscar', [
		'uses' => 'EmpleadoProyectoController@buscar_checadas_get',
		'as'   => 'buscar_checadas_proyecto'
		]);

	Route::post('empleados_proyecto/checada/buscar', [
		'uses' => 'EmpleadoProyectoController@buscar_checadas_post',
		'as'   => 'buscar_checadas_proyecto'
		]);

	Route::post('empleados_proyecto/ajax/eliminar_checada', [
		'uses' => 'EmpleadoProyectoController@eliminar_checadas_ajax',
		
		]);
});

Route::group(['middleware' => 'generarreporte'], function () {
	Route::get('empleados_proyecto/checada/reporte', [
		'uses' => 'EmpleadoProyectoController@generar_reporte_get',
		'as'   => 'generar_reporte_proyecto'
		]);

	Route::post('empleados_proyecto/checada/reporte', [
		'uses' => 'EmpleadoProyectoController@generar_reporte_post',
		'as'   => 'generar_reporte_proyecto'
		]);

});

##Clientes Proyectos##
Route::group(['middleware' => 'todossubmodulosclientes'], function () {

	Route::get('clientes_proyecto/alta',
	 ['as' => 'alta_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@alta_get']);
	Route::post('clientes_proyecto/alta',
	 ['as' => 'alta_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@alta_post']);

	Route::get('clientes_proyecto/lista',
	 ['as' => 'lista_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@lista_get']);

	Route::post('clientes_proyecto/baja',
	 ['as' => 'baja_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@baja_post_ajax']);

	Route::get('clientes_proyecto/turnos',
	 ['as' => 'turnos_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@turnos_get_ajax']);
	Route::post('clientes_proyecto/turnos',
	 ['as' => 'turnos_cliente_proyecto', 
	 'uses' => 'ClienteProyectoController@turnos_post_ajax']);

});

});