<?php
use App\Turno;
use App\Notificacion;
use App\Empleado;
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

Route::get('/', [
	'uses' => 'HomeController@index',
	'as'   => 'home'
	]);


#### AUTENTIFICACION/USUARIOS ####

Route::get('auth/login',
	['uses' => 'Auth\AuthController@getLogin',
	'as'    => 'login']);

Route::post('auth/login', 
	['as' =>'login', 
	'uses' => 'Auth\AuthController@postLogin']);

Route::get('auth/logout', 
	['as' => 'logout', 
	'uses' => 'Auth\AuthController@getLogout']);

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

// Registration routes...
Route::get('auth/register', [
	'uses' => 'Auth\AuthController@getRegister',
	'as'   => 'registro']
	);
Route::post('auth/register', 
	['as' => 'registro', 
	'uses' => 'Auth\AuthController@postRegister']);

Route::get('usuario', [
	'uses' => 'UserController@index',
	'as'   => 'usuario'
	]);

Route::post('usuario', [
	'uses' => 'UserController@update',
	'as'   => 'usuario'
	]);

Route::get('usuarios', [
	'uses' => 'UserController@lista',
	'as'   => 'lista_usuarios'
	]);

Route::get('eliminar-usuario-{id}',[
	'uses' => 'UserController@destroy',
	'as'   => 'eliminar_usuario'
	]);

Route::get('cambiar-usuario-{id}', [
	'uses' => 'UserController@cambiarPrivilegios',
	'as'   => 'cambiar_privilegios'
	]);

Route::post('cambiar-usuario-{id}', [
	'uses' => 'UserController@modificar',
	'as'   => 'cambiar_privilegios'
	]);


### Cotizaciones y Autorizaciones ###

Route::get('autorizaciones/cotizaciones', [
	'uses' => 'AutorizacionController@HacerCotizacion', 
	'as' => 'cotizacion'
	]);

Route::post('autorizaciones/cotizaciones', [
	'uses' => 'AutorizacionController@guardarCotizacion',
	'as' => 'cotizacion'
	]);


## Esta ruta fue exenta del codigo ya que la ruta guardarCotizacion
##cumple con la funcion de guardado y envio del formulario al correo

/*Route::post('autorizaciones/cotizaciones', [
	'uses' => 'AutorizacionController@enviarMensaje',
	'as' => 'enviarcotizaciones'
	]);*/


Route::get('autorizaciones/lista_cotizaciones', [
	'uses' => 'AutorizacionController@listaCotizaciones',
	'as' => 'listado_cotizaciones'
	]);

Route::get('autorizaciones/cotizacion_aprobar-{idCotizacion}', [
	'uses' => 'AutorizacionController@aprobarCotizacion',
	'as' => 'aprobarcotizacion'
	]);

Route::post('autorizaciones/autorizaciones', [
	'uses' => 'AutorizacionController@guardarAutorizacion',
	'as' => 'autorizacionguardar'
	]);

Route::get('autorizaciones/lista_autorizaciones', [
	'uses' => 'AutorizacionController@listaAutorizaciones',
	'as'   => 'listado_autorizaciones'
	]);

Route::get('autorizaciones/ver_autorizacion-{idAutorizacion}', [
	'uses' => 'AutorizacionController@verAutorizacion',
	'as' => 'verautorizacion'
	]);


/* Se esta validando si aun se tienen que usar estas rutas*/
##-------------------------------------------------------------
Route::get('autorizaciones/autorizaciones', [
	'uses' => 'AutorizacionController@HacerAutorizacion',
	'as' => 'autorizacion'
	]);

Route::get('PDF/invoice', [
	'uses' => 'PdfController@invoice',
	'as'   => 'invoice'
	]);
##---------------------------------------------------------------


#### Candidatos ####
Route::get('nuevo-empleado',
 ['as' => 'registro_empleado', 
 'uses' => 'EmpleadoController@index']);

Route::post('nuevo-empleado',[
	'uses' => 'EmpleadoController@create',
	'as'   => 'registro_empleado'
	]);

Route::get('convertir-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@convertirEmpleado',
	'as'   => 'convertir_empleado'
	]);

Route::post('convertir-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@promover',
	'as'   => 'convertir_empleado'
	]);

##Funciona tanto para empleados como candidatos
Route::get('ver-empleado-{idEmpleado}', [
	'uses' => 'EmpleadoController@verEmpleado',
	'as'   => 'ver_empleado'
	]);

