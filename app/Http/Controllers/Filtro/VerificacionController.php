<?php namespace App\Http\Controllers\Filtro;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\ExamenMedico;
use Auth;

use Illuminate\Http\Request;

class VerificacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','filtro','recepcion']))
			return view('filtro/verificarProspecto');

		else
			return view('errors/restringido');
	}

	public function verificar(Request $request){
		//obtener el texto ingresado y separarlo en un array, en el que cada elemento es una curp diferente
		$curps = $request->input('curp');
		//eliminar cualquier espacio blanco en el string
		$curps = preg_replace('/\s+/', '',$curps);
		//remover comas al principio e inicio del string, si las hay
		$curps = trim($curps,',');
		//separar el string en un array, utilizando comas como el separador
		$curps = explode(',',$curps);
		//crear un array para almacenar los prospectos encontrados

		$curps = array_unique($curps); // eliminar entradas repetidas

		$prospectos = array();

		//iterrar entre las curps ingresadas
		foreach($curps as $curp){
			//guardar cada prospecto como un array
			$prospecto = array();
			//buscar al empleado con base en la curp
			$empleado = Empleado::where('curp',$curp)->first();
			//si no se encontro ningun empleado con esa curp:
			if($empleado === null){
				$prospecto['nombre'] = 'N/A';
				$prospecto['curp'] = strtoupper($curp);
				$prospecto['estado'] = 'N/A';
				$prospecto['observacion'] = 'No registrado';
			}
			//si se encontro al empleado:
			else{
				$prospecto['nombre'] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;
				$prospecto['curp'] = strtoupper($empleado->curp);
				if($empleado->estado == 'candidato') $prospecto['estado'] = 'Candidato';
				else $prospecto['estado'] = 'Empleado';
				if($empleado->contratable) $prospecto['observacion'] = "Puede trabajar";
				else {
					$prospecto['observacion'] = "Lista negra";
					$prospecto['estado'] = 'No Contratable';
				}

				//buscar el registro medico
				$examen = ExamenMedico::where('empleado',$empleado->idEmpleado)->orderBy('created_at','desc')->first();

				//si no se encontro el examen medico:
				if($examen === null) $prospecto['observacion'] = "No ha presentado examen médico";
				//si no aprobo el examen medico:
				elseif(!$examen->aprobado) $prospecto['observacion'] = "No aprobó el examen médico";
			}
			//guardar el prospecto encontrado al array con los demas prospectos
			array_push($prospectos, $prospecto);
		}

		//enviar a la vista
		return view('filtro/verificarProspecto')->with('prospectos',$prospectos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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

    public function search(Request $request){
     	
        
    }

}
