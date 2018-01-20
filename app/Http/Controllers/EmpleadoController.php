<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modelos\Empleado;

use App\Modelos\Colonia;
use App\Modelos\Estado;
use App\Modelos\Cliente;
use App\Modelos\Turno;
use App\Modelos\Descuento;
use App\Modelos\Reembolso;
use App\Modelos\TipoDescuento;
use App\Modelos\Comedor;
use App\Modelos\DatosLocalizacion;

use Validator;
use App;

use App\Modelos\Checada;
use DateTime;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\Factory;
class EmpleadoController extends Controller {

	

	public function lista_get(){
		
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();
			
			return view('empleados_indirectos/lista_empleados')->with('empleados',$empleados);
		
	}

	public function editar_get($idEmpleado){
			$empleado = Empleado::find($idEmpleado);
			$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('empleados_indirectos/editar_empleado')->with('colonias',$colonias)->with('estados',$estados)->with('empleado',$empleado)->with('contacto',$contacto);
	}

	public function editar_post($idEmpleado,Request $request){
			$curp = new CURP();
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP no es correcta para los datos del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}
		$empleado = Empleado::find($idEmpleado);
		
		
		$estado = Estado::find($request->input('id_estados'));
		
			
			if($request->input('ap_materno') == ""){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = mb_strtoupper($request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $request->input('no_cuenta');
			}
		$empleado->nombres = mb_strtoupper($request->input('nombres'));
		$empleado->ap_paterno = mb_strtoupper($request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		$empleado->tipo_perfil = $request->input('tipo_perfil');
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->visa = $request->input('visa');
		$empleado->save();

		
		

		
		DatosLocalizacion::where('idEmpleado', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		'nombre_contacto'=> $request->input('nombre_contacto'),
		'tel_contacto' =>$request->input('tel_contacto'),
		'tipo_parentesco' =>$request->input('tipo_parentesco')));

		$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();

		$estados = Estado::all();
		$colonias= Colonia::all();
		$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'success');
		$empleados = Empleado::where('contratable',true)->where('estado','empleado')->paginate(10);
		return redirect()->route('lista_empleados');
	}



	public function checada_get(){

			$clientes =Cliente::orderBy('nombre')->get();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();
			
			return view('empleados_indirectos/alta_checada')->with('clientes',$clientes)->with('empleados',$empleados);
		
	}


	public function turnos(Request $request){
		if($request->ajax()){
			$idCliente = $request->input('idCliente');
			
			$horas = Turno::where('idCliente','=',$idCliente)->orderBy('hora_entrada','asc')->get();

			return json_encode($horas);
		}
	}


	public function checada_post_ajax(Request $request){
		if($request->ajax()){
			$turno = Turno::where('idTurno',$request->input('turno'))->first();
			$cliente = Cliente::where('idCliente',$turno->idCliente)->first();
			$empleado = Empleado::where('idEmpleado',$request->input('empleado'))->first();

			if($this->validarHorarios($request, $empleado)){
				$user = Auth::user();
				$checada = new Checada([
					'idCliente' => $cliente->idCliente,
					'idTurno' => $turno->idTurno,
					'idEmpleado' => $empleado->idEmpleado,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada'),
					'hora_salida' => $request->input('hora_salida'),
					'horas_ordinarias' => $request->input('horas_ordinarias'),
					'horas_extra' => $request->input('horas_extra'),
					'comentarios' => $request->input('comentarios'),
					'idUsuario' => $user->id
					]);
				if($request->input('incidencia') == "xx"){
					$checada->incidencia = null;
				}
				if($request->input('incidencia') == "falta_justificada"){
					$checada->incidencia = 'falta justificada';
				}
				if($request->input('incidencia') == "falta_injustificada"){
					$checada->incidencia = 'falta injustificada';
				}
				if($request->input('incidencia') == "permiso"){
					$checada->incidencia = 'permiso';
				}

				$checada->save();
				return json_encode(true);
			}else{
				return json_encode(false);
			}
		}
	}



