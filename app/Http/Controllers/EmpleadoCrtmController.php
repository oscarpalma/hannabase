<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modelos\Estado;
use App\Modelos\Colonia;
use App\Modelos\AreaCrtm;
use App\Modelos\DatosLocalizacionCrtm;
use App\Modelos\EmpleadoCrtm;
use App\Modelos\DescuentoCrtm;
use App\Modelos\Prestamo;
use Validator;
use App;

use App\Modelos\ChecadaCrtm;
use App\Modelos\DirectorioPersonal;
use App\Modelos\DirectorioSucursal;
use DateTime;
use Auth;

use Illuminate\Http\Request;

class EmpleadoCrtmController extends Controller {

	

	public function alta_get()
	{
			$estados = Estado::all();
			$colonias= Colonia::where('idColonia','>',0)->orderBy('nombre')->get();
			$areas = AreaCrtm::all();
		    return view('empleados_directos/alta_empleado')->with('estados',$estados)->with('colonias',$colonias)->with('areas',$areas);
		
	}

	public function alta_post(Request $request)
	{
		//Obtener la información del formulario del apartado de datos Personales
			$nombre = mb_strtoupper($request->input('nombres'));
			$paterno = mb_strtoupper($request->input('ap_paterno'));
			$materno= mb_strtoupper($request->input('ap_materno'));
			$fecha_nacimiento = (string)$request->input('fecha_nacimiento');
			$dia= $fecha_nacimiento[8] .$fecha_nacimiento[9];
			$mes = $fecha_nacimiento[5] . $fecha_nacimiento[6];
			$anio = $fecha_nacimiento[0] . $fecha_nacimiento[1] . $fecha_nacimiento[2] . $fecha_nacimiento[3];
			$curp = strtoupper($request->input('curp'));
			$imss = $request->input('imss');
			$genero = $request->input('genero');
			$area = $request->input('area');
			$cuenta = $request->input('no_cuenta');

		$validarCurp = new CURP();
		$validator = Validator::make([
			'curp' => $curp,
			'imss' => $imss,
			'no_cuenta' => $cuenta],

			[
			'imss' => 'unique:empleados_crtm,imss',
			'curp' => 'unique:empleados_crtm,curp',
			'no_cuenta' => 'unique:empleados_crtm,no_cuenta'
			]);

		//Validar que los campos no se encuentren repetidos
		if($validator->fails() && $validator->messages()->has('curp')){
				$errores['nombre'] = 'El empleado ya existe en la base de datos';
			
			
		}else{
			if($validator->fails() && $validator->messages()->has('no_cuenta') && $cuenta!=""){
				$errores['no_cuenta'] = 'El No. de cuenta ya se encuentra asignado a otro empleado';
			}
			if($validator->fails() && $validator->messages()->has('imss')){
				$errores['imss'] = 'El No. de IMSS ya se encuentra asignado a otro empleado';
			}
		}
		if($validator->fails()){
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}else{

			if(!$validarCurp->validar($request, $validarCurp->generar($request)) || strlen($curp) != 18){
			$errores['curp'] = 'La CURP otorgada no es valida';
			}
			if($imss != ""){
				if($fecha_nacimiento[2].$fecha_nacimiento[3] != $imss[4].$imss[5]){
					$errores['imss'] = 'El número del IMSS ingresado no coincide con los datos del empleado';
				}
			}
			if(!empty($errores))
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
			else{

			$estado = Estado::find($request->input('id_estados'));
			$empleado = new EmpleadoCrtm([
				'nombres' => $nombre,
				'ap_paterno' => $paterno,
				'curp' => $curp,
				'imss' => $imss,
				'genero' => $genero,
				'idestado' => $estado->id_estados,
				'fecha_nacimiento' => $fecha_nacimiento,
				'area' => $area,
				]);
			//Poner en null el apellido materno en caso de estar vacio
			if($materno == ""){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = $materno;
			}
			//Poner en null la cuenta en caso de estar vacio
			if($cuenta == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $cuenta;
			}
		
			//Poner en null campo de IMSS en caso de no ser agregado

			if($imss == "")
				$empleado->imss = null;

			else
				$empleado->imss = $imss;
			
						
			//Si todo se valido correctamente entonces guardamos el empleado
			$empleado->save();

			$colonia = Colonia::find($request->input('idColonia'));
			$DatosLocalizacionCrtm = new DatosLocalizacionCrtm([
				'tel_casa'        => $request->input('tel_casa'),
				'tel_cel'         => $request->input('tel_cel'),
				'calle'           => $request->input('calle'),
				'no_interior'     => $request->input('no_interior'),
				'no_exterior'     => $request->input('no_exterior'),
				'idColonia'       => $colonia->idColonia,
				'idEmpleado'      => $empleado->idEmpleado,
				'nombre_contacto' => $request->input('nombre_contacto'),
				'tel_contacto'    => $request->input('tel_contacto'),
				'tipo_parentesco' => $request->input('tipo_parentesco')
				]);

			$DatosLocalizacionCrtm->save();

			return redirect()->route('registro_empleado_crtm')->with('success',$empleado->idEmpleado);
		}

		}
	}

