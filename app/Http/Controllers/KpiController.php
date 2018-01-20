<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\LogroKpi;
use App\Modelos\FormatoKpi;
use App\Modelos\AreaKpi;

class KpiController extends Controller {

	//función para mostrar la vista donde se hara la captura por área de KPI
	public function registro_kpi_get(){

		$areas = AreaKpi::all();

		return view('kpi/registro_kpi')->with('areas',$areas);
	}
	//función para guardar los cambios utilizando AJAX
	public function registro_kpi_ajax(Request $request){
		//Obteniendo los campos enviados
		$tabla = $request->input('tabla');
		$semana = $request->input('semana');
		$year = $request->input('year');
		$area = $request->input('area');
		/*se busca en la tabla logro_kpi si ya hay un registro en la 
		semana, año y área especificados*/
		$kpi = LogroKpi::where('semana',$semana)->where('year',$year)->where('area',$area)->first();
		/*se verifica si se obtuvo algún resultado*/
		if($kpi != null){
			/*Si se obtuvo resultado entonces se sustituye la tabla
			existente por la nueva tabla con los nuevos datos*/
			$kpi->tabla = $tabla;
			
		}else {
			/*si no se obtuvo resultado, entonces se crea un nuevo registro
			con los parametros enviados*/
			$kpi = new LogroKpi([
				'tabla' => $tabla,
				'semana' => $semana,
				'year' => $year,
				'area' => $area
			]);
		}
		//se guardan los cambios
		$kpi->save();
		/*se retorna el valor true en formato json para ser evaluado
		en la funcion AJAX*/
		return json_encode(true);
	}

	//Funcion para obtener el formato cumpliendo con los párametros especificados
	public function obtener_tabla_ajax(Request $request){
		//Obteniendo los campos enviados
		$semana = $request->input('semana');
		$year = $request->input('year');
		$area = $request->input('area');
		/*se busca en la tabla logro_kpi si ya hay un registro en la 
		semana, año y área especificados*/
		$kpi = LogroKpi::where('semana',$semana)->where('year',$year)->where('area',$area)->first();
		/*se verifica si se obtuvo algún resultado*/
		if($kpi != null){
			/*Si se obtuvo resultado entonces se obtiene la tabla
			existente y se almacena en $tabla*/
			$tabla = $kpi->tabla;
		}else{
			/*si no se obtuvo resultado, entonces se busca el formato
			general del área especificada*/
			$formato = FormatoKpi::where('area',$area)->first();
			/*se verifica si se obtuvo algún resultado*/
			if($formato != null){
				//si se obtuvo se almacena la tabla
				$tabla = $formato->tabla;
			}else{
				/*si no se obtuvo, se almacena null para ser procesado 
				en la funcion AJAX*/
				$tabla = null;
			}
		}
		//se devuelve el valor de la variable $tabla
		return json_encode($tabla);
	}
	//funcion que muestra la vista para actualizar el formato de KPI
	public function actualizar_formato_get(){

		$areas = AreaKpi::all();

		return view('kpi/alta_formato')->with('areas',$areas);
	}
	/*función que almacena los cambios en el formato enviados
	enviados por Ajax*/
	public function actualizar_formato_ajax(Request $request){
		//Se obtienen los parametros enviados
		$tabla = $request->input('tabla');
		$area = $request->input('area');
		//Se busca el formato correspondiente al área
		$formato = FormatoKpi::where('area',$area)->first();
		//se evalua que exista el formato para evitar error 5000
		if($formato != null){
			//se asigna la tabla actualizada al valor actual en la BD
			$formato->tabla = $tabla;
			//Se almacenan los cambios
			$formato->save();
		}
		//se devuelve tru para ser procesado en la función Ajax
		return json_encode(true);
	}

}