//verificar que el empleado no este trabajando en un horario dado
	public function validarHorarios(Request $request, $empleado)
	{
		//validar si existe una checada en esa fecha
		$ch = Checada::where('idEmpleado',$empleado->idEmpleado)->where('fecha',$request->input('fecha'))->first();
		if($ch != null){ //si hay una checada en esa fecha
			//validar si el turno empieza y termina en otro dia

			if($request->input('hora_salida') < $request->input('hora_entrada')){ //si termina el dia siguiente
				//solo validar hora salida guardada con la de entrada enviada

				if(!$ch->hora_entrada > $ch->hora_salida){ //verificar si la checada registrada no termina el dia siguiente

					//solo se necesita saber si la salida registrada es antes que la entrada enviada
					if($ch->hora_salida > $request->input('hora_entrada')){
						return false;
					}
					else{
						return true;
					}
				}

				else{ //si la checada guardada y la enviada terminan el dia siguiente

					//la validacion es igual que si terminan el mismo dia
					if(($request->input('hora_entrada') < $ch->hora_entrada && $request->input('hora_salida') <= $ch->hora_entrada) || ($request->input('hora_entrada') >= $ch->hora_salida && $request->input('hora_salida') > $ch->hora_salida)){
						return true;
					}

					else{
						return false;
					}			
				}
			}

			else{ //si el turno termina el mismo dia
				if(($request->input('hora_entrada') < $ch->hora_entrada && $request->input('hora_salida') <= $ch->hora_entrada) || ($request->input('hora_entrada') >= $ch->hora_salida && $request->input('hora_salida') > $ch->hora_salida)){
					return true;
				}

				else{
					return false;
				}
			}
		}

		else {
			return true;
		}
	}

	public function checadaG_get(){

			$clientes =Cliente::orderBy('nombre')->get();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			                                   
			return view('empleados_indirectos/alta_checadaG')->with('clientes',$clientes)->with('empleados',$empleados);
		
	}

	public function checadaG_post_ajax(Request $request){
		if($request->ajax()){
			//obtener los datos del cliente y turno seleccionado
			$cliente = Cliente::where('idCliente',$request->input('cliente'))->first();
			$turno = Turno::where('idTurno',$request->input('turno'))->first();
			//obtener el id del usuario del sistema actual
			$user = Auth::user(); //reemplazar posteriormente con el id del usuario actual

			//obtener los id de empleado ingresados
			$ids = $request->input('empleados');
			//eliminar cualquier espacio blanco en el string
			$ids = preg_replace('/\s+/', '',$ids);
			//remover comas al principio e inicio del string, si las hay
			$ids = trim($ids,',');
			//separar el string en un array, utilizando comas como el separador
			$ids = explode(',',$ids);

			$ids = array_unique($ids); //remover entradas repetidas
			$i=0;
			$errores=0;
			//realizar el proceso de guardado de checada para cada uno de los ids ingresados
			foreach($ids as $id){
				$empleado = Empleado::where('idEmpleado',$id)->where('estado','empleado')->where('contratable',1)->first();
				if($empleado === null) continue;

				if($this->validarHorarios($request, $empleado)){
					$checada = new Checada([
						'idCliente' => $cliente->idCliente,
						'idTurno' => $turno->idTurno,
						'idEmpleado' => $empleado->idEmpleado,
						'fecha' => $request->input('fecha'),
						'hora_entrada' => $request->input('hora_entrada'),
						'hora_salida' => $request->input('hora_salida'),
						'horas_ordinarias' => $request->input('horas_ordinarias'),
						'horas_extra' => $request->input('horas_extra'),
						'comentarios' => $request->input('comentarios'),
						'idUsuario' => $user->id,
						'incidencia'=> $request->input('incidencia')
						]);
					if($request->input('incidencia') == "xx"){
						$checada->incidencia = null;
					}
					$checada->save();
					$i++;
				}
			}return json_encode($i);
		}

	}

	/*
	Funcion para mostrar los empleados a los cuales se esta
	apunto de agregar checada en checada grupal
	*/
	public function verificar_ajax(Request $request){
		if($request->ajax()){
			//obtener los id de empleado ingresados
			$ids = $request->input('empleados');
			//eliminar cualquier espacio blanco en el string
			$ids = preg_replace('/\s+/', '',$ids);
			//remover comas al principio e inicio del string, si las hay
			$ids = trim($ids,',');
			//separar el string en un array, utilizando comas como el separador
			$ids = explode(',',$ids);

			$ids = array_unique($ids); //remover entradas repetidas
			
			$informacion = array();
			foreach($ids as $id){
				
				$empleado = Empleado::where('idEmpleado',$id)->first();
				if($empleado!=null){
				$info['id'] = $id;
				$nombre = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;
				$info['nombre'] = $nombre;
				$info['curp'] = $empleado->curp;
				$info['estado'] = ucwords($empleado->estado);
				array_push($informacion, $info);
			}
			}
			return json_encode($informacion);

		}
	}

	