	public function lista_get(){
			$empleados = EmpleadoCrtm::all();
			
			return view('empleados_directos/lista_empleados')->with('empleados',$empleados);
		
	}

	public function datos_ajax(Request $request){
		
		if($request->ajax()){
			$empleado = EmpleadoCrtm::find($request->input('id'));
	        $datos['nombre']=$empleado->ap_paterno." ".$empleado->ap_materno." ".$empleado->nombres;
	        $datos['id']=$empleado->idEmpleado;
	        $fecha= new DateTime($empleado->fecha_nacimiento);
	        $datos['fecha']=$fecha->format('d-m-Y');
	        $datos['curp']=$empleado->curp;
	        $datos['imss']=$empleado->imss;
	        $datos['cuenta']=$empleado->no_cuenta;
	        if($empleado->foto!=null)
	        	$datos['foto']="/storage/fotos/crtm/".$empleado->foto;
	        else
	        	$datos['foto']=null;
	        
	        //Obtener area
	        $area=AreaCrtm::find($empleado->area);
	        $datos['area']=$area->nombre;
	        //Obtener nombre de estado
	        $idestado=$empleado->idestado;
	        $estado = Estado::find($idestado);
	        $datos['estado']=$estado->nombre;
	        //Obtener datos de localización
	        $DatosLocalizacionCrtm = DatosLocalizacionCrtm::where('idEmpleado',$empleado->idEmpleado)->first();
	    	$datos['telefono']=$DatosLocalizacionCrtm->tel_casa." ".$DatosLocalizacionCrtm->tel_cel;
	    	$colonia=Colonia::find($DatosLocalizacionCrtm->idColonia);
	    	$datos['direccion']=strtoupper($DatosLocalizacionCrtm->calle." ".$DatosLocalizacionCrtm->no_exterior." ".$DatosLocalizacionCrtm->no_interior." ".$colonia->nombre);
	    	$datos['contacto']="Llamar a ".ucwords($DatosLocalizacionCrtm->nombre_contacto)." al telefono ".$DatosLocalizacionCrtm->tel_contacto;
	    return json_encode($datos);
    }
    return json_encode(false);
	}

	public function baja_ajax(Request $request){
		if($request->ajax()){
			foreach ($request->input('id') as $id) {
			$empleado = EmpleadoCrtm::find($id);
	        $empleado->delete();
	    }
    	return json_encode(true);
    	}
      		return json_encode(false);  
	}

	public function alta_checada_get(){

			$empleados = EmpleadoCrtm::all();
			
			return view('empleados_directos/alta_checada')->with('empleados',$empleados);
		
	}

