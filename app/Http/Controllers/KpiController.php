<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\AreaCt;
use App\tipoKpi;
use App\logro;
use DateTime;
use DateInterval;
class KpiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function alta_tipoKpi_get()
	{
		$areas = AreaCt::all();
		return view('kpi/alta_tipoKpi')->with('areas',$areas);
	}

	public function alta_tipoKpi_post(Request $request)
	{
		$tipoKpi = new tipoKpi([
				'nombre' => strtoupper($request->input('nombre')),
				'unidad' => strtoupper( $request->input('unidad')),
				'pk_idAreaCt' => $request->input('area'),
				]);
		$tipoKpi->save();

		return redirect('kpi/alta/tipo')->with('success','Guardado exitosamente!');
	}

	public function alta_logro_get()
	{	
		$areas = AreaCt::all();
		return view('kpi/alta_logro')->with('areas',$areas);
	}

	public function alta_logro_post(Request $request)
	{
		$fecha = new DateTime($request->input('fecha'));

		$logro = new logro([
				'plan' => $request->input('plan'),
				'actual' => $request->input('actual'),
				'fecha' => $fecha,
				'semana' => $fecha->format('W'),
				'pk_idTipoKpi' => $request->input('tipo')
			]);

		$logro->save();

		return redirect('kpi/alta/logro')->with('success','Guardado exitosamente!');
	}

	public function obtener_tipoKpi_ajax(Request $request)
	{
		if($request->ajax()){
			$tipos = tipoKpi::where('pk_idAreaCt',$request->input('id'))->get();
			return json_encode($tipos);
		}else{
			return response('No autorizado.', 401);
		}	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function reporte_get()
	{
		$areas = AreaCt::all();
		return view('kpi/reporte')->with('areas',$areas);
	}

	
	public function reporte_post(Request $request)
	{
		
			$area = $request->input('area');
			$forma = $request->input('por');

			//queryFechas se encarga de delimitar el periodo de tiempo
			if($forma == 'semana')
				$queryFechas = "semana = '" . $request->input('valor') . "'";

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


			$queryFechas = "fecha BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			else {//año
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				$year = $request->input('valor');

				$fecha1->setDate($year,1,1); //primer dia del año
				$fecha2->setDate($year,12,31); //ultimo dia del año
				
				$queryFechas = "fecha BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			$logros = 0;
			$resultados = array();
			$tiposKpi = tipoKpi::where('pk_idAreaCt',$area)->get();
			foreach ($tiposKpi as $kpi) {
				$queryArea = " AND pk_idTipoKpi = '" . $kpi->idTipoKpi . "'"; 
				$result['tipo_kpi'] = $kpi->nombre;
				$result['unidad'] = $kpi->unidad;
				$result['logros'] = logro::whereRaw($queryFechas.$queryArea)->orderBy('fecha')->get();
				
				
				array_push($resultados, $result);
			}
			/*$result['plan'] = logro::whereRaw($queryFechas.$queryArea)->avg('actual');
				$result['actual'] = logro::whereRaw($queryFechas.$queryArea)->avg('actual');*/
				//$logros = $result['actual'];


			 
			return redirect('kpi/reporte')->with('resultados', $resultados);
		
	}

	

}