public function reporte_get(){
	
		$empleados = Empleado::where('contratable', true)->where('estado', 'empleado')->get();
			$clientes = Cliente::orderBy('nombre')->get();
			$turnos = Turno::all();

			$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
			return view('empleados_indirectos/reporte')->with('parametros', $parametros);
		
}
	

public function reporte_post(Request $request){
	

		//Cambiar la semana dada a fechas
		$semana = $request->input("semana");
		$year = $request->input("year"); //en ingles para no sonar obsceno

		//Obtener la fecha en la que inicia y termina la semana seleccionada
		$fecha1 = new DateTime();
		$fecha1->setISODate($year,$semana,1);
		$fecha1 = $fecha1->format('Y-m-d');

		$fecha2 = new DateTime();
		$fecha2->setISODate($year,$semana,7);
		$fecha2 = $fecha2->format('Y-m-d');

		//declarar el query en formato SQL para cada uno de los parametros, como un string
		//el string siguiente seria "fecha BETWEEN CAST('{fecha1}' AS DATE) AND CAST('{fecha2}' AS DATE)"
		$queryFechas = "fecha BETWEEN CAST('" . $fecha1 . "' AS DATE) AND CAST('" . $fecha2 . "' AS DATE)";

		//crear el query para el numero de empleado
		if($request->input('empleado') == 'null') $queryEmpleado = ""; //string vacio si no se define un empleado
		else {
			$empleado = Empleado::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
		}

		//crear query para el id de cliente
		$cliente = Cliente::where('idCliente', $request->input('cliente'))->first();
		$queryCliente = " AND idCliente = '" . $request->input('cliente') . "'";

		//crear query para el id de turno y designar la etiqueta del filtro
		$turno = Turno::where('idTurno', $request->input('turno'))->first();
		$queryTurno = " AND idTurno = '" . $request->input('turno') . "'";


		//unir los queries en un solo string
		$query = $queryFechas . $queryEmpleado . $queryCliente . $queryTurno;

		//ejecutar el query resultante para obtener las checadas de esa semana
		$checadas = Checada::whereRaw($query)->get();

		$reporte = [
		'cliente' => $cliente->nombre,
		'turno'   => $turno->hora_entrada . ' A ' . $turno->hora_salida,
		'total_descuentos' => 0,
		'total_reembolsos' => 0,
		'total_comedores' =>0,
		'total_horas_ordinarias' => 0,
		'total_horas_extra' => 0,
		'total_dias' => 0,
		'empleados' => array(),
		'dias' => array() //la informacion de los dias de la semana
		];

		$reporte['dias'] = [
		1 => array(), //lunes
		2 => array(), //martes
		2 => array(), //miercoles
		4 => array(), //jueves
		5 => array(), //viernes
		6 => array(), //sabado
		7 => array(), //domingo
		];

		for($i = 1; $i <= 7; $i++){ //obtener el dia del mes en el que cae cada dia de la semana
			$fecha = new DateTime();
			$fecha->setISODate($year,$semana,$i);
			$reporte['dias'][$i]['dia'] = $fecha->format('d');
			$reporte['dias'][$i]['personas'] = 0;
		}

		$empleados = array();
		//obtener los empleados que trabajaron en esa semana
		foreach($checadas as $checada){
			$empleado = Empleado::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado
			array_push($empleados, $empleado);
		}

		$empleados = array_unique($empleados); //eliminar empleados repetidos


		foreach($empleados as $empleado){
			$reporte['empleados'][$empleado->idEmpleado] = [
			'id' => $empleado->idEmpleado,
			'ap_paterno' => $empleado->ap_paterno,
			'ap_materno' => $empleado->ap_materno,
			'nombre' => $empleado->nombres,
			'no_cuenta' => $empleado->no_cuenta,
			'horas_ordinarias' => 0,
			'horas_extra' => 0,
			'checadas' => array(),
			'descuentos' => 0,
			'reembolsos' => 0,
			'comedores' => 0];

			for($i = 1; $i <= 7; $i++){ //agregar todas las checadas de la semana
				$fecha = new DateTime();
				$fecha->setISODate($year,$semana,$i);
				$fecha = $fecha->format('Y-m-d');
				$checadaDelDia = Checada::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->where('idCliente', $cliente->idCliente)->where('idTurno', $turno->idTurno)->first();
				$reporte['empleados'][$empleado->idEmpleado]['checadas'][$i] = $checadaDelDia;

				//sumar las horas trabajadas por cada checada
				if($checadaDelDia != null){
					$reporte['total_dias'] ++;
					$reporte['total_horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['total_horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['empleados'][$empleado->idEmpleado]['horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['empleados'][$empleado->idEmpleado]['horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['dias'][$i]['personas'] ++;

					//agregar los descuentos, reembolsos y comedores que coincidan con la fecha trabajada:
					$descuentos = Descuento::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->get();
					foreach($descuentos as $descuento){
						$tipoDescuento = TipoDescuento::where('idTipoDescuento',$descuento->descuento)->first();
						$reporte['empleados'][$empleado->idEmpleado]['descuentos'] += $tipoDescuento->precio;
						$reporte['total_descuentos'] += $tipoDescuento->precio;
					}

					$reembolsos = Reembolso::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->get();
					foreach($reembolsos as $reembolso){
						$tipoDescuento = TipoDescuento::where('idTipoDescuento',$reembolso->descuento)->first();
						$reporte['empleados'][$empleado->idEmpleado]['reembolsos'] += $tipoDescuento->precio;
						$reporte['total_reembolsos'] += $tipoDescuento->precio;
					}

					$comedores = Comedor::where('fecha', $fecha)->where('idEmpleado',$empleado->idEmpleado)->get();
					foreach($comedores as $comedor){
						$reporte['empleados'][$empleado->idEmpleado]['comedores'] += ($comedor->cantidad*20);
						$reporte['total_comedores'] += ($comedor->cantidad*20);
					}

				}
			}
		}
	
		//agregar todos los parametros necesarios para los filtros y los resultados de la busqueda
		$empleados = Empleado::where('contratable', true)->where('estado','empleado')->get();
		$clientes = Cliente::orderBy('nombre')->get();
		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, "reporte" => $reporte, "semana" => $semana, 'fecha1' => $fecha1, 'fecha2' => $fecha2];
		return view('empleados_indirectos/reporte')->with('parametros',$parametros);
}	

	public function comedores_get(){
			return view('empleados_indirectos/alta_comedores');

	}

	public function comedores_post(Request $request)
	{
		//obtener numero de semana para validar

		$fecha = new DateTime($request->input('fecha'));

		/*if($fecha->format("W") != $request->input('semana')){
			return redirect()->route('comedores')->withInput()->with('message','La semana no coincide con la fecha ingresada');
		}*/

		//leer los id ingresados
		$ids = $request->input('empleados');
		//eliminar cualquier espacio blanco en el string
		$ids = preg_replace('/\s+/', '',$ids);
		//remover comas al principio e inicio del string, si las hay
		$ids = trim($ids,',');
		//separar el string en un array, utilizando comas como el separador
		$ids = explode(',',$ids);

		$ids = array_unique($ids); //remover entradas repetidas

		foreach($ids as $id){
			$empleado = Empleado::where('idEmpleado',$id)->first();
			if($empleado === null) continue;
			$comedor = new Comedor([
				'idEmpleado' => $empleado->idEmpleado,
				'semana' => $fecha->format("W"),
				'fecha' => $request->input('fecha'),
				'cantidad' => $request->input('cantidad')
				]);

			$comedor->save();
		}

		return view('empleados_indirectos/alta_comedores')->with('message','Descuentos de comedor guardados exitosamente');

	}
 
	public function buscar_checadas_get()
	{
			//enviar parametros empleados, turnos y clientes para aplicar como filtros de busqueda (jquery?)
			$empleados = Empleado::where('contratable', true)->get();
			$clientes = Cliente::orderBy('nombre')->get();
			$turnos = Turno::all();
			
				$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
			

			return view('empleados_indirectos/buscar_checada')->with('parametros', $parametros);
		
	}

	public function buscar_checadas_post(Request $request)
	{
		//crear un array en el que se incluiran los filtros actuales, para ser mostrados junto a la lista de resultados
		$filtrosActivos = array();


		//declarar el query en formato SQL para cada uno de los parametros, como un string
		//el string siguiente seria "fecha BETWEEN CAST('{fecha1}' AS DATE) AND CAST('{fecha2}' AS DATE)"
		$queryFechas = "fecha BETWEEN CAST('" . $request->input('fecha1') . "' AS DATE) AND CAST('" . $request->input('fecha2') . "' AS DATE)";
		array_push($filtrosActivos, ("Desde " . $request->input('fecha1') . " hasta " . $request->input('fecha2')));

		//crear el query para el numero de empleado y designar la etiqueta del filtro
		if($request->input('empleado') == 'null') $queryEmpleado = ""; //string vacio si no se define un empleado
		else {
			$empleado = Empleado::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
			array_push($filtrosActivos, ("Empleado: " . strtoupper($empleado->ap_paterno) . " " . strtoupper($empleado->ap_materno) . ", " . strtoupper($empleado->nombres)));
		}

		//crear query para el id de cliente y designar la etiqueta del filtro
		if($request->input('cliente') == 'null') $queryCliente = ""; //string vacio si no se define un cliente
		else {
			$cliente = Cliente::where('idCliente', $request->input('cliente'))->first();
			$queryCliente = " AND idCliente = '" . $request->input('cliente') . "'";
			array_push($filtrosActivos, ("Empresa: " . $cliente->nombre));
		}

		//crear query para el id de turno y designar la etiqueta del filtro
		if($request->input('turno') == 'null') $queryTurno = ""; //string vacio si no se define cliente
		else {
			$turno = Turno::where('idTurno', $request->input('turno'))->first();
			$queryTurno = " AND idTurno = '" . $request->input('turno') . "'";
			array_push($filtrosActivos, ("Turno: " . $turno->hora_entrada . " a " . $turno->hora_salida));
		}


		//unir los queries en un solo string
		$query = $queryFechas . $queryEmpleado . $queryCliente . $queryTurno;

		//ejecutar el query resultante
		$checadas = Checada::whereRaw($query)->get();

		//agregar todos los parametros necesarios para los filtros y los resultados de la busqueda
		$empleados = Empleado::where('contratable', true)->get();
		$clientes = Cliente::orderBy('nombre')->get();
		$turnos = Turno::all();

		//enlistar los filtros activos para la busqueda

		//un array en el que se guardaran los nombres de empleado y de los clientes. El indice sera el idChecada
		$empleadosPorChecada = array();
		$clientesPorChecada = array();

		foreach($checadas as $checada){
			$clientesPorChecada[$checada->idChecada] = Cliente::where('idCliente', $checada->idCliente)->first()->nombre; //obtener el cliente
			$empleado = Empleado::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado

			$empleadosPorChecada[$checada->idChecada] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres; //agregarlo al arreglo
		}


		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos, 'checadas' => $checadas, 'filtrosActivos' => $filtrosActivos, 'empleadosPorChecada' => $empleadosPorChecada, 'clientesPorChecada' => $clientesPorChecada];
		return view('empleados_indirectos/buscar_checada')->with('parametros',$parametros);
	}

	public function baja_checadas_ajax(Request $request){
		if($request->ajax()){
			$checadas = $request->input('checadas');
				
			foreach($checadas as $_checadas){
				$checada = Checada::where('idChecada', $_checadas);
				$checada->delete();
			}
			return json_encode(true);

		}
	}


	

	public function modificarCandidato($idEmpleado){
		
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = Empleado::find($idEmpleado);
			$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('editar_candidato')->with('datosLocalizacion',$datosLocalizacion);
		
	}

	public function verEmpleado($idEmpleado)
	{
		
			$empleado = Empleado::find($idEmpleado);
			$localizacion = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			$estado = Estado::find($empleado->idestado)->nombre;
			$colonia = Colonia::find($localizacion->idColonia)->nombre;

			$empleado = [
			'ap_paterno' => $empleado->ap_paterno,
			'ap_materno' => $empleado->ap_materno,
			'nombres' => $empleado->nombres,
			'fecha_nacimiento' => $empleado->fecha_nacimiento,
			'genero' => $empleado->genero,
			'estado' => $estado,
			'curp' => $empleado->curp,
			'imss' => $empleado->imss,
			'no_cuenta' => $empleado->no_cuenta,
			'tipo_perfil' => $empleado->tipo_perfil,
			'tel_casa' => $localizacion->tel_casa,
			'tel_cel' => $localizacion->tel_cel,
			'calle' => $localizacion->calle,
			'no_interior' => $localizacion->no_interior,
			'no_exterior' => $localizacion->no_exterior,
			'colonia' => $colonia,
			'nombre_contacto' => $localizacion->nombre_contacto,
			'tel_contacto' => $localizacion->tel_contacto,
			'tipo_parentesco' => $localizacion->tipo_parentesco
			];

			return view('ver_empleado')->with('empleado',$empleado);
		
	}

	public function buscar_comedores_get(){
		$empleados = Empleado::where('contratable', true)->get();
			
			
				$parametros = ['empleados' => $empleados]; //parametros para filtrar la busqueda
			

			return view('empleados_indirectos/buscar_comedores')->with('parametros', $parametros);
	}

	public function buscar_comedores_post(Request $request){
		//Cambiar la semana dada a fechas
			$semana = $request->input("semana");
			$year = $request->input("year"); //en ingles para no sonar obsceno
			$empleado = Empleado::where('idEmpleado', $request->input('empleado'))->first();

			$fecha1 = new DateTime();
			$fecha1->setISODate($year,$semana,1);
			$fecha1 = $fecha1->format('Y-m-d');

			$fecha2 = new DateTime();
			$fecha2->setISODate($year,$semana,7);
			$fecha2 = $fecha2->format('Y-m-d');

			$comedores = array();

			for($i = 1; $i <= 7; $i++){ //agregar todos los comedores de la semana
				$fecha = new DateTime();
				$fecha->setISODate($year,$semana,$i);
				$comedores[$i]['dia'] = $fecha->format('d');
				$fecha = $fecha->format('Y-m-d');
				$comedores[$i]['cantidad'] = 0;

				foreach(Comedor::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->get() as $comedor){
					$comedores[$i]['cantidad'] += $comedor->cantidad;
				}
			}

			$empleados = Empleado::where('contratable', true)->get();
		
		
			$parametros = ['empleados' => $empleados,'comedores' => $comedores, 'empleado' => $empleado, 'fecha1' => $fecha1,'fecha2' => $fecha2, 'semana' => $semana]; //parametros para filtrar la busqueda
			

			return view('empleados_indirectos/buscar_comedores')->with('parametros', $parametros);
	}

	public function eliminar_comedores_post(Request $request){
		$fecha = new DateTime();
		$fecha->setISODate($request->input('year'),$request->input('semana'),$request->input('dia'));
		foreach(Comedor::where('idEmpleado',$request->input('empleado'))->where('fecha', $fecha->format('Y-m-d'))->get() as $comedor){
			$comedorBorrar = Comedor::find($comedor->idComedores);
			$comedorBorrar->delete();
		}

		return $this->buscar_comedores_post($request);
	}