	public function checada_post_ajax(Request $request){
		if($request->ajax()){
			$empleado = EmpleadoCrtm::where('idEmpleado',$request->input('empleado'))->first();

			if($this->validarHorarios($request, $empleado)){
				$user = Auth::user();
				$checada = new ChecadaCrtm([
					
					'idEmpleado' => $empleado->idEmpleado,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada'),
					'hora_salida' => $request->input('hora_salida'),
					'horas_ordinarias' => $request->input('horas_ordinarias'),
					'horas_extra' => $request->input('horas_extra'),
					'comentarios' => $request->input('comentarios'),
					'idUsuario' => $user->id
					]);
				if($request->input('incidencia') == "xx"){
					$checada->incidencia = null;
				}
				if($request->input('incidencia') == "falta_justificada"){
					$checada->incidencia = 'falta justificada';
				}
				if($request->input('incidencia') == "falta_injustificada"){
					$checada->incidencia = 'falta injustificada';
				}
				if($request->input('incidencia') == "permiso"){
					$checada->incidencia = 'permiso';
				}

				$checada->save();

				if($request->input('hora_entrada2') != "" && $request->input('hora_salida2') != "" && $request->input('horas_ordinarias2') != ""){
					$checada = new ChecadaCrtm([
					
					'idEmpleado' => $empleado->idEmpleado,
					'fecha' => $request->input('fecha'),
					'hora_entrada' => $request->input('hora_entrada2'),
					'hora_salida' => $request->input('hora_salida2'),
					'horas_ordinarias' => $request->input('horas_ordinarias2'),
					'horas_extra' => $request->input('horas_extra2'),
					'comentarios' => $request->input('comentarios'),
					'idUsuario' => $user->id
					]);
				if($request->input('incidencia') == "xx"){
					$checada->incidencia = null;
				}
				if($request->input('incidencia') == "falta_justificada"){
					$checada->incidencia = 'falta justificada';
				}
				if($request->input('incidencia') == "falta_injustificada"){
					$checada->incidencia = 'falta injustificada';
				}
				if($request->input('incidencia') == "permiso"){
					$checada->incidencia = 'permiso';
				}

				$checada->save();
				}
				return json_encode(true);
			}

			else{
				return json_encode(false);
			}
		}
	}



//verificar que el empleado no este trabajando en un horario dado
	public function validarHorarios(Request $request, $empleado)
	{
		//validar si existe una checada en esa fecha
		$ch = ChecadaCrtm::where('idEmpleado',$empleado->idEmpleado)->where('fecha',$request->input('fecha'))->first();
		if($ch != null){ //si hay una checada en esa fecha
			//validar si el turno empieza y termina en otro dia

			if($request->input('hora_salida') < $request->input('hora_entrada')){ //si termina el dia siguiente
				//solo validar hora salida guardada con la de entrada enviada

				if(!$ch->hora_entrada > $ch->hora_salida){ //verificar si la checada registrada no termina el dia siguiente

					//solo se necesita saber si la salida registrada es antes que la entrada enviada
					if($ch->hora_salida > $request->input('hora_entrada')){
						return false;
					}
					else{
						return true;
					}
				}

				else{ //si la checada guardada y la enviada terminan el dia siguiente

					//la validacion es igual que si terminan el mismo dia
					if(($request->input('hora_entrada') < $ch->hora_entrada && $request->input('hora_salida') <= $ch->hora_entrada) || ($request->input('hora_entrada') >= $ch->hora_salida && $request->input('hora_salida') > $ch->hora_salida)){
						return true;
					}

					else{
						return false;
					}			
				}
			}

			else{ //si el turno termina el mismo dia
				if(($request->input('hora_entrada') < $ch->hora_entrada && $request->input('hora_salida') <= $ch->hora_entrada) || ($request->input('hora_entrada') >= $ch->hora_salida && $request->input('hora_salida') > $ch->hora_salida)){
					return true;
				}

				else{
					return false;
				}
			}
		}

		else {
			return true;
		}
	}
	
	public function alta_checadaG_get(){

			$empleados = EmpleadoCrtm::all();

			                                   
			return view('empleados_directos/alta_checadaG')->with('empleados',$empleados);
		
	}

	public function verificar_ajax(Request $request){
		if($request->ajax()){
			//obtener los id de empleado ingresados
			$ids = $request->input('empleados');
			//eliminar cualquier espacio blanco en el string
			$ids = preg_replace('/\s+/', '',$ids);
			//remover comas al principio e inicio del string, si las hay
			$ids = trim($ids,',');
			//separar el string en un array, utilizando comas como el separador
			$ids = explode(',',$ids);

			$ids = array_unique($ids); //remover entradas repetidas
			
			$informacion = array();
			foreach($ids as $id){
				
				$empleado = EmpleadoCrtm::where('idEmpleado',$id)->first();
				$info['id'] = $id;
				$nombre = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;
				$info['nombre'] = $nombre;
				$info['curp'] = $empleado->curp;
				$area = AreaCrtm::find($empleado->area);
				$info['area'] = ucwords($area->nombre);
				array_push($informacion, $info);
			}
			return json_encode($informacion);

		}
	}

