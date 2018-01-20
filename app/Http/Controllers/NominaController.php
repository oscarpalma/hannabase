<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Empleado;
use App\Modelos\Checada;
use App\Modelos\Descuento;
use App\Modelos\Cliente;
use App\Modelos\Turno;
use App\Modelos\Comedor;
use App\Modelos\Reembolso;
use App\Modelos\TipoDescuento;
use DateTime;
use Auth;

class NominaController extends Controller {

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
		     return view('nomina/indicadores');

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