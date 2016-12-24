<?php namespace App\Http\Controllers\Filtro;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\ExamenMedico;
use Auth;

use Illuminate\Http\Request;

class ExaMediController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','enfermeria'])){
			$empleados = array();
			foreach(Empleado::where('contratable',true)->get() as $empleado){
				if(ExamenMedico::where('empleado',$empleado->idEmpleado)->first() == null)
					array_push($empleados, $empleado);
			}
			return view('filtro/examenMedico')->with('empleados',$empleados);
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
		//
		$empleado = Empleado::find($request->input('idEmpleado'));
		$examen = new ExamenMedico([
			//almacenar los comentarios
			'empleado'   => $empleado->idEmpleado,
			'antidoping_comentario' => $request->input('antidoping_comentario'),
			'embarazo_comentario'   => $request->input('embarazo_comentario'),
			'vista_comentario'      => $request->input('vista_comentario'),
			'enfermedad_comentario' => $request->input('enfermedad_comentario'),
			]);

		//revisa manualmente el valor enviado por el checkbox para guardar el valor booleano correspondiente
		if($request->input('antidoping') == 'true') $examen->antidoping = true;
		else $examen->antidoping = false;

		if($request->input('embarazo') == 'true') $examen->embarazo = true;
		else $examen->embarazo = false;

		if($request->input('vista') == 'true') $examen->vista = true;
		else $examen->vista = false;

		if($request->input('enfermedad') == 'true') $examen->enfermedad = true;
		else $examen->enfermedad = false;

		if($request->input('aprobado') == 'true') $examen->aprobado = true;
		else $examen->aprobado = false;

		$examen->save();
		return redirect()->route('filtro_examen_medico')->withInput()->with('success','Datos médicos registrados con éxito');
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
	}

}