Route::get('enviar-lista-negra-{idEmpleado}', [
	'uses' => 'EmpleadoController@confirmarListaNegra',
	'as'   => 'lista_negra_agregar'
	]);

Route::post('enviar-lista-negra-{idEmpleado}', [
	'uses' => 'EmpleadoController@agregarListaNegra',
	'as'   => 'lista_negra_agregar'
	]);
##terima controlador de lista negra

Route::get('comedores', [
	'uses' => 'ComedorController@index',
	'as'   => 'comedores'
	]);

Route::post('comedores', [
	'uses' => 'ComedorController@create',
	'as'   => 'comedores'
	]);

Route::get('comedores/buscar', [
	'uses' => 'ComedorController@buscar',
	'as'   => 'buscar_comedores'
	]);

Route::post('comedores/buscar', [
	'uses' => 'ComedorController@mostrar',
	'as'   => 'buscar_comedores'
	]);

Route::post('comedores/eliminar', [
	'uses' => 'ComedorController@destroy',
	'as'   => 'eliminar_comedores'
	]);

Route::get('buscar_descuentos', [
	'uses' => 'ComedorController@buscar',
	'as'   => 'buscar_descuentos'
	]);

Route::post('buscar_descuentos', [
	'uses' => 'ComedorController@mostrar',
	'as'   => 'buscar_descuentos'
	]);

Route::get('lista-candidatos',
 ['as' => 'mostrar_candidatos', 
 'uses' => 'EmpleadoController@mostrarCandidatos']);

Route::get('lista-negra', [
	'uses' => 'EmpleadoController@listaNegra',
	'as'   => 'lista_negra'
	]);

Route::get('modificar-candidato-{idEmpleado}',[
	'uses' => 'EmpleadoController@modificarCandidato',
	'as'   => 'modificar_candidato'
	]);

Route::post('modificar-candidato-{idEmpleado}',[
	'uses' => 'EmpleadoController@actualizarCandidato',
	'as'   => 'actualizar_candidato'
	]);

#### Empleados ####
Route::get('lista-empleados', [
	'uses' => 'EmpleadoController@mostrarEmpleados',
	'as'   => 'mostrar_empleados'
	]);

Route::get('nuevaChecada', [
	'uses' => 'AgregarChecada@index',
	'as'   => 'nuevaChecada'
	]);

Route::post('nuevaChecada', [
	'uses' => 'AgregarChecada@create',
	'as'   => 'nuevaChecada'
	]);

Route::get('nuevaChecadaGrupal', [
	'uses' => 'AgregarChecada@indexGrupal',
	'as'   => 'nuevaChecadaGrupal'
	]);

Route::post('nuevaChecadaGrupal', [
	'uses' => 'AgregarChecada@createGrupal',
	'as'   => 'nuevaChecadaGrupal'
	]);

Route::get('buscar_checadas', [
	'uses' => 'AgregarChecada@buscar',
	'as'   => 'buscar_checadas'
	]);

Route::post('buscar_checadas', [
	'uses' => 'AgregarChecada@mostrar',
	'as'   => 'buscar_checadas'
	]);

Route::get('reporte', [
	'uses' => 'AgregarChecada@generarReporte',
	'as'   => 'reporte'
	]);

Route::post('reporte', [
	'uses' => 'AgregarChecada@mostrarReporte',
	'as'   => 'reporte'
	]);

Route::get('eliminar_checada', [
	'uses' => 'AgregarChecada@confirmar',
	'as'   => 'eliminar_checada'
	]);

Route::post('eliminar_checada', [
	'uses' => 'AgregarChecada@destroy',
	'as'   => 'eliminar_checada'
	]);

Route::get('eliminar-empleado-{idEmpleado}', [
	'uses' => 'EmpleadoController@destroy',
	'as'   => 'empleado/destroy'
	]);

Route::get('modificar-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@modificarEmpleado',
	'as'   => 'modificar_empleado'
	]);

Route::post('modificar-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@actualizarEmpleado',
	'as'   => 'actualizar_empleado'
	]);

Route::get('confirmarE-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@confirmarEliminarE',
	'as'   => 'confirmar_eliminarE'
	]);

Route::post('eliminar-empleado-{idEmpleado}',[
	'uses' => 'EmpleadoController@destroy',
	'as'   => 'empleado/destroy'
	]);

