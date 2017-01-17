<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Turno;
use Auth;
use App\Requerimiento;
use DateTime;
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

			$info = ['clientes' => $clientes];
			return view('clientes/requerimiento')->with('info',$info);
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
			$info = ['clientes' => $clientes];
			return view('clientes/requerimiento')->with('info',$info);
		}
			
	}


	public function requerimiento_post(Request $request)
	{
		//
		if(Auth::guest())
				return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador']))
		{
			$fecha = new DateTime($request->input('fecha_ingreso'));
			$requerimiento = new Requerimiento([

					'requerimiento' => $request->input('requerimiento'),
					'ingreso' => $request->input('ingreso'),
					'fecha_ingreso' => $fecha,
					'semana' => $fecha->format('W'),
					'idcliente' => $request->input('cliente'),
					'idusuario' => Auth::user()->id

				]);

			$requerimiento->save();

			return redirect()->route('requerimiento')->withInput()->with('mensaje','Registro exitoso');

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
