<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Turno;
use Auth;
use DateTime;
use DateInterval;
use App\Requerimiento;
use Illuminate\Http\Request;

class ClienteController extends Controller {

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
		//
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){
			return view('clientes/agregar_cliente');
			$clientes = Cliente::all();
			$info = ['clientes' => $clientes];
			return view('clientes/requerimiento')->with('info',$info);

		}
		
		else 
			return view('errors/restringido');
	}

	public function mostrarTodos(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){			
			$clientes = Cliente::all();
			return view('lista_clientes')->with('clientes',$clientes);

			
		}

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
		$cliente = new Cliente([
			'nombre' => $request->input('nombre'),
			'telefono' => $request->input('telefono'),
			'contacto' => $request->input('contacto'),
			'direccion' => $request->input('direccion')
			]);

		if(Cliente::where('nombre',$cliente->nombre)->first() == null){
			$cliente->save();

		//buscar el cliente que fue guardado en la base de datos para obtener su id recien asignado
			$cliente = Cliente::where('nombre', $cliente->nombre)->first();

			$turno = new Turno([
				'idCliente' => $cliente->idCliente,
				'hora_entrada' => $request->input('hora_entrada'),
				'hora_salida' => $request->input('hora_salida'),
				'horas_trabajadas' => $request->input('horas_trabajadas')
				]);

			$turno->save();

			return redirect()->route('mostrar_clientes');
		}

		else
			return redirect()->route('mostrar_clientes')->withInput()->with('mensaje','Ya existe un cliente con ese nombre');
	}

	public function editar($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){
			$cliente = Cliente::where('idCliente', $id)->first();
			return view('clientes/modificar')->with('cliente',$cliente);
		}

		else
			return view('errors/restringido');
	}

	//marca un error al asignar los valores actualizados
	public function actualizar($id, Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){
			$cliente = Cliente::find($request->input('idCliente'));

			$cliente->telefono = $request->input('telefono');
			$cliente->contacto = $request->input('contacto');

			$cliente->save();

			return redirect()->route('mostrar_clientes');
		}

		else
			return view('errors/restringido');
	}

	//muestra los turnos asociados al cliente seleccionado, y permite agregar mas
	public function turnos($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){
			$turnos = Turno::where('idCliente',$id)->get();
			return view('clientes/turnos')->with('turnos',$turnos)->with('cliente',Cliente::where('idCliente',$id)->first());
		}

		else
			return view('errors/restringido');
	}

	public function agregarTurno($id, Request $request)
	{
		$cliente = Cliente::where('idCliente',$request->input('idCliente'))->first();

		$turno = new Turno([
			'idCliente' => $cliente->idCliente,
			'hora_entrada' => $request->input('hora_entrada'),
			'hora_salida' => $request->input('hora_salida'),
			'horas_trabajadas' => $request->input('horas_trabajadas')
			]);

		$turno->save();

		return redirect()->route('turnos',$id);
	}


	//mismo error que habia para eliminar empleados
	public function eliminarTurno($idTurno)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){
			$turno = Turno::find($idTurno);
			$cliente = Cliente::find($turno->idCliente); //para regresar a la vista anterior
			$turno->delete();

			return redirect()->route('turnos',$cliente->idCliente);
		}

		else
			return view('errors/restringido');
	}

	##Metodo get para traer lista desplegable de clientes y dirigir a la vista
	public function requerimiento_get()
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){

			$clientes = Cliente::all();
			$turnos = Turno::all();
			$info = ['clientes'=>$clientes, 'turnos'=>$turnos];
			return view('clientes/requerimiento')->with('info',$info);
		}
			
	}

	##Metodo POST para guardar los datos que se ingresaron en el formulario,una vez echo el registro,regresa a la vista
	public function requerimiento_post(Request $request)
	{
		
		if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor','contabilidad']))
		{
			$cliente = Cliente::where('idCliente',$request->input('cliente'))->first();
			$turno = Turno::where('idTurno',$request->input('turno'))->first();
			$fecha = new DateTime($request->input('fecha_ingreso'));
			$requerimiento = new Requerimiento([

				'idcliente' => $request->input('cliente'),
				'idturno' => $request->input('turno'),
				'fecha_ingreso' => $request->input('fecha_ingreso'),
				'requerimiento' => $request->input('requerimiento'),
				'ingreso' => $request->input('ingreso'),
				'semana' => $fecha->format('W'),
				'idusuario' => Auth::user()->id	
				]);

			$requerimiento->save();

			return redirect()->route('requerimiento')->withInput()->with('mensaje','Registro exitoso');
		}

		else
			return view('errors/restringido');
	}

	
	//abrir la vista para reporte arrojando los clientes existentes
	public function buscarReporte()
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){
			$clientes = Cliente::all();
			$info = ['clientes' => $clientes];
			return view('clientes/reporte')->with('info',$info);
		}
	}
	
	//Con los parametros especificados muestra el resultado de la busqueda
	public function generarReporte(Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){

			// return view('proveedores/detalle_reporte');		
			$idcliente = $request->input('idcliente');
			$forma = $request->input('por');
			$semana = $request->input("valor");
			$year = new DateTime(); //en ingles para no sonar obsceno

			//Obtener la fecha en la que inicia y termina la semana seleccionada
			$fecha1 = new DateTime();
			$fecha1->setISODate($year->format('Y'),$semana,1);
			$fecha1 = $fecha1->format('Y-m-d');

			$fecha2 = new DateTime();
			$fecha2->setISODate($year->format('Y'),$semana,7);
			$fecha2 = $fecha2->format('Y-m-d');

			//declarar el query en formato SQL para cada uno de los parametros, como un string
			//el string siguiente seria "fecha BETWEEN CAST('{fecha1}' AS DATE) AND CAST('{fecha2}' AS DATE)"
			

			//queryFechas se encarga de delimitar el periodo de tiempo
			if($forma == 'semana')
				$queryFechas = "fecha_ingreso BETWEEN CAST('" . $fecha1 . "' AS DATE) AND CAST('" . $fecha2 . "' AS DATE)";

			elseif($forma == 'mes'){
				$fechaActual = new DateTime('now');
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				//el primer dia del mes dado
				$fecha1->setDate($fechaActual->format('Y'),$request->input('valor'),1); 
				
				//el primer dia del siguiente mes
				if($request->input('valor') == 12)
					//si es diciembre, tomar enero como el siguiente dia
					$fecha2 = setDate(($fechaActual->format('Y')+1), 1, 1);
				
				else
					$fecha2->setDate($fechaActual->format('Y'),($request->input('valor')+1),1); 

				//restar un dia a la segunda fecha para que sea el ultimo dia del mes
				$fecha2->sub(new DateInterval('P1D'));


			$queryFechas = "fecha_ingreso BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			else {//año
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				$year = $request->input('valor');

				$fecha1->setDate($year,1,1); //primer dia del año
				$fecha2->setDate($year,12,31); //ultimo dia del año
				
				$queryFechas = "fecha_ingreso BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			//si no especifica cliente, ignorar del query
			if($idcliente == 'todos'){
				$queryCliente = "";
			}

			else
				$queryCliente = " AND idcliente = '" . $request->input('cliente') . "'";

			$requerimientos = Requerimiento::whereRaw($queryFechas.$queryCliente)->	orderBy('fecha_ingreso')->get();


			$ingreso=0;
			
			foreach ($requerimientos as $requerimiento) {
				$ingreso += $requerimiento->ingreso;
			}
			
			$clientes = Cliente::all();
			$idcliente = Cliente::where('idcliente', $idcliente)->first();
			$info = ['clientes' => $clientes, 'requerimientos'=>$requerimientos]; //parametros para filtrar la busqueda
			return view('clientes/reporte')->with('info',$info);	
		}

		else
			return view('errors/restringido');
	}
	

	public function detalleReporte(Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor'])){

			// return view('proveedores/detalle_reporte');		
			$idcliente = $request->input('idcliente');
			$forma = $request->input('por');

			//queryFechas se encarga de delimitar el periodo de tiempo
			if($forma == 'fecha_ingreso')
				$queryFechas = "fecha_ingreso = '" . $request->input('valor') . "'";

			elseif($forma == 'mes'){
				$fechaActual = new DateTime('now');
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				//el primer dia del mes dado
				$fecha1->setDate($fechaActual->format('Y'),$request->input('valor'),1); 
				
				//el primer dia del siguiente mes
				if($request->input('valor') == 12)
					//si es diciembre, tomar enero como el siguiente dia
					$fecha2 = setDate(($fechaActual->format('Y')+1), 1, 1);
				
				else
					$fecha2->setDate($fechaActual->format('Y'),($request->input('valor')+1),1); 

				//restar un dia a la segunda fecha para que sea el ultimo dia del mes
				$fecha2->sub(new DateInterval('P1D'));


			$queryFechas = "fecha_ingreso BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			else {//año
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				$year = $request->input('valor');

				$fecha1->setDate($year,1,1); //primer dia del año
				$fecha2->setDate($year,12,31); //ultimo dia del año
				
				$queryFechas = "fecha_ingreso BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			//si no especifica cliente, ignorar del query
			if($idcliente == 'todos'){
				$queryCliente = "";
			}

			else
				$queryCliente = " AND idcliente = '" . $request->input('idcliente') . "'";

			$requerimientos = Requerimiento::whereRaw($queryFechas.$queryCliente)->	orderBy('fecha_ingreso')->get();


			$total_cargo=0;
			$total_abono=0;
			$total_saldo=0;
			
			
			$clientes = Cliente::all();
			$idcliente = Cliente::where('idcliente', $idcliente)->first();
			$info = ['clientes' => $clientes, 'requerimientos'=>$requerimientos,'total_abono'=>$total_abono, 'total_cargo'=>$total_cargo, 'total_saldo'=>$total_saldo]; //parametros para filtrar la busqueda
			return view('clientes/detalle_reporte')->with('info',$info);	
		}

		else
			return view('errors/restringido');
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
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){
			$cliente = Cliente::find($id);

			$turnos = Turno::where('idCliente', $cliente->idCliente)->get();
			foreach($turnos as $turno){
				$turno -> delete();
			}

			$cliente->delete();

			return redirect()->route('mostrar_clientes');
		}

		else
			return view('errors/restringido');

	}

}