Route::get('buscar-empleados', [
	'uses' => 'EmpleadoController@buscar',
	'as'   => 'buscar_empleados'
	]);

Route::post('buscar-empleados', [
	'uses' => 'EmpleadoController@resultados',
	'as'   => 'buscar_empleados'
	]);

# Busquedas rapidas #
Route::get('buscar-empleados/sin_imss', 'EmpleadoController@noImss');
Route::get('buscar-empleados/sin_rfc', 'EmpleadoController@noRfc');
Route::get('buscar-empleados/sin_cuenta', 'EmpleadoController@sinCuenta');
Route::get('buscar-empleados/incompletos' , 'EmpleadoController@incompletos');
Route::get('buscar-empleados/cumple', 'EmpleadoController@cumple');
Route::get('buscar-empleados/sin_curp', 'EmpleadoController@sinCurp');

Route::get('lista-asistencia', [
	'uses' => 'AgregarChecada@listaAsistencia',
	'as'   => 'lista_asistencia'
	]);

Route::post('lista-asistencia', [
	'uses' => 'AgregarChecada@mostrarListaAsistencia',
	'as'   => 'lista_asistencia'
	]);

#probando funcion de eliminar empleados inactivos
Route::get('inactivos', 'EmpleadoController@limpiar');

#### Empleados CT ####
Route::get('empleado-nuevo-ct',[
	'uses' => 'EmpleadoCtController@index',
	'as'   => 'registro_empleado_ct'
	]);

Route::post('empleado-nuevo-ct', [
	'uses' => 'EmpleadoCtController@create',
	'as'   => 'registro_empleado_ct'
	]);

Route::get('empleados-ct-lista', [
	'uses' => 'EmpleadoCtController@mostrarEmpleadosCt',
	'as'   => 'mostrar_empleados_ct'
	]);

Route::get('agregar-checada-ct', [
	'uses' => 'ChecadasCtController@index',
	'as'   => 'agregar_checada_ct'
	]);

Route::post('agregar-checada-ct', [
	'uses' => 'ChecadasCtController@create',
	'as'   => 'agregar_checada_ct'
	]);

Route::get('checada-grupal-ct', [
	'uses' => 'ChecadasCtController@indexGrupal',
	'as'   => 'checada_grupal_ct'
	]);

Route::post('checada-grupal-ct', [
	'uses' => 'ChecadasCtController@createGrupal',
	'as'   => 'checada_grupal_ct'
	]);

Route::get('buscar-checadas-ct', [
	'uses' => 'ChecadasCtController@buscar',
	'as'   => 'buscar_checada_ct'
	]);

Route::post('buscar-checadas-ct', [
	'uses' => 'ChecadasCtController@mostrar',
	'as'   => 'buscar_checada_ct'
	]);

Route::get('eliminar_checada_ct{id}', [
	'uses' => 'ChecadasCtController@confirmar',
	'as'   => 'eliminar_checada_ct'
	]);

Route::post('eliminar_checada_ct{id}', [
	'uses' => 'ChecadasCtController@destroy',
	'as'   => 'eliminar_checada_ct'
	]);

Route::get('ct-reporte', [
	'uses' => 'ChecadasCtController@generarReporte',
	'as'   => 'reporte_ct'
	]);

Route::post('ct-reporte', [
	'uses' => 'ChecadasCtController@mostrarReporte',
	'as'   => 'reporte_ct'
	]);

Route::get('modificar-empleadoct-{idEmpleado}',[
	'uses' => 'EmpleadoCtController@modificarEmpleado',
	'as'   => 'modificar_empleadoct'
	]);

Route::post('modificar-empleadoct-{idEmpleado}',[
	'uses' => 'EmpleadoCtController@actualizarEmpleado',
	'as'   => 'actualizar_empleadoct'
	]);

Route::get('eliminar-empleadoct-{idEmpleado}',[
	'uses' => 'EmpleadoCtController@confirmarEliminarE',
	'as'   => 'confirmar_eliminarCt'
	]);

Route::post('eliminar-empleadoct-{idEmpleado}',[
	'uses' => 'EmpleadoCtController@destroy',
	'as'   => 'empleadoCt/destroy'
	]);

Route::get('descuento-e',[
	'uses' => 'EmpleadoCtController@descuentoEmpleado',
	'as'   => 'descuento-empleado'
	]);

