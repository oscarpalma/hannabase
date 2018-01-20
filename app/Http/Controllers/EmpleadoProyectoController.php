<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Estado;
use App\Modelos\Colonia;
use App\Modelos\EmpleadoProyecto;
use App\Modelos\DatosLocalizacionProyecto;
use Validator;
use DateTime;
use Auth;
use App\Modelos\ClienteProyecto;
use App\Modelos\TurnoProyecto;
use App\Modelos\ChecadaProyecto;
class EmpleadoProyectoController extends Controller {

	public function alta_empleado_get(){
		$estados = Estado::all();
		$colonias= Colonia::where('idColonia','>',0)->orderBy('nombre')->get();
		
	    return view('empleados_proyectos/alta_empleado')->with('colonias',$colonias)->with('estados',$estados);
	}

	public function alta_empleado_post(Request $request){
		//Obtener la información del formulario del apartado de datos Personales
			$nombre = mb_strtoupper($request->input('nombres'));
			$paterno = mb_strtoupper($request->input('ap_paterno'));
			$materno= mb_strtoupper($request->input('ap_materno'));
			$fecha_nacimiento = (string)$request->input('fecha_nacimiento');
			$dia= $fecha_nacimiento[8] .$fecha_nacimiento[9];
			$mes = $fecha_nacimiento[5] . $fecha_nacimiento[6];
			$anio = $fecha_nacimiento[0] . $fecha_nacimiento[1] . $fecha_nacimiento[2] . $fecha_nacimiento[3];
			$curp = strtoupper($request->input('curp'));
			$imss = $request->input('imss');
			$genero = $request->input('genero');			
			

		$validarCurp = new CURP();
		$validator = Validator::make([
			'curp' => $curp,
			'imss' => $imss],

			[
			'imss' => 'unique:empleadosProyecto,imss',
			'curp' => 'unique:empleadosProyecto,curp'
			]);

		//Validar que los campos no se encuentren repetidos
		if($validator->fails() && $validator->messages()->has('curp')){
			$empleado = EmpleadoProyecto::where('curp',$curp)->first();
			
				$errores['nombre'] = 'El empleado ya existe en la base de datos';
			
		}else{
			
			if($validator->fails() && $validator->messages()->has('imss')){
				$errores['imss'] = 'El No. de IMSS ya se encuentra asignado a otro empleado';
			}
		}
		if($validator->fails()){
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}else{

			if(!$validarCurp->validar($request, $validarCurp->generar($request)) || strlen($curp) != 18){
			$errores['curp'] = 'La CURP otorgada no es valida';
				//$errores['curp'] = $validarCurp->generar($request);
			}
			if($imss != ""){
				if($fecha_nacimiento[2].$fecha_nacimiento[3] != $imss[4].$imss[5]){
					$errores['imss'] = 'El número del IMSS ingresado no coincide con los datos del empleado';
				}
			}
			if(!empty($errores))
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
			else{

			$estado = Estado::find($request->input('id_estados'));
			
			//Crear id
			$contador = EmpleadoProyecto::count()+1;
			if($contador<10)
				$id = 'PRO00'.$contador;
			else if($contador<100)
				$id = 'PRO0'.$contador; 
			else if($contador<1000)
				$id = 'PRO'.$contador; 
			
			$empleado = new EmpleadoProyecto([
				'idEmpleado' => $id,
				'nombres' => $nombre,
				'ap_paterno' => $paterno,
				'curp' => $curp,
				'imss' => $imss,
				'genero' => $genero,
				'idestado' => $estado->id_estados,
				'fecha_nacimiento' => $fecha_nacimiento,
				]);
			//Poner en null el apellido materno en caso de estar vacio
			if($materno == ""){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = $materno;
			}
			//Poner en null campo de IMSS en caso de no ser agregado

			if($imss == "")
				$empleado->imss = null;

			else
				$empleado->imss = $imss;
			
			
			
			//Si todo se valido correctamente entonces guardamos el empleado
			$empleado->save();

			$colonia = Colonia::find($request->input('idColonia'));
			$datosLocalizacion = new DatosLocalizacionProyecto([
				'tel_casa'        => $request->input('tel_casa'),
				'tel_cel'         => $request->input('tel_cel'),
				'calle'           => $request->input('calle'),
				'no_interior'     => $request->input('no_interior'),
				'no_exterior'     => $request->input('no_exterior'),
				'idColonia'       => $colonia->idColonia,
				'idEmpleado'      => $id,				
				]);

			$datosLocalizacion->save();

			return redirect()->route('alta_empleado_proyecto')->with('success',$id);
		}

		}
	}

	public function editar_empleado_get($idEmpleado){
			$empleado = EmpleadoProyecto::find($idEmpleado);
			$contacto = DatosLocalizacionProyecto::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('empleados_proyectos/editar_empleado')->with('colonias',$colonias)->with('estados',$estados)->with('empleado',$empleado)->with('contacto',$contacto);
	}

