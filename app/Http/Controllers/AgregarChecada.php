<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Checada;
use App\Cliente;
use App\Turno;
use App\Empleado;
use App\User;
use App\Descuento;
use App\Reembolso;
use App\Comedor;
use App\TipoDescuento;
use Input;
use DateTime;
use Auth;

use Illuminate\Http\Request;

class AgregarChecada extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	//checadas individuales
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){
			$clientes =Cliente::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			$info = ['clientes' => $clientes, 'empleados' => $empleados];
			return view('empleados/nuevaChecada')->with('info',$info);
		}

		else
			return view('errors/restringido');
	}


	//metodo para las checadas grupales
	public function indexGrupal()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){
			$clientes =Cliente::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			$info = ['clientes' => $clientes, 'empleados' => $empleados];                                   //|
			return view('empleados/nuevaChecadaGrupal')->with('info',$info);
		}

		else
			return view('errors/restringido');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */


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
	

	//guardar una checada individual
	public function create(Request $request)
	{
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
			return redirect()->route('nuevaChecada')->withInput()->with('success','Checada registrada con éxito');
		}

		else{
			return redirect()->route('nuevaChecada')->withInput()->with('success','El empleado seleccionado ya se encontraba trabajando en ese horario');
		}
	}
	

	//guardar una checada grupal
	public function createGrupal(Request $request)
	{
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

		//realizar el proceso de guardado de checada para cada uno de los ids ingresados
		foreach($ids as $id){
			$empleado = Empleado::where('idEmpleado',$id)->first();
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
			}
		}
		return redirect()->route('nuevaChecadaGrupal')->withInput()->with('success','Checada registrada con éxito');;
	}


	//confirmar la eliminacion de una checada
	public function confirmar(Request $request){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){
			$checadas = $request->input('checadas');
			$informacion = array();
			foreach($checadas as $_checadas){
				$checada = Checada::where('idChecada',$_checadas)->first();
				$empleado = Empleado::where('idEmpleado',$checada->idEmpleado)->first();
				$cliente = Cliente::where('idCliente', $checada->idCliente)->first();
				$info['checada'] = $checada;
				$empleado = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;
				$info['empleado'] = $empleado;
				$info['cliente'] = $cliente;
				array_push($informacion, $info);
			}
			
			/*$checada = Checada::where('idChecada',$idChecada)->first();
			$empleado = Empleado::where('idEmpleado',$checada->idEmpleado)->first();
			$cliente = Cliente::where('idCliente', $checada->idCliente)->first();

			$empleado = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;*/

			// $parametros = ["checada" => $checada, "empleado" => $empleado, "cliente" => $cliente, "check" => $informacion, "idChecadas"=>$checadas];
			$parametros = ["check" => $informacion, "idChecadas"=>$checadas];

			return view('empleados/eliminar')->with('parametros',$parametros);
		}

		else
			return view('errors/restringido');
	}

	//funcion para buscar checadas
	public function buscar()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){
			//enviar parametros empleados, turnos y clientes para aplicar como filtros de busqueda (jquery?)
			$empleados = Empleado::where('contratable', true)->get();
			$clientes = Cliente::all();
			$turnos = Turno::all();
			
				$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
			

			return view('empleados/buscar_checada')->with('parametros', $parametros);
		}

		else 
			return view('errors/restringido');
	}

	public function generarReporte()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad'])){		
			$empleados = Empleado::where('contratable', true)->where('estado', 'empleado')->get();
			$clientes = Cliente::all();
			$turnos = Turno::all();

			$parametros = ['empleados' => $empleados, 'clientes' => $clientes, 'turnos' => $turnos]; //parametros para filtrar la busqueda
			return view('empleados/reporte')->with('parametros', $parametros);
		}

		else
			return view('errors/restringido');
	}


	/*modificar el array enviado con la informacion a la siguiente estructura:
	->reporte = array con clientes, un array con totales (personas, horas, descuentos)
	->clientes = nombre, array con turnos,
	->turnos = nombre (X a Y), array con dias de la semana, array con empleados que trabajaron en ese turno
	->dias = un array con el los totales (personas) de cada dia, el dia del mes que corresponde a cada dia de la semana
	->empleados = array con sus datos (similar al actual, pero agregando descuentos, reembolsos y comedores)
	*/
	public function mostrarReporte(Request $request)
	{
		if($request->input('turno') == 'null'){
			return redirect()->route('reporte')->withInput()->with('message','Por favor, especifique un turno');
		}

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
					$descuentos = Descuento::where('fecha',$fecha)->where('empleado',$empleado->idEmpleado)->get();
					foreach($descuentos as $descuento){
						$tipoDescuento = TipoDescuento::where('id_descuento',$descuento->descuento)->first();
						$reporte['empleados'][$empleado->idEmpleado]['descuentos'] += $tipoDescuento->precio;
						$reporte['total_descuentos'] += $tipoDescuento->precio;
					}

					$reembolsos = Reembolso::where('fecha',$fecha)->where('empleado',$empleado->idEmpleado)->get();
					foreach($reembolsos as $reembolso){
						$tipoDescuento = TipoDescuento::where('id_descuento',$reembolso->descuento)->first();
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
		$empleados = Empleado::where('contratable', true)->get();
		$clientes = Cliente::all();
		$parametros = ['empleados' => $empleados, 'clientes' => $clientes, "reporte" => $reporte, "semana" => $semana, 'fecha1' => $fecha1, 'fecha2' => $fecha2];
		return view('empleados/reporte')->with('parametros',$parametros);
	}

	//funcion para mostrar los resultados de la busqueda
	public function mostrar(Request $request)
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
		$clientes = Cliente::all();
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
		return view('empleados/buscar_checada')->with('parametros',$parametros);
	}

	public function listaAsistencia()
	{
		return view('empleados/lista_asistencia')->with('clientes',Cliente::all());
	}

	public function mostrarListaAsistencia(Request $request)
	{
		if($request->input('turno') == 'null') return view('empleados/lista_asistencia')->with('clientes',Cliente::all())->with('message',"Por favor, seleccione un turno");
		
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

		return view('empleados/lista_asistencia')->with('clientes',Cliente::all())->with('empresa',$cliente)->with('empleados',$empleados)->with('horario',$turno);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request)
	{
		$checadas = $request->input('checadas');
			
			foreach($checadas as $_checadas){
				$checada = Checada::where('idChecada', $_checadas);
				$checada->delete();
			}
		//no hay columna id, por lo que se debe buscar una checada que coincida perfectamente con la enviada como parametro
		//$checada = Checada::where('idChecada', $idChecada);
		//$checada->delete();

		return redirect()->route('buscar_checadas')->with('eliminados','si');
	}

	public function exportar()
	{
		return view('nomina/exportar');
	}

	public function datosNomina(Request $request)
	{

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

		$checadas = Checada::whereRaw($queryFechas)->get();
		$empleados = Empleado::where('contratable',true)->get();
		$clientes = Cliente::all();
		$turnos = Turno::all();
		$comedores = Comedor::where('semana',$semana)->get();
		$descuentos = Descuento::where('semana',$semana)->get();
		$reembolsos = Reembolso::where('semana',$semana)->get();
		$tipo_descuento = TipoDescuento::all();
                
//                $checadas = array();
//                foreach(Checada::whereRaw($queryFechas)->paginate(10) as $checada){
//                        $empleado = Empleado::find($checada->idEmpleado);
//                        $cliente = Cliente::find($checada->idCliente);
//                        $turno = Turno::find($checada->idTurno);
//                        $comedores = Comedor::where('fecha',$checada->fecha)->where('idEmpleado',$checada->idEmpleado)->get();
//                        $descuentos = Descuento::where('fecha',$checada->fecha)->where('empleado',$checada->idEmpleado)->get();
//                        $reembolsos = Reembolso::where('fecha',$checada->fecha)->where('empleado',$checada->idEmpleado)->get();
//                        $ch = [
//                               'fecha' => $checada->fecha,
//                               'idEmpleado' => $checada->idEmpleado,
//                               'ap_paterno' => $empleado->ap_paterno,
//                               'ap_materno' => $empleado->ap_materno,
//                              'nombres' => $empleado->nombres,
//                               'no_cuenta' => $empleado->no_cuenta,
//                               'cliente' => $cliente->nombre,
//                              'horas_ordinarias' => $checada->horas_ordinarias,
//                               'horas_extra' =>$checada->horas_extra,
//                               ];
//                        array_push($checadas,$checada);
//                }

		return view('nomina/resultados')->with('checadas',$checadas)->with('empleados',$empleados)->with('clientes',$clientes)->with('turnos',$turnos)->with('comedores',$comedores)->with('descuentos',$descuentos)->with('reembolsos',$reembolsos)->with('tipo_descuentos',$tipo_descuento)->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('semana',$semana);
	}

        public function buscarContadores()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role,['administrador','contabilidad']))
		        return view('nomina/indicadores');

		else
			return view('errors/restringido');
	}

	public function mostrarContadores(Request $request)
	{
		$semana = $request->input('semana');
		$year = $request->input('year');

		//Obtener la fecha en la que inicia y termina la semana seleccionada
		$fecha1 = new DateTime();
		$fecha1->setISODate($year,$semana,1);
		$fecha1 = $fecha1->format('Y-m-d');

		$fecha2 = new DateTime();
		$fecha2->setISODate($year,$semana,7);
		$fecha2 = $fecha2->format('Y-m-d');

		$max2dias = array();
		$tresDias = array();
		$igual4mas = array();
		$hombres = array();
		$mujeres = array();

		foreach(Empleado::all() as $empleado){
			$checadas = Checada::whereBetween('fecha', [$fecha1,$fecha2])->where('idEmpleado', $empleado->idEmpleado)->get();
			if(count($checadas) == 0) continue;
			if(count($checadas) <= 2){
				array_push($max2dias, ['checadas' => $checadas, 'empleado' => $empleado]);
			}
			if(count($checadas) == 3){
				array_push($tresDias, ['checadas' => $checadas, 'empleado' => $empleado]);
			}
			if(count($checadas) >= 4){
				array_push($igual4mas, ['checadas' => $checadas, 'empleado' => $empleado]);
			}
			if($empleado->genero == 'femenino') array_push($mujeres, $empleado);
			else array_push($hombres, $empleado);
		}

		return view('nomina/indicadores')->with('resultados', ['hombres' => $hombres, 'mujeres' => $mujeres, 'dosDias' => $max2dias, 'tresDias' => $tresDias, 'cuatroDias' => $igual4mas, 'semana' => $semana]);
	}

}