Route::post('descuento-e',[
	'uses' => 'EmpleadoCtController@guardarDescuento',
	'as'   => 'descuento-empleado'
	]);

Route::get('prestamo',[
	'uses' => 'EmpleadoCtController@prestamo',
	'as'   => 'prestamo-empleado'
	]);

Route::post('prestamo',[
	'uses' => 'EmpleadoCtController@guardarPrestamo',
	'as'   => 'prestamo-empleado'
	]);

Route::get('foto-ct',[
	'uses' => 'Filtro\CredencialController@fotoCt',
	'as' =>'foto-ct'
	]);

Route::post('foto-ct',[
	'uses' => 'Filtro\CredencialController@subirFotoCt',
	'as' =>'foto-ct'
	]);


#### Clientes ####
Route::get('lista-clientes' ,[
	'uses' => 'ClienteController@mostrarTodos',
	'as'   => 'mostrar_clientes'
	]);

Route::get('agregar-cliente', [
	'uses' => 'ClienteController@index',
	'as'   => 'agregar_cliente'
	]);

Route::post('agregar-cliente', [
	'uses' => 'ClienteController@create',
	'as'   => 'agregar_cliente'
	]);

Route::get('turnos-{id}', [
	'uses' => 'ClienteController@turnos',
	'as'   => 'turnos'
	]);

Route::post('turnos-{id}', [
	'uses' => 'ClienteController@agregarTurno',
	'as'   => 'turnos'
	]);

Route::get('editar-cliente-{id}', [
	'uses' => 'ClienteController@editar',
	'as'   => 'editar_cliente'
	]);

Route::post('editar-cliente-{id}', [
	'uses' => 'ClienteController@actualizar',
	'as'   => 'editar_cliente'
	]);

Route::get('eliminar-turno-{idTurno}', [
	'uses' => 'ClienteController@eliminarTurno',
	'as'   => 'eliminar_turno'
	]);

Route::get('eliminar-cliente-{id}', [
	'uses' => 'ClienteController@destroy',
	'as'   => 'eliminar_cliente'
	]);

#### FILTRO ####

Route::get('filtro/verificacion',
 ['as' => 'filtro_verificacion', 
 'uses' => 'Filtro\VerificacionController@index']);

Route::post('filtro/verificacion', [
	'uses' => 'Filtro\VerificacionController@verificar',
	'as'   => 'filtro_verificacion'
	]);

Route::get('filtro/examenMedico',
 ['as' => 'filtro_examen_medico', 
 'uses' => 'Filtro\ExaMediController@index']);

Route::post('filtro/examenMedico', [
	'uses' => 'Filtro\ExaMediController@create',
	'as'   => 'filtro_examen_medico'
	]);

Route::get('filtro/credencial',
 ['as' => 'filtro_credencial', 
 'uses' => 'Filtro\CredencialController@index']);

###
Route::post('filtro/credencial', [
	'uses' => 'Filtro\CredencialController@verificar',
	'as'   => 'filtro_verificaCredencial'
	]);

Route::get('filtro/detalle_credencial/{noempleado}', [
	'uses' => 'Filtro\CredencialController@detalleCredencial',
	'as'   => 'filtro_nuevaCredencial'
	]);


Route::get('filtro/descuentos',
 ['as' => 'filtro_descuentos', 
 'uses' => 'Filtro\DescuentosController@index']);

Route::post('filtro/descuentos', [
	'uses' => 'Filtro\DescuentosController@create',
	'as'   => 'filtro_descuentos'
	]);

Route::get('filtro/reembolsos',
 ['as' => 'filtro_reembolsos', 
 'uses' => 'Filtro\ReembolsosController@index']);

Route::post('filtro/reembolsos',[
	'uses' => 'Filtro\ReembolsosController@create',
	'as'   => 'filtro_reembolsos'
	]);

Route::get('detalle_credencial/{id}',[
	'uses' => 'Filtro\CredencialController@detalleCredencial',
	'as' =>'detalle_credencial'
	]);

Route::get('foto-credencial',[
	'uses' => 'Filtro\CredencialController@foto',
	'as' =>'foto-credencial'
	]);

Route::post('foto-credencial',[
	'uses' => 'Filtro\CredencialController@subirFoto',
	'as' =>'foto-credencial'
	]);