##Consultas

	public function buscar()
	{
			return view('empleados_indirectos/consultas');
		
	}

	

	

	public function sinCuenta()
	{
		$datosLocalizacion = array();
		foreach (DatosLocalizacion::all() as $datos) {
			$datosLocalizacion[$datos->idEmpleado] = $datos;
		}
		$colonias = array();
		foreach (Colonia::all() as $colonia) {
			$colonias[$colonia->idColonia] = $colonia;
		}
		return view('empleados_indirectos/consultas')->with('empleados',Empleado::where('no_cuenta',null)->where('contratable',1)->where('estado','empleado')->get())->with('sin_cuenta',true)->with('datosLocalizacion',$datosLocalizacion)->with('colonias',$colonias);
	}

	public function incompletos()
	{
		$consulta =	Empleado::where(function ($query) {
	    $query->where('imss',null)
	          ->where('contratable',1);
		})->orWhere(function ($query) {
	    $query->where('no_cuenta',null)
	          ->where('contratable',1);
		}) ->orWhere(function ($query) {
	    $query->where('curp',null)
	          ->where('contratable',1);
		})->get();


		return view('empleados_indirectos/consultas')->with('empleados',$consulta);
	}

	public function todos()
	{

		return view('empleados_indirectos/consultas')->with('empleados',Empleado::where('contratable',1)->get());
	}

	

	public function resultados(Request $request)
	{
		$query = "";

		//curp
		if($request->input('curp') != 'true')
			$query = $query . "curp is NULL AND ";
		else
			$query = $query . "curp is not NULL AND ";

		//imss
		if($request->input('imss') != 'true')
			$query = $query . "imss is NULL AND ";		
		else
			$query = $query . "imss is not NULL AND ";

		

		//numero de cuenta
		if($request->input('no_cuenta') != 'true')
			$query = $query . "no_cuenta is NULL AND ";
		else
			$query = $query . "no_cuenta is not NULL AND ";

		//terminan los queries de documentacion


		//perfiles
		if($request->input('perfil_a') != 'true' && $request->input('perfil_b') != 'true' && $request->input('perfil_c') != 'true')
			return redirect()->route('buscar_empleados')->withInput()->with('message',"Por favor, seleccione al menos un tipo de perfil");
		$query = $query . "(";
		if($request->input('perfil_a') == 'true')
			$query = $query . "tipo_perfil = 'a' OR ";

		if($request->input('perfil_b') == 'true')
			$query = $query . "tipo_perfil = 'b' OR ";

		if($request->input('perfil_c') == 'true')
			$query = $query . "tipo_perfil = 'c'";

		//eliminar OR en caso de quedar al final
		$query = preg_replace('/ OR $/', "", $query);
		$query = $query . ") AND (";
		//terminan los queries de perfiles

		//queries estado
		if($request->input('candidato') != 'true' && $request->input('empleado') != 'true')
			return redirect()->route('buscar_empleados')->withInput()->with('message','Por favor, seleccione al menos un estado');
		if($request->input('candidato') == 'true')
			$query = $query . "estado = 'candidato' OR ";
		if($request->input('empleado') == 'true')
			$query = $query . "estado = 'empleado'";

		//eliminar OR en caso de quedar al final
		$query = preg_replace('/ OR $/', "", $query);
		$query = $query . ")";
		//termina query estado

		//lista negra
		if($request->input('no_contratable') != 'true')
			$query = $query . " AND contratable = 1";

		$empleados = Empleado::whereRaw($query)->get();
		return view('empleados_indirectos/consultas')->with('empleados',$empleados);
	}

	public function cumple()
	{
		$fecha_actual = new DateTime('now');
		$mes = $fecha_actual->format('n');
		$empleados = array();

		foreach (Empleado::where('contratable', 1)->get() as $empleado) {
			$cumple = new DateTime($empleado->fecha_nacimiento);
			if($cumple->format('n') == $mes) array_push($empleados, $empleado);
		}
		return view('empleados_indirectos/consultas')->with('empleados',$empleados);
	}
	
	

	//funcion encargada de cambiar a candidatos los empleados sin actividad en los ultimos 8 dias
	public function limpiar_post_ajax(Request $request)
	{
		//obtener la fecha actual
		$fecha = new DateTime('now');
		$empleadosInactivos = array();
		$diasTolerancia = $request->input('dias'); //los dias que un empleado puede aparecer como inactivo sin ser convertido en candidato
		$cont = 0; //un contador con el numero de empleados inactivos que fueron convertidos en candidatos
		$ids = array();
		foreach(Empleado::where('estado', 'empleado')->where('contratable', true)->get() as $empleado){
			//obtiene la checada mas reciente del empleado
			$checada = Checada::where('idEmpleado', $empleado->idEmpleado)->orderBy('fecha','desc')->first();

			//si no existe checada, verificar si ha habido actividad durante los ultimos 8 dias
			if($checada === null){
				if($fecha->diff(new DateTime($empleado->updated_at))->format('%a') >= $diasTolerancia) {
					//modifica el empleado a candidato y lo guarda en la base de datos
					$empleado->estado = 'candidato';
					$empleado->save();
					$cont++;
				}
				continue;
			}

			//obtiene la cantidad de dias entre hoy y la ultima checada registrada del empleado
			if($fecha->diff(new DateTime($checada->fecha))->format('%a') >= $diasTolerancia){ 
				//modifica el empleado a candidato y lo guarda en la base de datos
				$empleado->estado = 'candidato';
				$empleado->save();
				$cont++;
				array_push($ids, $empleado->idEmpleado);
			}
		}

		return json_encode($ids);
	}


	## Modificar ##
	public function listaAsistencia()
	{
		return view('empleados_indirectos/lista_asistencia')->with('clientes',Cliente::orderBy('nombre')->get());
	}

	public function mostrarListaAsistencia(Request $request)
	{
		if($request->input('turno') == 'null') return view('empleados_indirectos/lista_asistencia')->with('clientes',Cliente::all())->with('message',"Por favor, seleccione un turno");
		
		//obtener los id de empleado ingresados
		$ids = $request->input('empleados');
		//eliminar cualquier espacio blanco en el string
		$ids = preg_replace('/\s+/', '',$ids);
		//remover comas al principio e inicio del string, si las hay
		$ids = trim($ids,',');
		//separar el string en un array, utilizando comas como el separador
		$ids = explode(',',$ids);

		$ids = array_unique($ids); //remover entradas repetidas

		$empleados = array();

		foreach($ids as $id){
			array_push($empleados, Empleado::find($id));
		}

		$cliente = Cliente::find($request->input('cliente'));
		$turno = Turno::find($request->input('turno'));
		$turno = $turno->hora_entrada . ' - ' . $turno->hora_salida;

		return view('empleados_indirectos/lista_asistencia')->with('clientes',Cliente::orderBy('nombre')->get())->with('empresa',$cliente)->with('empleados',$empleados)->with('horario',$turno);
	}
}