	public function checadaG_post_ajax(Request $request){
		if($request->ajax()){
			//obtener el id del usuario del sistema actual
			$user = Auth::user(); //reemplazar posteriormente con el id del usuario actual

			//obtener los id de empleado ingresados
			$ids = $request->input('empleados');
			//eliminar cualquier espacio blanco en el string
			$ids = preg_replace('/\s+/', '',$ids);
			//remover comas al principio e inicio del string, si las hay
			$ids = trim($ids,',');
			//separar el string en un array, utilizando comas como el separador
			$ids = explode(',',$ids);

			$ids = array_unique($ids); //remover entradas repetidas
			$i=0;
			$errores=0;
			//realizar el proceso de guardado de checada para cada uno de los ids ingresados
			foreach($ids as $id){
				$empleado = EmpleadoCrtm::where('idEmpleado',$id)->first();
				if($empleado === null) continue;

				if($this->validarHorarios($request, $empleado)){
					$checada = new ChecadaCrtm([
						'idEmpleado' => $empleado->idEmpleado,
						'fecha' => $request->input('fecha'),
						'hora_entrada' => $request->input('hora_entrada'),
						'hora_salida' => $request->input('hora_salida'),
						'horas_ordinarias' => $request->input('horas_ordinarias'),
						'horas_extra' => $request->input('horas_extra'),
						'comentarios' => $request->input('comentarios'),
						'idUsuario' => $user->id
						]);
					if($request->input('incidencia') == "xx"){
						$checada->incidencia = null;
					}
					if($request->input('incidencia') == "falta_justificada"){
						$checada->incidencia = 'falta justificada';
					}
					if($request->input('incidencia') == "falta_injustificada"){
						$checada->incidencia = 'falta injustificada';
					}
					if($request->input('incidencia') == "permiso"){
						$checada->incidencia = 'permiso';
					}
					$checada->save();
					$i++;
				}
			}return json_encode($i);
		}

	}

	public function reporte_get()
	{
			$empleados = EmpleadoCrtm::all();

			$parametros = ['empleados' => $empleados]; //parametros para filtrar la busqueda
			return view('empleados_directos/reporte')->with('parametros', $parametros);
		
	}

	public function reporte_post(Request $request)
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

		//crear el query para el numero de empleado y designar la etiqueta del filtro
		if($request->input('empleado') == 'null') $queryEmpleado = ""; //string vacio si no se define un empleado
		else {
			$empleado = EmpleadoCrtm::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') . "'";
		}

		$query = $queryFechas . $queryEmpleado;

		$checadas = ChecadaCrtm::whereRaw($query)->get();

		$empleados = array();

		$reporte = [
		'empleados' => array(),
		'dias' => array(),
		'total_dias' => 0,
		'total_horas' => 0,
		'total_horas_extra' => 0,
		'total_prestamos' => 0,
		'total_descuentos' => 0
		];

		for($i = 1; $i <= 7; $i++){ //obtener el dia del mes en el que cae cada dia de la semana
			$fecha = new DateTime();
			$fecha->setISODate($year,$semana,$i);
			$reporte['dias'][$i]['dia'] = $fecha->format('d');
			$reporte['dias'][$i]['personas'] = 0;
		}

		foreach($checadas as $checada){
			$empleado = EmpleadoCrtm::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado
			array_push($empleados, $empleado);
		}

		$empleados = array_unique($empleados); //eliminar empleados repetidos