Route::get('tomar-foto',[
	'uses' => 'Filtro\CredencialController@tomarFoto',
	'as' =>'tomar-foto'
	]);



####  ADMINISTRADOR  #####
Route::get('mensaje', [
	'uses' => 'MensajeController@index',
	'as'   => 'mensaje'
	]);

Route::post('mensaje', [
	'uses' => 'MensajeController@create',
	'as'   => 'mensaje'
	]);

#### MENSAJES ####
Route::get('ver-mensaje-{id}', [
	'uses' => 'MensajeController@ver',
	'as'   => 'ver_mensaje'
	]);

Route::get('ver-mensajes', [
	'uses' => 'MensajeController@verTodos',
	'as'   => 'ver_mensajes'
	]);


#### PROVEEDORES #####
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


#### rutas para nomina####
Route::get('nomina/exportar', [
	'uses' => 'AgregarChecada@exportar',
	'as' => 'exportar_nomina'
	]);

Route::post('nomina/exportar', [
	'uses' => 'AgregarChecada@datosNomina',
	'as' => 'exportar_nomina']);

Route::get('nomina/indicadores', [
	'uses' => 'AgregarChecada@buscarContadores',
	'as'   => 'indicadores'
	]);

Route::post('nomina/indicadores', [
	'uses' => 'AgregarChecada@mostrarContadores',
	'as'   => 'indicadores'
	]);

#### Inventario ####



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
	'uses' => 'MaterialController@mostrarInventario',
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

## Mejoras en el Sistema Diciembre 2016
Route::get('empleados/historial', [
	'uses' => 'EmpleadoController@historial_get',
	'as'   => 'historial'
	]);

Route::post('empleados/historial', [
	'uses' => 'EmpleadoController@historial_post',
	'as'   => 'historial'
	]);

## Requerimientos por Cliente
Route::get('clientes/requerimiento', [
	'uses' => 'ClienteController@requerimiento_get',
	'as'   => 'requerimiento'
	]);

Route::post('clientes/requerimiento', [
	'uses' => 'ClienteController@requerimiento_post',
	'as'   => 'requerimiento'
	]);

Route::get('clientes/reporte', [
	'uses' => 'ClienteController@buscarReporte',
	'as'   => 'clientes/reporte'
	]);

Route::post('clientes/reporte', [
	'uses' => 'ClienteController@generarReporte',
	'as'   => 'clientes/reporte'
	]);

Route::get('clientes/detalle/reporte', [
	'uses' => 'ClienteController@detalleReporte',
	'as'   => 'clientes/imprimir_reporte' //cambie el nombre de la ruta
	]);


#### Ajax para campos dinamicos ####
Route:: get('/ajax-cliente',function(){
	$idCliente = Input::get('idCliente');
	$turnos = Turno::where('idCliente','=',$idCliente)->get();

	return Response::json($turnos);
});

//para actualizar las horas de entrada al actualizar la empresa 
Route:: get('/ajax-cliente-turno',function(){
	$idCliente = Input::get('idCliente');
	//hay que revertir el orden, pues el jquery funciona con un foreach y el valor que muestra en el textbox es el ultimo
	$horas = Turno::where('idCliente','=',$idCliente)->orderBy('idTurno','desc')->get();

	return Response::json($horas);
});

Route:: get('/ajax-turno',function(){
	$idTurno = Input::get('idTurno');
	$horas = Turno::where('idTurno','=',$idTurno)->get();
	
	return Response::json($horas);
});

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


Route::post('ajax-foto-credencial', function(){

		$empleado = Input::get('empleado');
		//eliminar foto previa
        $foto = Empleado::where('idEmpleado', '=', $empleado)->first();
        if ($foto->foto != null)
		{
        $foto = explode('/',$foto->foto);
        
		    \Storage::delete($foto[1]);
		}


		$Base64Img = Input::get('image');
    	list(, $Base64Img) = explode(';', $Base64Img);
		list(, $Base64Img) = explode(',', $Base64Img);
		//Decodificamos $Base64Img codificada en base64.
		$Base64Img = base64_decode($Base64Img);
    	$name = str_random(30) . '-' . 'imagen';
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  $Base64Img);
    	$user = new Empleado;
            $user->where('idEmpleado', '=', $empleado)
                 ->update(['foto' => 'fotos/' . $name]);
		return Response::json(['empleados' => Input::get('image')]);
});