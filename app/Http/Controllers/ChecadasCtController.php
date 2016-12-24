<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EmpleadoCt;
use App\User;
use App\ChecadaCt;
use App\AreaCt;
use App\Prestamo;
use App\DescuentoCt;
use DateTime;
use Auth;

use Illuminate\Http\Request;

class ChecadasCtController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){		
			//obtener los empleados internos y enviarlos a la vista
			$empleados = EmpleadoCt::all();
			return view('empleados_ct/agregar_checada_ct')->with('empleados', $empleados);
		}

		else
			return view('errors/restringido');
	}

	public function indexGrupal()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion']))
			return view('empleados_ct/agregar_checada_ct_grupal');

		else 
			return view('errors/restringido');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//encontrar al empleado seleccionado
		$empleado = EmpleadoCt::where('idEmpleadoCt', $request->input('empleado'))->first();
		$user = Auth::user(); //debe reemplazarse por el usuario actual
		
		if($this->validarHorarios($request,$empleado)){
			//pasar los parametros a la nueva checada
			$checada = new ChecadaCt([
				'idEmpleadoCt' => $empleado->idEmpleadoCt,
				'fecha' => $request->input('fecha'),
				'hora_entrada' => $request->input('hora_entrada'),
				'hora_salida' => $request->input('hora_salida'),
				'horas_ordinarias' => $request->input('horas_ordinarias'),
				'horas_extra' => $request->input('horas_extra'),
				'comentarios' => $request->input('comentarios'),
				'idUsuario' => $user->id
				]);

			//consideraciones especiales para guardar las incidencias
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

			//segunda checada
			if($request->input('hora_entrada2') != ''){				
				$checada = new ChecadaCt([
					'idEmpleadoCt' => $empleado->idEmpleadoCt,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada2'),
					'hora_salida' => $request->input('hora_salida2'),
					'horas_ordinarias' => $request->input('horas_ordinarias2'),
					'horas_extra' => $request->input('horas_extra2'),
					'comentarios' => $request->input('comentarios'),
					'idUsuario' => $user->id
					]);

				//consideraciones especiales para guardar las incidencias
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

			return redirect()->route('agregar_checada_ct')->withInput()->with('success','Checada registrada con éxito');;
		}

		else{
			return redirect()->route('agregar_checada_ct')->withInput()->with('success','El empleado seleccionado ya se encontraba trabajando en ese horario');
		}

	}

	public function createGrupal(Request $request)
	{
		$user = Auth::user();
		
		//obtener los id de empleado ingresados
		$ids = $request->input('empleados');
		//eliminar cualquier espacio blanco en el string
		$ids = preg_replace('/\s+/', '',$ids);
		//remover comas al principio e inicio del string, si las hay
		$ids = trim($ids,',');
		//separar el string en un array, utilizando comas como el separador
		$ids = explode(',',$ids);

		$ids = array_unique($ids); //remover entradas repetidas

		//realizar el proceso de almacenar checadas por cada persona ingresada
		foreach($ids as $id){
			$empleado = EmpleadoCt::where('idEmpleadoCt', $id)->first();
			if($empleado === null) continue; //omitir empleados que no existan

			if($this->validarHorarios($request, $empleado)){
				$checada = new ChecadaCt([
					'idEmpleadoCt' => $empleado->idEmpleadoCt,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada'),
					'hora_salida' => $request->input('hora_salida'),
					'horas_ordinarias' => $request->input('horas_ordinarias'),
					'horas_extra' => $request->input('horas_extra'),
					'comentarios' => $request->input('comentarios'),
					'idUsuario' => $user->id
					]);

				//consideraciones especiales para guardar las incidencias
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

				//segunda checada
				if($request->input('hora_entrada2') != ''){
					$checada = new ChecadaCt([
						'idEmpleadoCt' => $empleado->idEmpleadoCt,
						'fecha' => $request->input('fecha'),
						'hora_entrada' => $request->input('hora_entrada2'),
						'hora_salida' => $request->input('hora_salida2'),
						'horas_ordinarias' => $request->input('horas_ordinarias2'),
						'horas_extra' => $request->input('horas_extra2'),
						'comentarios' => $request->input('comentarios'),
						'idUsuario' => $user->id
						]);

					//consideraciones especiales para guardar las incidencias
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
		}
		return redirect()->route('checada_grupal_ct')->withInput()->with('success','Checada grupal registrada con éxito');
	}

	public function validarHorarios(Request $request, $empleado)
	{
		//validar si existe una checada en esa fecha
		$ch = ChecadaCt::where('idEmpleadoCt',$empleado->idEmpleadoCt)->where('fecha',$request->input('fecha'))->first();
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

	public function buscar()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
			$empleados = EmpleadoCt::all();

			$parametros = ['empleados' => $empleados]; //se utiliza un array porque despues de encontrarlas, se enviaran mas parametros
			return view('empleados_ct/buscar_checadas_ct')->with('parametros', $parametros);
		}

		else
			return view('errors/restringido');
	}

	//muestra resultados de la busqueda
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
			$empleado = EmpleadoCt::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleadoCt = '" . $request->input('empleado') ."'";
			array_push($filtrosActivos, ("Empleado: " . strtoupper($empleado->ap_paterno) . " " . strtoupper($empleado->ap_materno) . ", " . strtoupper($empleado->nombres)));
		}

		$query = $queryFechas . $queryEmpleado;

		$checadas = ChecadaCt::whereRaw($query)->get();

		//obtener un array en el cual almacenar los nombres de los empleados
		$empleadosPorChecada = array();
		foreach($checadas as $checada){
			$empleado = EmpleadoCt::where('idEmpleadoCt', $checada->idEmpleadoCt)->first(); //obtener al empleado

			$empleadosPorChecada[$checada->idChecadaCt] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres; //agregarlo al arreglo
		}

		$empleados = EmpleadoCt::all(); //obtener a los empleados para usarlos como filtro de busqueda
		$parametros = ['empleados' => $empleados, 'checadas' => $checadas, 'filtrosActivos' => $filtrosActivos, 'empleadosPorChecada' => $empleadosPorChecada];
		return view('empleados_ct/buscar_checadas_ct')->with('parametros',$parametros);
	}

	//abrir la vista para reporte
	public function generarReporte()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
			$empleados = EmpleadoCt::all();

			$parametros = ['empleados' => $empleados]; //parametros para filtrar la busqueda
			return view('empleados_ct/reporte_ct')->with('parametros', $parametros);
		}

		else
			return view('errors/restringido');
	}

	public function mostrarReporte(Request $request)
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

		//crear el query para el numero de empleado y designar la etiqueta del filtro
		if($request->input('empleado') == 'null') $queryEmpleado = ""; //string vacio si no se define un empleado
		else {
			$empleado = EmpleadoCt::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
		}

		$query = $queryFechas . $queryEmpleado;

		$checadas = ChecadaCt::whereRaw($query)->get();

		$empleados = array();

		$reporte = [
		'empleados' => array(),
		'dias' => array(),
		'total_dias' => 0,
		'total_horas' => 0,
		'total_horas_extra' => 0,
		'total_prestamos' => 0,
		'total_descuentos' => 0
		];

		for($i = 1; $i <= 7; $i++){ //obtener el dia del mes en el que cae cada dia de la semana
			$fecha = new DateTime();
			$fecha->setISODate($year,$semana,$i);
			$reporte['dias'][$i]['dia'] = $fecha->format('d');
			$reporte['dias'][$i]['personas'] = 0;
		}

		foreach($checadas as $checada){
			$empleado = EmpleadoCt::where('idEmpleadoCt', $checada->idEmpleadoCt)->first(); //obtener al empleado
			array_push($empleados, $empleado);
		}

		$empleados = array_unique($empleados); //eliminar empleados repetidos

		foreach($empleados as $empleado){
			$reporte['empleados'][$empleado->idEmpleadoCt] = [
			'ap_paterno' => $empleado->ap_paterno,
			'ap_materno' => $empleado->ap_materno,
			'nombre' => $empleado->nombres,
			'area' => AreaCt::where('idAreaCt', $empleado->area)->first()->nombre,
			'no_cuenta' => $empleado->no_cuenta,
			'checadas' => array(),
			'horas_extra' => 0,
			'horas_ordinarias' => 0,
			'descuentos' => 0,
			'prestamos' => 0];

			//obtener todas las checadas correspondientes al empleado
			for($i = 1; $i <= 7; $i++){ //agregar todas las checadas de la semana
				$fecha = new DateTime();
				$fecha->setISODate($year,$semana,$i);
				$fecha = $fecha->format('Y-m-d');
				$checadasDelDia = ChecadaCt::where('fecha',$fecha)->where('idEmpleadoCt',$empleado->idEmpleadoCt)->get();
				//generar nueva checada que no se guarda en BD pero se envia a la vista
				$checadaDelDia = new ChecadaCt([
					'idEmpleadoCt' => $empleado->idEmpleadoCt,
					'fecha' => $fecha,]);

				//obtener los descuentos y prestamos de cada empleado
				$descuentos = DescuentoCt::where('empleado',$empleado->idEmpleadoCt)->where('fecha',$fecha)->get();
				foreach($descuentos as $descuento){
					$reporte['empleados'][$empleado->idEmpleadoCt]['descuentos'] += $descuento->monto;
					$reporte['total_descuentos'] += $descuento->monto;
				}

				$prestamos = Prestamo::where('empleado',$empleado->idEmpleadoCt)->where('fecha',$fecha)->get();
				foreach($prestamos as $prestamo){
					$reporte['empleados'][$empleado->idEmpleadoCt]['prestamos'] += $prestamo->monto;
					$reporte['total_prestamos'] += $prestamo->monto;
				}
				
				//sumarle las horas de todas las checadas de ese dia
				foreach($checadasDelDia as $ch){
					$checadaDelDia->hora_entrada += $ch->hora_entrada;
					$checadaDelDia->hora_salida += $ch->hora_salida;
					$checadaDelDia->horas_ordinarias += $ch->horas_ordinarias;
					$checadaDelDia->horas_extra += $ch->horas_extra;
				}

				//enviar un valor nulo si no nhay checada en ese dia
				if(ChecadaCt::where('fecha',$fecha)->where('idEmpleadoCt',$empleado->idEmpleadoCt)->first() == null){
					$checadaDelDia = null;
				}

				$reporte['empleados'][$empleado->idEmpleadoCt]['checadas'][$i] = $checadaDelDia;

				//sumar las horas trabajadas por cada checada
				if($checadaDelDia != null){
					$reporte['empleados'][$empleado->idEmpleadoCt]['horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['empleados'][$empleado->idEmpleadoCt]['horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['dias'][$i]['personas'] += 1;
					$reporte['total_horas'] += $checadaDelDia->horas_ordinarias;
					$reporte['total_horas_extra'] =+ $checadaDelDia->horas_extra;
				}
			}
		}

		$empleados = EmpleadoCt::all();
		$parametros = ['empleados' => $empleados, "reporte" => $reporte, 'semana' => $request->input('semana'), 'fecha1' => $fecha1, 'fecha2' => $fecha2];
		return view('empleados_ct/reporte_ct')->with('parametros',$parametros);
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
	public function destroy($id)
	{
		//
                $checada = ChecadaCt::find($id);
                $checada->delete();
                return redirect()->route('buscar_checada_ct');
	}

	public function confirmar($id)
	{
		//
                $checada = ChecadaCt::find($id);
                return view('empleados_ct/confirmar_eliminar_checada')->with('checada',$checada);
	}

}