		foreach($empleados as $empleado){
			$reporte['empleados'][$empleado->idEmpleado] = [
			'ap_paterno' => $empleado->ap_paterno,
			'ap_materno' => $empleado->ap_materno,
			'nombre' => $empleado->nombres,
			'area' => AreaCrtm::where('idArea', $empleado->area)->first()->nombre,
			'no_cuenta' => $empleado->no_cuenta,
			'checadas' => array(),
			'horas_extra' => 0,
			'horas_ordinarias' => 0,
			'descuentos' => 0,
			'prestamos' => 0];

			//obtener todas las checadas correspondientes al empleado
			for($i = 1; $i <= 7; $i++){ //agregar todas las checadas de la semana
				$fecha = new DateTime();
				$fecha->setISODate($year,$semana,$i);
				$fecha = $fecha->format('Y-m-d');
				$checadasDelDia = ChecadaCrtm::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->get();
				//generar nueva checada que no se guarda en BD pero se envia a la vista
				$checadaDelDia = new ChecadaCrtm([
					'idEmpleado' => $empleado->idEmpleado,
					'fecha' => $fecha,]);

				//obtener los descuentos y prestamos de cada empleado
				$descuentos = DescuentoCrtm::where('idEmpleado',$empleado->idEmpleado)->where('fecha',$fecha)->get();
				foreach($descuentos as $descuento){
					$reporte['empleados'][$empleado->idEmpleado]['descuentos'] += $descuento->monto;
					$reporte['total_descuentos'] += $descuento->monto;
				}

				$prestamos = Prestamo::where('idEmpleado',$empleado->idEmpleado)->where('fecha',$fecha)->get();
				foreach($prestamos as $prestamo){
					$reporte['empleados'][$empleado->idEmpleado]['prestamos'] += $prestamo->monto;
					$reporte['total_prestamos'] += $prestamo->monto;
				}
				
				//sumarle las horas de todas las checadas de ese dia
				foreach($checadasDelDia as $ch){
					$checadaDelDia->hora_entrada += $ch->hora_entrada;
					$checadaDelDia->hora_salida += $ch->hora_salida;
					$checadaDelDia->horas_ordinarias += $ch->horas_ordinarias;
					$checadaDelDia->horas_extra += $ch->horas_extra;
				}

				//enviar un valor nulo si no nhay checada en ese dia
				if(ChecadaCrtm::where('fecha',$fecha)->where('idEmpleado',$empleado->idEmpleado)->first() == null){
					$checadaDelDia = null;
				}

				$reporte['empleados'][$empleado->idEmpleado]['checadas'][$i] = $checadaDelDia;

				//sumar las horas trabajadas por cada checada
				if($checadaDelDia != null){
					$reporte['empleados'][$empleado->idEmpleado]['horas_extra'] += $checadaDelDia->horas_extra;
					$reporte['empleados'][$empleado->idEmpleado]['horas_ordinarias'] += $checadaDelDia->horas_ordinarias;
					$reporte['dias'][$i]['personas'] += 1;
					$reporte['total_horas'] += $checadaDelDia->horas_ordinarias;
					$reporte['total_horas_extra'] =+ $checadaDelDia->horas_extra;
				}
			}
		}

