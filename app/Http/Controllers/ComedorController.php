<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\Comedor;
use DateTime;
use Auth;

use Illuminate\Http\Request;

class ComedorController extends Controller {

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

		else if(in_array(Auth::user()->role, ['administrador','supervisor']))
			return view('empleados/comedores');

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
		//obtener numero de semana para validar

		$fecha = new DateTime($request->input('fecha'));

		if($fecha->format("W") != $request->input('semana')){
			return redirect()->route('comedores')->withInput()->with('message','La semana no coincide con la fecha ingresada');
		}

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
				'semana' => $request->input('semana'),
				'fecha' => $request->input('fecha'),
				'cantidad' => $request->input('cantidad')
				]);

			$comedor->save();
		}

		return redirect()->route('comedores')->withInput()->with('message','Descuentos de comedor guardados exitosamente');

	}
public function buscar()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad'])){
			//enviar parametros empleados, turnos y clientes para aplicar como filtros de busqueda (jquery?)
			$empleados = Empleado::where('contratable', true)->get();
			
			
				$parametros = ['empleados' => $empleados]; //parametros para filtrar la busqueda
			

			return view('empleados/buscar_comedores')->with('parametros', $parametros);
		}

		else 
			return view('errors/restringido');
	}

	public function mostrar(Request $request){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad'])){
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
			

			return view('empleados/buscar_comedores')->with('parametros', $parametros);
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
	public function destroy(Request $request)
	{
		$fecha = new DateTime();
		$fecha->setISODate($request->input('year'),$request->input('semana'),$request->input('dia'));
		foreach(Comedor::where('idEmpleado',$request->input('empleado'))->where('fecha', $fecha->format('Y-m-d'))->get() as $comedor){
			$comedorBorrar = Comedor::find($comedor->id);
			$comedorBorrar->delete();
		}

		return $this->mostrar($request);
	}

}