<?php namespace App\Http\Controllers;
use DateTime;
use App\Modelos\Empleado;
use App\Modelos\Checada;
use App\User;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
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
	 * Show the application welcome screen to the user.
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
		
		$fecha_actual = new DateTime();
    	$fechaInicioSemana = date('Y-m-d', strtotime($fecha_actual->format('Y') . 'W' . str_pad($fecha_actual->format('W') , 2, '0', STR_PAD_LEFT)));
        $fechas[1] = $fechaInicioSemana;
        $fechas[2] = date('Y-m-d', strtotime($fechaInicioSemana.' 1 day')); //Martes
		$fechas[3] = date('Y-m-d', strtotime($fechaInicioSemana.' 2 day')); //Miercoles
		$fechas[4] = date('Y-m-d', strtotime($fechaInicioSemana.' 3 day')); //Jueves
		$fechas[5] = date('Y-m-d', strtotime($fechaInicioSemana.' 4 day')); //Viernes
		$fechas[6] = date('Y-m-d', strtotime($fechaInicioSemana.' 5 day')); //Sabado
		$fechas[7] = date('Y-m-d', strtotime($fechaInicioSemana.' 6 day'));; //Domingo
        
        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

        $datos = array();
        for ($i=1; $i < 8; $i++) { 
        	$registros = Empleado::whereRaw("CAST( created_at AS DATE) = '". $fechas[$i]."'")->count();
        	//$registros =10;
        	array_push($datos, ["y"=>$dias[$i-1],"a"=> $registros]);
        }

		return view('index')->with('empleados',$empleados)->with('listaNegra', $listaNegra)->with('checadas',$checadas)->with('candidatos',$candidatos)->with('nuevos',$nuevos)->with('nuevosDia',$nuevosDia)->with('datos',$datos);
	}

	public function registros_mes($anio,$mes)
    {	
    	$fecha_actual = new DateTime();
    	$fechaInicioSemana = date('d-m-Y', strtotime($fecha_actual->format('Y') . 'W' . str_pad($fecha_actual->format('W') , 2, '0', STR_PAD_LEFT)));
        $fechas[1] = $fechaInicioSemana;
        $fechas[2] = date('Y-m-d', strtotime($fechaInicioSemana.' 1 day')); //Martes
		$fechas[3] = date('Y-m-d', strtotime($fechaInicioSemana.' 2 day')); //Miercoles
		$fechas[4] = date('Y-m-d', strtotime($fechaInicioSemana.' 3 day')); //Jueves
		$fechas[5] = date('Y-m-d', strtotime($fechaInicioSemana.' 4 day')); //Viernes
		$fechas[6] = date('Y-m-d', strtotime($fechaInicioSemana.' 5 day')); //Sabado
		$fechas[7] = date('Y-m-d', strtotime($fechaInicioSemana.' 6 day'));; //Domingo
        
        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

        $datos = array();
        for ($i=1; $i < 8; $i++) { 
        	$registros = User::whereRaw('CAST( created_at AS DATE) = '. $fechas[$i])->count();
        	array_push($datos, ["y"=>$dias[$i],"a"=> $registros]);
        }
        //$primer_dia=($fecha_actual->format('d'))-7;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );
        $usuarios=User::whereBetween('created_at', [$fecha_inicial,  $fecha_final])->get();
        $ct=count($usuarios);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;     
        }

        foreach($usuarios as $usuario){
        $diasel=date("d",strtotime($usuario->created_at) );
        $registros[$diasel]++;    
        }

        $data=array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);
        return   json_encode($data);
    }

}
