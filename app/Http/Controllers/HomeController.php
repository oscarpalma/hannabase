<?php namespace App\Http\Controllers;
use App\Empleado;
use App\Checada;
use DateTime;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//obtener la cantidad de nuevos empleados (registrados en la semana), total de candidatos, de empleados y en lista negra
		$fecha = new DateTime('now');
		$candidatos = count(Empleado::where('estado','candidato')->where('contratable',true)->get());
		$empleados = count(Empleado::where('estado','empleado')->where('contratable',true)->get());
		$nuevos = 0;
                $nuevosDia = 0;
		foreach(Empleado::where('contratable', true)->get() as $empleado){
			if($fecha->diff(new DateTime($empleado->created_at))->format('%a') <= 7) {
				$nuevos++;
			}
		}
                foreach(Empleado::where('contratable', true)->get() as $empleado){
			if($fecha->format('d-m-Y')==(new DateTime($empleado->created_at))->format('d-m-Y')) {
				$nuevosDia++;
			}
		}
		$listaNegra = count(Empleado::where('contratable',false)->get());
		$checadas = count(Checada::where('fecha', $fecha->format('Y-m-d'))->get());
		return view('home')->with('empleados',$empleados)->with('listaNegra', $listaNegra)->with('checadas',$checadas)->with('candidatos',$candidatos)->with('nuevos',$nuevos)->with('nuevosDia',$nuevosDia);
	}

}