	public function editar_empleado_post($idEmpleado,Request $request){
			$curp = new CURP();
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP no es correcta para los datos del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}
		$empleado = EmpleadoProyecto::find($idEmpleado);
		
		
		$estado = Estado::find($request->input('id_estados'));
		
			
			if($request->input('ap_materno') == ""){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = mb_strtoupper($request->input('ap_materno'));
			}
			
			
		$empleado->nombres = mb_strtoupper($request->input('nombres'));
		$empleado->ap_paterno = mb_strtoupper($request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');		
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');		
		$empleado->save();

		
		DatosLocalizacionProyecto::where('idEmpleado', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		));

		
		return redirect()->route('lista_empleados_proyecto_get');
	}


	public function lista_empleados_get(){
		$empleados = EmpleadoProyecto::all();
			
		return view('empleados_proyectos/lista_empleados')->with('empleados',$empleados);
	}

	public function ver_datos_ajax(Request $request){
		if($request->ajax()){
			$empleado = EmpleadoProyecto::find($request->input('id'));
	        $datos['nombre']=$empleado->ap_paterno." ".$empleado->ap_materno." ".$empleado->nombres;
	        $datos['id']=$empleado->idEmpleado;
	        $fecha= new DateTime($empleado->fecha_nacimiento);
	        $datos['fecha']=$fecha->format('d-m-Y');
	        $datos['curp']=$empleado->curp;
	        $datos['imss']=$empleado->imss;
	        //Obtener nombre de estado
	        $idestado=$empleado->idestado;
	        $estado = Estado::find($idestado);
	        $datos['estado']=$estado->nombre;
	        //Obtener datos de localización
	        $datosLocalizacion = DatosLocalizacionProyecto::where('idEmpleado',$empleado->idEmpleado)->first();
	    	$datos['telefono']=$datosLocalizacion->tel_casa." ".$datosLocalizacion->tel_cel;
	    	$colonia=Colonia::find($datosLocalizacion->idColonia);
	    	$datos['direccion']=strtoupper($datosLocalizacion->calle." ".$datosLocalizacion->no_exterior." ".$datosLocalizacion->no_interior." ".$colonia->nombre);
	    	
	    return json_encode($datos);
    }
    return json_encode(false);
	}

	public function eliminar_empleado_ajax(Request $request){
		
			foreach ($request->input('id') as $id) {
			$empleado = EmpleadoProyecto::find($id);
	        $empleado->delete();
	    }
    	return json_encode(true);
    
      return json_encode(false); 
	}

	public function alta_checada_get(){
		$clientes =ClienteProyecto::orderBy('nombre')->get();
		$empleados = EmpleadoProyecto::all();
			
		return view('empleados_proyectos/alta_checada')->with('clientes',$clientes)->with('empleados',$empleados);
	}

	public function alta_checada_post(Request $request){
		if($request->ajax()){
			$turno = TurnoProyecto::where('idTurno',$request->input('turno'))->first();
			$cliente = ClienteProyecto::where('idCliente',$turno->idCliente)->first();
			$empleado = EmpleadoProyecto::where('idEmpleado',$request->input('empleado'))->first();

			if($this->validarHorarios($request, $empleado)){
				$user = Auth::user();
				$checada = new ChecadaProyecto([
					'idCliente' => $cliente->idCliente,
					'idTurno' => $turno->idTurno,
					'idEmpleado' => $empleado->idEmpleado,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada'),
					'hora_salida' => $request->input('hora_salida'),
					'horas_ordinarias' => $request->input('horas_ordinarias'),
					'horas_extra' => $request->input('horas_extra'),
					'idUsuario' => $user->id
					]);
				

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
		$ch = ChecadaProyecto::where('idEmpleado',$empleado->idEmpleado)->where('fecha',$request->input('fecha'))->first();
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

	public function turnos_ajax(Request $request){
		if($request->ajax()){
			$idCliente = $request->input('idCliente');
			
			$horas = TurnoProyecto::where('idCliente','=',$idCliente)->orderBy('hora_entrada','asc')->get();

			return json_encode($horas);
		}
	}

	public function buscar_checadas_get(){
		//enviar parametros empleados, turnos y clientes para aplicar como filtros de busqueda (jquery?)
			$empleados = EmpleadoProyecto::all();
			$clientes = ClienteProyecto::orderBy('nombre')->get();
			$turnos = TurnoProyecto::all();
			
			$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
			

			return view('empleados_proyectos/buscar_checada')->with('parametros', $parametros);
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
			$empleado = EmpleadoProyecto::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
			array_push($filtrosActivos, ("Empleado: " . strtoupper($empleado->ap_paterno) . " " . strtoupper($empleado->ap_materno) . ", " . strtoupper($empleado->nombres)));
		}

		//crear query para el id de cliente y designar la etiqueta del filtro
		if($request->input('cliente') == 'null') $queryCliente = ""; //string vacio si no se define un cliente
		else {
			$cliente = ClienteProyecto::where('idCliente', $request->input('cliente'))->first();
			$queryCliente = " AND idCliente = '" . $request->input('cliente') . "'";
			array_push($filtrosActivos, ("Empresa: " . $cliente->nombre));
		}

		//crear query para el id de turno y designar la etiqueta del filtro
		if($request->input('turno') == 'null') $queryTurno = ""; //string vacio si no se define cliente
		else {
			$turno = TurnoProyecto::where('idTurno', $request->input('turno'))->first();
			$queryTurno = " AND idTurno = '" . $request->input('turno') . "'";
			array_push($filtrosActivos, ("Turno: " . $turno->hora_entrada . " a " . $turno->hora_salida));
		}


		//unir los queries en un solo string
		$query = $queryFechas . $queryEmpleado . $queryCliente . $queryTurno;

		//ejecutar el query resultante
		$checadas = ChecadaProyecto::whereRaw($query)->get();

		//agregar todos los parametros necesarios para los filtros y los resultados de la busqueda
		$empleados = EmpleadoProyecto::all();
		$clientes = ClienteProyecto::orderBy('nombre')->get();
		$turnos = TurnoProyecto::all();

		//enlistar los filtros activos para la busqueda

		//un array en el que se guardaran los nombres de empleado y de los clientes. El indice sera el idChecada
		$empleadosPorChecada = array();
		$clientesPorChecada = array();

		foreach($checadas as $checada){
			$clientesPorChecada[$checada->idChecada] = ClienteProyecto::where('idCliente', $checada->idCliente)->first()->nombre; //obtener el cliente
			$empleado = EmpleadoProyecto::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado

			$empleadosPorChecada[$checada->idChecada] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres; //agregarlo al arreglo
		}


		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos, 'checadas' => $checadas, 'filtrosActivos' => $filtrosActivos, 'empleadosPorChecada' => $empleadosPorChecada, 'clientesPorChecada' => $clientesPorChecada];
		return view('empleados_proyectos/buscar_checada')->with('parametros',$parametros);
	}

	public function eliminar_checadas_ajax(Request $request){
		if($request->ajax()){
			$checadas = $request->input('checadas');
				
			foreach($checadas as $_checadas){
				$checada = ChecadaProyecto::where('idChecada', $_checadas);
				$checada->delete();
			}
			return json_encode(true);

		}
	}

	public function generar_reporte_get(){
		$empleados = EmpleadoProyecto::all();
		$clientes = ClienteProyecto::orderBy('nombre')->get();
		$turnos = TurnoProyecto::all();

		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
		return view('empleados_proyectos/reporte')->with('parametros', $parametros);
	}

	public function generar_reporte_post(Request $request){
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
			$empleado = EmpleadoProyecto::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
		}

		//crear query para el id de cliente
		$cliente = ClienteProyecto::where('idCliente', $request->input('cliente'))->first();
		$queryCliente = " AND idCliente = '" . $request->input('cliente') . "'";

		//crear query para el id de turno y designar la etiqueta del filtro
		$turno = TurnoProyecto::where('idTurno', $request->input('turno'))->first();
		$queryTurno = " AND idTurno = '" . $request->input('turno') . "'";


		//unir los queries en un solo string
		$query = $queryFechas . $queryEmpleado . $queryCliente . $queryTurno;

		//ejecutar el query resultante para obtener las checadas de esa semana
		$checadas = ChecadaProyecto::whereRaw($query)->get();

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
			$empleado = EmpleadoProyecto::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado
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
			'checadas' => array()];

			for($i = 1; $i <= 7; $i++){ //agregar todas las checadas de la semana
				$fecha = new DateTime();
				$fecha->setISODate($year,$semana,$i);
				$fecha = $fecha->format('Y-m-d');
				$checadaDelDia = ChecadaProyecto::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->where('idCliente', $cliente->idCliente)->where('idTurno', $turno->idTurno)->first();
				$reporte['empleados'][$empleado->idEmpleado]['checadas'][$i] = $checadaDelDia;

				//sumar las horas trabajadas por cada checada
				if($checadaDelDia != null){
					$reporte['total_dias'] ++;
					$reporte['total_horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['total_horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['empleados'][$empleado->idEmpleado]['horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['empleados'][$empleado->idEmpleado]['horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['dias'][$i]['personas'] ++;

					

				}
			}
		}
	
		//agregar todos los parametros necesarios para los filtros y los resultados de la busqueda
		$empleados = EmpleadoProyecto::all();
		$clientes = ClienteProyecto::orderBy('nombre')->get();
		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, "reporte" => $reporte, "semana" => $semana, 'fecha1' => $fecha1, 'fecha2' => $fecha2];
		return view('empleados_proyectos/reporte')->with('parametros',$parametros);
	}

}