		$empleados = EmpleadoCrtm::all();
		$parametros = ['empleados' => $empleados, "reporte" => $reporte, 'semana' => $request->input('semana'), 'fecha1' => $fecha1, 'fecha2' => $fecha2];
		return view('empleados_directos/reporte')->with('parametros',$parametros);
	}

	public function buscar_checadas_get()
	{
			$empleados = EmpleadoCrtm::all();

			$parametros = ['empleados' => $empleados]; //se utiliza un array porque despues de encontrarlas, se enviaran mas parametros
			return view('empleados_directos/buscar_checadas')->with('parametros', $parametros);
		
	}

	//muestra resultados de la busqueda
	public function buscar_checadas_post(Request $request)
	{
		//crear un array en el que se incluiran los filtros actuales, para ser mostrados junto a la lista de resultados
		$filtrosActivos = array();


		//declarar el query en formato SQL para cada uno de los parametros, como un string
		//el string siguiente seria "fecha BETWEEN CAST('{fecha1}' AS DATE) AND CAST('{fecha2}' AS DATE)"
		$queryFechas = "fecha BETWEEN CAST('" . $request->input('fecha1') . "' AS DATE) AND CAST('" . $request->input('fecha2') . "' AS DATE)";
		array_push($filtrosActivos, ("Desde " . $request->input('fecha1') . " hasta " . $request->input('fecha2')));

		//crear el query para el numero de empleado y designar la etiqueta del filtro
		if($request->input('empleado') == 'null') $queryEmpleado = ""; //string vacio si no se define un empleado
		else {
			$empleado = EmpleadoCrtm::find($request->input('empleado'));
			$queryEmpleado = " AND idEmpleado = '" . $request->input('empleado') ."'";
			array_push($filtrosActivos, ("Empleado: " . strtoupper($empleado->ap_paterno) . " " . strtoupper($empleado->ap_materno) . ", " . strtoupper($empleado->nombres)));
		}

		$query = $queryFechas . $queryEmpleado;

		$checadas = ChecadaCrtm::whereRaw($query)->get();

		//obtener un array en el cual almacenar los nombres de los empleados
		$empleadosPorChecada = array();
		foreach($checadas as $checada){
			$empleado = EmpleadoCrtm::where('idEmpleado', $checada->idEmpleado)->first(); //obtener al empleado

			$empleadosPorChecada[$checada->idChecada] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres; //agregarlo al arreglo
		}

		$empleados = EmpleadoCrtm::all(); //obtener a los empleados para usarlos como filtro de busqueda
		$parametros = ['empleados' => $empleados, 'checadas' => $checadas, 'filtrosActivos' => $filtrosActivos, 'empleadosPorChecada' => $empleadosPorChecada];
		return view('empleados_directos/buscar_checadas')->with('parametros',$parametros);
	}

	public function baja_checadas_ajax(Request $request){
		if($request->ajax()){
			$checadas = $request->input('checadas');
				
			foreach($checadas as $_checadas){
				$checada = ChecadaCrtm::where('idChecada', $_checadas);
				$checada->delete();
			}
			return json_encode(true);

		}
	}

	public function descuento_get(){
		
			$empleados = EmpleadoCrtm::all();

			return view('empleados_directos/alta_descuento')->with('empleados',$empleados);

	}

	public function descuento_post(Request $request){
			
			$fecha = new DateTime($request->input('fecha'));
			
			$descuento = new DescuentoCrtm([
					'idEmpleado' => $request->input('empleado'),
					'monto' => $request->input('monto'),
					'concepto' => $request->input('concepto'),
					'fecha' => $fecha,
					'semana' => $fecha->format('W')
				]);
			$descuento->save();
			$empleados = EmpleadoCrtm::all();
			return view('empleados_directos/alta_descuento')->with('empleados',$empleados)->with('success',true);

		
	}

	public function prestamo_get(){
			$empleados = EmpleadoCrtm::all();

			return view('empleados_directos/alta_prestamo')->with('empleados',$empleados);

	}

	public function prestamo_post(Request $request){
			$fecha = new DateTime($request->input('fecha'));
			$prestamo = new Prestamo([
					'idEmpleado' => $request->input('empleado'),
					'monto' => $request->input('monto'),
					'concepto' => $request->input('concepto'),
					'fecha' => $fecha,
					'semana' => $fecha->format('W')
				]);
			$prestamo->save();
			$empleados = EmpleadoCrtm::all();
			return view('empleados_directos/alta_prestamo')->with('empleados',$empleados)->with('success',true);

		}

		public function subirFoto_get(){
    		$empleado = EmpleadoCrtm::all();
			return view('empleados_directos/subir_foto')->with('empleado',$empleado);
		
    	
    }

    public function subirFoto_post(Request $request){
		
      
        $rules = ['image' => 'required|image',];
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.image' => 'Formato no permitido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect('empleados/crtm/subir-foto')->withErrors($validator);
        }
        else{
        	$noempleado = $request->input('idEmpleado');

        	//eliminar foto previa
        	$foto = EmpleadoCrtm::where('idEmpleado', '=', $noempleado)->first();
			if($foto->foto != null){
        	
        	\Storage::disk('fotosCrtm')->delete($foto->foto);
        	}

        	//Cambiar nombre de foto para que no se repitan
            $name = 'empleado-oficina-'. $noempleado . '.' . $request->file('image')->getClientOriginalExtension();
            //guardar foto en disco local
            \Storage::disk('fotosCrtm')->put($name,  \File::get($request->file('image')));
            
            //guardar ruta en base de datos
            $user = new EmpleadoCrtm;
            $user->where('idEmpleado', '=', $noempleado)
                 ->update(['foto' => $name]);
            return redirect('empleados/crtm/subir-foto')->with('success', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }
    public function editar_empleado_get($idEmpleado){
    		$empleado = EmpleadoCrtm::find($idEmpleado);
			$contacto = DatosLocalizacionCrtm::where('idEmpleado',$idEmpleado)->first();
			
			$estados = Estado::all();
			$colonias= Colonia::all();
			$areas = AreaCrtm::all();
			$datos = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'area'=>$areas,'success'=>'nothing');
			return view('empleados_directos/editar_empleado')->with('datos',$datos);
		
    }
    public function editar_empleado_post(Request $request, $idEmpleado){
    	$curp = new CURP();
		$validator = Validator::make([
			'curp' => $request->input('curp'),
			'imss' => $request->input('imss'),
			'no_cuenta' => $request->input('no_cuenta')],

			[
			'imss' => 'unique:empleados_crtm,imss',
			'curp' => 'unique:empleados_crtm,curp',
			'no_cuenta' => 'unique:empleados_crtm,no_cuenta'
			]);
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' =>'La CURP no es correcta para el nombre del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}
		$empleado = EmpleadoCrtm::find($idEmpleado);
		
		
		$estado = Estado::find($request->input('id_estados'));
		
			
			if($request->input('ap_materno') == ""){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = mb_strtoupper($request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $request->input('no_cuenta');
			}

		$empleado->nombres = mb_strtoupper($request->input('nombres'));
		$empleado->ap_paterno =mb_strtoupper( $request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->area = $request->input('area');
		$empleado->save();

		
		

		//$contacto->save();
		DatosLocalizacionCrtm::where('idEmpleado', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		'nombre_contacto'=> $request->input('nombre_contacto'),
		'tel_contacto' =>$request->input('tel_contacto'),
		'tipo_parentesco' =>$request->input('tipo_parentesco')));

		
		return redirect('empleados/crtm/lista');

    }

    public function directorio_get(){
    	$directorio = DirectorioPersonal::where('idDirectorioP','>','0')->orderBy('area')->get();
    	$directorio_sucursal = array();

    	$sucursales = DirectorioSucursal::all();
    	foreach ($sucursales as $sucursal) {
    		$info['sucursal'] = $sucursal->sucursal;
    		$info['telefonos'] = $sucursal->telefonos;
    		$area = AreaCrtm::find($sucursal->area);
    		$info['area'] = $area->nombre;

    		array_push($directorio_sucursal, $info);
    	}
    	return view('directorio/directorio_personal')->with('directorio',$directorio)->with('directorio_sucursal',$directorio_sucursal);
    }


    ##Consultas

	public function buscar()
	{
			return view('empleados_directos/consultas');
		
	}

	

	

	public function sinCuenta()
	{
		$DatosLocalizacionCrtm = array();
		foreach (DatosLocalizacionCrtm::all() as $datos) {
			$DatosLocalizacionCrtm[$datos->idEmpleado] = $datos;
		}
		$colonias = array();
		foreach (Colonia::all() as $colonia) {
			$colonias[$colonia->idColonia] = $colonia;
		}
		return view('empleados_directos/consultas')->with('empleados',EmpleadoCrtm::where('no_cuenta',null)->get())->with('sin_cuenta',true)->with('DatosLocalizacionCrtm',$DatosLocalizacionCrtm)->with('colonias',$colonias);
	}

	public function incompletos()
	{
		$consulta =	EmpleadoCrtm::where(function ($query) {
	    $query->where('imss',null);
		})->orWhere(function ($query) {
	    $query->where('no_cuenta',null);
		}) ->orWhere(function ($query) {
	    $query->where('curp',null);
		})->get();


		return view('empleados_directos/consultas')->with('empleados',$consulta);
	}

	public function todos()
	{

		return view('empleados_directos/consultas')->with('empleados',EmpleadoCrtm::all());
	}

	

	public function resultados(Request $request)
	{
		$query = "";

		//numero de cuenta
		if($request->input('no_cuenta') != 'true')
			$query = $query . "no_cuenta is NULL";
		else
			$query = $query . "no_cuenta is not NULL";

		

		$empleados = EmpleadoCrtm::whereRaw($query)->get();
		return view('empleados_directos/consultas')->with('empleados',$empleados);
	}

	public function cumple()
	{
		$fecha_actual = new DateTime('now');
		$mes = $fecha_actual->format('n');
		$empleados = array();

		foreach (EmpleadoCrtm::all() as $empleado) {
			$cumple = new DateTime($empleado->fecha_nacimiento);
			if($cumple->format('n') == $mes) array_push($empleados, $empleado);
		}
		return view('empleados_directos/consultas')->with('empleados',$empleados);
	}

}