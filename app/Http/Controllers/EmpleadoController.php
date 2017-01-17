<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\Estado;
use App\Colonia;
use App\DatosLocalizacion;
use App\Localizacion;
use Validator;
use App;
use App\ExamenMedico;
use App\Checada;
use App\Cliente;
use DateTime;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EmpleadoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}

	//crear un candidato
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){	
			$estados = Estado::all();
			$colonias= Colonia::where('idColonia','>',0)->orderBy('nombre')->get();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias);
		    return view('registro_empleado')->with('datosLocalizacion',$datosLocalizacion);
		}

		else
			return view('errors/restringido');
	}

	public function buscar()
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad'])){
			return view('empleados/buscar');
		}

		else
			return view('errors/restringido');
	}

	//metodos para las busquedas rapidas:
	public function noImss()
	{		
		return view('empleados/buscar')->with('empleados',Empleado::where('imss',null)->where('contratable',1)->get());
	}

	public function noRfc()
	{
		return view('empleados/buscar')->with('empleados',Empleado::where('rfc',null)->where('contratable',1)->get());
	}

	public function sinCuenta()
	{
		$datosLocalizacion = array();
		foreach (DatosLocalizacion::all() as $datos) {
			$datosLocalizacion[$datos->idEmpleado] = $datos;
		}
		$colonias = array();
		foreach (Colonia::all() as $colonia) {
			$colonias[$colonia->idColonia] = $colonia;
		}
		return view('empleados/buscar')->with('empleados',Empleado::where('no_cuenta',null)->where('contratable',1)->where('estado','empleado')->get())->with('sin_cuenta',true)->with('datosLocalizacion',$datosLocalizacion)->with('colonias',$colonias);
	}

	public function incompletos()
	{
	$consulta =	Empleado::where(function ($query) {
    $query->where('imss',null)
          ->where('contratable',1);
})->orWhere(function ($query) {
    $query->where('no_cuenta',null)
          ->where('contratable',1);
}) ->orWhere(function ($query) {
    $query->where('rfc',null)
          ->where('contratable',1);
}) ->orWhere(function ($query) {
    $query->where('curp',null)
          ->where('contratable',1);
})->get();


		return view('empleados/buscar')->with('empleados',$consulta);
	}

	public function cumple()
	{
		$fecha_actual = new DateTime('now');
		$mes = $fecha_actual->format('n');
		$empleados = array();

		foreach (Empleado::where('contratable', 1)->get() as $empleado) {
			$cumple = new DateTime($empleado->fecha_nacimiento);
			if($cumple->format('n') == $mes) array_push($empleados, $empleado);
		}
		return view('empleados/buscar')->with('empleados',$empleados);
	}

	public function sinCurp()
	{
		return view('empleados/buscar')->with('empleados',Empleado::where('curp',null)->where('contratable',1)->get());
	}

	public function resultados(Request $request)
	{
		$query = "";

		//curp
		if($request->input('curp') != 'true')
			$query = $query . "curp is NULL AND ";
		else
			$query = $query . "curp is not NULL AND ";

		//imss
		if($request->input('imss') != 'true')
			$query = $query . "imss is NULL AND ";		
		else
			$query = $query . "imss is not NULL AND ";

		//rfc
		if($request->input('rfc') != 'true')
			$query = $query . "rfc is NULL AND ";
		else
			$query = $query . "rfc is not NULL AND ";

		//numero de cuenta
		if($request->input('no_cuenta') != 'true')
			$query = $query . "no_cuenta is NULL AND ";
		else
			$query = $query . "no_cuenta is not NULL AND ";

		//terminan los queries de documentacion


		//perfiles
		if($request->input('perfil_a') != 'true' && $request->input('perfil_b') != 'true' && $request->input('perfil_c') != 'true')
			return redirect()->route('buscar_empleados')->withInput()->with('message',"Por favor, seleccione al menos un tipo de perfil");
		$query = $query . "(";
		if($request->input('perfil_a') == 'true')
			$query = $query . "tipo_perfil = 'a' OR ";

		if($request->input('perfil_b') == 'true')
			$query = $query . "tipo_perfil = 'b' OR ";

		if($request->input('perfil_c') == 'true')
			$query = $query . "tipo_perfil = 'c'";

		//eliminar OR en caso de quedar al final
		$query = preg_replace('/ OR $/', "", $query);
		$query = $query . ") AND (";
		//terminan los queries de perfiles

		//queries estado
		if($request->input('candidato') != 'true' && $request->input('empleado') != 'true')
			return redirect()->route('buscar_empleados')->withInput()->with('message','Por favor, seleccione al menos un estado');
		if($request->input('candidato') == 'true')
			$query = $query . "estado = 'candidato' OR ";
		if($request->input('empleado') == 'true')
			$query = $query . "estado = 'empleado'";

		//eliminar OR en caso de quedar al final
		$query = preg_replace('/ OR $/', "", $query);
		$query = $query . ")";
		//termina query estado

		//lista negra
		if($request->input('no_contratable') != 'true')
			$query = $query . " AND contratable = 1";

		$empleados = Empleado::whereRaw($query)->get();
		return view('empleados/buscar')->with('empleados',$empleados);
	}

	public function convertirEmpleado($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = Empleado::find($idEmpleado);
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			return view('confirmar')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
	}

	public function promover($idEmpleado){
		//promover un candidato a empleado
		$empleado = Empleado::find($idEmpleado);
		$empleado->estado = 'empleado';
		$empleado->save();

		//regresar a la lista de candidatos
		$empleados = Empleado::where('contratable',true)->where('estado','empleado')->paginate(10);
		return redirect()->route('mostrar_candidatos')->with('empleados',$empleados);
	}

	public function mostrarCandidatos(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion','contabilidad'])){
			$empleados = Empleado::where('contratable',true)->where('estado','candidato')->get();
			$informacion = array();
			foreach($empleados as $_empleado){
				$examen = ExamenMedico::where('empleado',$_empleado->idEmpleado)->orderBy('created_at','desc')->first();
				$empleado['empleado'] = $_empleado;
				if($examen === null) $empleado['examen'] = null;
				elseif($examen->aprobado) $empleado['examen'] = true;
				else $empleado['examen'] = false;
				array_push($informacion, $empleado);
			}
			return view('lista_candidatos')->with('informacion',$informacion);
		}

		else
			return view('errors/restringido');
	}

	public function listaNegra(){
		if(Auth::guest())
			return redirect()->route('login');

		else {			
			$empleado = Empleado::where('contratable',false)->get();
			
			//Arreglo para poder mostrar mensaje en caso de que no se encuentre ningun resultado
			$empleados = array();
			foreach($empleado as $empleado){
				array_push($empleados, $empleado);
			}
			return view('lista_negra')->with('empleados',$empleados);
		}
	}
 
	public function mostrarEmpleados(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad','recepcion'])){
			$empleado = Empleado::where('contratable',true)->where('estado','empleado')->get();
			//Arreglo para poder mostrar mensaje en caso de que no se encuentre ningun resultado
			$empleados = array();
			foreach($empleado as $_empleado){
                        $colonia= DatosLocalizacion::where('idEmpleado',$_empleado->idEmpleado)->first();
				$codigoP = Colonia::where('idColonia',$colonia->idColonia)->first();
				$_empleado['codigopostal'] = $codigoP->codigo_postal;
				array_push($empleados, $_empleado);
			}

			return view('lista_empleados')->with('empleados',$empleados);
		}

		else
			return view('errors/restringido');
	}

	public function modificarEmpleado($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		elseif(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = Empleado::find($idEmpleado);
			$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('editar_empleado')->with('datosLocalizacion',$datosLocalizacion);
		}

		else
			return view('errors/restringido');
	}

	public function modificarCandidato($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = Empleado::find($idEmpleado);
			$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('editar_candidato')->with('datosLocalizacion',$datosLocalizacion);
		}

		else
			return view('errors/restringido');
	}

	public function verEmpleado($idEmpleado)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'contabilidad'){
			$empleado = Empleado::find($idEmpleado);
			$localizacion = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			$estado = Estado::find($empleado->idestado)->nombre;
			$colonia = Colonia::find($localizacion->idColonia)->nombre;

			$empleado = [
			'ap_paterno' => $empleado->ap_paterno,
			'ap_materno' => $empleado->ap_materno,
			'nombres' => $empleado->nombres,
			'fecha_nacimiento' => $empleado->fecha_nacimiento,
			'genero' => $empleado->genero,
			'estado' => $estado,
			'curp' => $empleado->curp,
			'imss' => $empleado->imss,
			'no_cuenta' => $empleado->no_cuenta,
			'rfc' => $empleado->rfc,
			'tipo_perfil' => $empleado->tipo_perfil,
			'tel_casa' => $localizacion->tel_casa,
			'tel_cel' => $localizacion->tel_cel,
			'calle' => $localizacion->calle,
			'no_interior' => $localizacion->no_interior,
			'no_exterior' => $localizacion->no_exterior,
			'colonia' => $colonia,
			'nombre_contacto' => $localizacion->nombre_contacto,
			'tel_contacto' => $localizacion->tel_contacto,
			'tipo_parentesco' => $localizacion->tipo_parentesco
			];

			return view('ver_empleado')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
	}

	public function confirmarEliminarE($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = Empleado::find($idEmpleado);
			
			return view('confirmarEliminarE')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
	}

	public function actualizarEmpleado(Request $request, $idEmpleado){
		//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
		
		$curp = new CURP();
		//if(!$curp->validar($request, $curp->generar($request)) || strlen($request-//>input('curp')) != 18){
			//$errores = ['curp' => 'La CURP no es correcta para el nombre del empleado'];
		//	return redirect()->back()->withErrors($errores)->withInput($request->flash());
	//	}
		$empleado = Empleado::find($idEmpleado);
		
		
		$estado = Estado::find($request->input('id_estados'));
		
			
			if($request->input('ap_materno') == "XX"){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = strtoupper($request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $request->input('no_cuenta');
			}
		$empleado->nombres = strtoupper($request->input('nombres'));
		$empleado->ap_paterno = strtoupper($request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		$empleado->tipo_perfil = $request->input('tipo_perfil');
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->visa = $request->input('visa');
		$empleado->save();

		
		

		//$contacto->save();
		DatosLocalizacion::where('idEmpleado', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		'nombre_contacto'=> $request->input('nombre_contacto'),
		'tel_contacto' =>$request->input('tel_contacto'),
		'tipo_parentesco' =>$request->input('tipo_parentesco')));

		$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();

		$estados = Estado::all();
		$colonias= Colonia::all();
		$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'success');
		$empleados = Empleado::where('contratable',true)->where('estado','empleado')->paginate(10);
		return redirect()->route('mostrar_empleados');
	}

	public function actualizarCandidato(Request $request, $idEmpleado){
		//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
		
		$curp = new CURP();
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP no es correcta para el nombre del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}

		$fecha_nacimiento = (string)$request->input('fecha_nacimiento');
		if($request->input('imss') != ""){
			if($fecha_nacimiento[2].$fecha_nacimiento[3] != $request->input('imss')[4].$request->input('imss')[5]){
				$errores = ['imss' => 'El número del IMSS ingresado no coincide con los datos del empleado'];
				return redirect()->back()->withErrors($errores)->withInput($request->flash());
			}
		}

		$empleado = Empleado::find($idEmpleado);
		
		
		$estado = Estado::find($request->input('id_estados'));
		
			
			if($request->input('ap_materno') == "XX"){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno =strtoupper( $request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $request->input('no_cuenta');
			}

			if($request->input('imss') == "")
				$empleado->imss = null;

			else
				$empleado->imss = $request->input('imss');

		$empleado->nombres = strtoupper($request->input('nombres'));
		$empleado->ap_paterno = strtoupper($request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		$empleado->tipo_perfil = $request->input('tipo_perfil');
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->visa = $request->input('visa');
		
		$empleado->save();

		
		

		//$contacto->save();
		DatosLocalizacion::where('idEmpleado', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		'nombre_contacto'=> $request->input('nombre_contacto'),
		'tel_contacto' =>$request->input('tel_contacto'),
		'tipo_parentesco' =>$request->input('tipo_parentesco')));

		$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();

		$estados = Estado::all();
		$colonias= Colonia::all();
		$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'success');
		$empleados = Empleado::where('contratable',true)->where('estado','empleado')->paginate(10);
		return redirect()->route('mostrar_candidatos');
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$curp = new CURP();
		$validator = Validator::make([
			'curp' => $request->input('curp'),
			'imss' => $request->input('imss'),
			'no_cuenta' => $request->input('no_cuenta'),
			'rfc' => $request->input('rfc')],

			[
			'imss' => 'unique:empleados,imss',
			'curp' => 'unique:empleados,curp',
			'no_cuenta' => 'unique:empleados,no_cuenta',
			'rfc' => 'unique:empleados,rfc'
			]);

		if($validator->fails() && $validator->messages()->has('curp')){
			$empleado = Empleado::where('curp',$request->input('curp'))->first();
			if($empleado->contratable){
				$errores = ['nombres' => 'El empleado ya existe en la base de datos'];
				return redirect()->back()->withErrors($errores)->withInput($request->flash()); 
			}
			else{
				$errores = ['nombres' => 'El empleado ya existe en la base de datos y se encuentra en lista negra'];
				return redirect()->back()->withErrors($errores)->withInput($request->flash());
			}
		}

		else if($validator->fails()){
			return redirect()->back()->withErrors($validator->messages())->withInput($request->flash());
		}

		elseif(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP otorgada no es valida'];
			return redirect()->back()->withErrors($curp->generar($request))->withInput($request->flash());
		}

		else{

			$estado = Estado::find($request->input('id_estados'));
			$empleado = new Empleado([
				'nombres' => strtoupper($request->input('nombres')),
				'ap_paterno' => strtoupper( $request->input('ap_paterno')),
				'curp' => strtoupper( $request->input('curp')),
				'imss' => $request->input('imss'),
				'genero' => $request->input('genero'),
				'tipo_perfil' => $request->input('tipo_perfil'),
				'estado' => 'empleado',
				'contratable' => true,
				'idestado' => $estado->id_estados,
				'fecha_nacimiento' => $request->input('fecha_nacimiento'),
				'visa' => $request->input('visa'),
				]);
			
			if($request->input('ap_materno') == "XX"){
				$empleado->ap_materno = null;
			}
			else{
				$empleado->ap_materno = strtoupper($request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleado->no_cuenta = null;
			}
			else{
				$empleado->no_cuenta = $request->input('no_cuenta');
			}

			$fecha_nacimiento = (string)$request->input('fecha_nacimiento');
			if($request->input('imss') != ""){
				if($fecha_nacimiento[2].$fecha_nacimiento[3] != $request->input('imss')[4].$request->input('imss')[5]){
					$errores = ['imss' => 'El número del IMSS ingresado no coincide con los datos del empleado'];
					return redirect()->back()->withErrors($errores)->withInput($request->flash());
				}
			}

			if($request->input('imss') == "")
				$empleado->imss = null;

			else
				$empleado->imss = $request->input('imss');
			
			$rfc = new RFC();
			$nombre = $request->input('nombres');
			$paterno = $request->input('ap_paterno');
			$materno= $request->input('ap_materno');
			$dia= $fecha_nacimiento[8] .$fecha_nacimiento[9];
			$mes = $fecha_nacimiento[5] . $fecha_nacimiento[6];
			$anio = $fecha_nacimiento[0] . $fecha_nacimiento[1] . $fecha_nacimiento[2] . $fecha_nacimiento[3];

			if($request->input('rfc') == ""){
				$rfcGenerada = $rfc->obtener($nombre,$paterno,$materno,$dia,$mes,$anio);
				$validator = Validator::make(['rfc' => $rfcGenerada], ['rfc' => 'unique:empleados,rfc']);

				if($validator->fails()){
					return redirect()->back()->withErrors($validator->messages())->withInput($request->flash());
				}

				else{
					$empleado->rfc = $rfcGenerada;
				}
			}
			else if($rfc->validar($request,$rfc->obtener($nombre,$paterno,$materno,$dia,$mes,$anio))){
				$empleado->rfc = $request->input('rfc');
			}
			else{
				$errores = ['rfc' => 'El RFC ingresado no coincide con los datos del empleado'];
				return redirect()->back()->withErrors($errores)->withInput($request->flash());
			}

			$empleado->save();

			$colonia = Colonia::find($request->input('idColonia'));
			$datosLocalizacion = new DatosLocalizacion([
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

			$datosLocalizacion->save();

			return redirect()->route('registro_empleado')->with('success',$empleado->idEmpleado);
		}
	}

	public function confirmarListaNegra($idEmpleado)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa enviar a lista negra
			$empleado = Empleado::find($idEmpleado);
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			return view('confirmar_lista_negra')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
	}

	public function agregarListaNegra($idEmpleado)
	{
		$empleado = Empleado::find($idEmpleado);
		$empleado->contratable = false;
		$empleado->save();

		//regresar a la lista de candidatos
		return redirect()->route('lista_negra');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

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
	public function update($idEmpleado)
	{
        #$empleado = Empleado::find($idEmpleado);
		#$empleado->estado=>'empleado';
		#$empleado->save();
		#return redirect()->back();
	
		#DB::table('empleados')
         #   ->where('idEmpleado', $idEmpleado)
          #  ->update('estado' -> 'empleado']);

		DB::update('update empleados set estado = "empleado" where idEmpleado = ?', array($idEmpleado));
		return redirect()->back();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idEmpleado)
	{
		#$datosLocalizacion =  DatosLocalizacion::find($idEmpleado);
		#$datosLocalizacion -> delete();
		$empleado = Empleado::find($idEmpleado);
        $empleado->delete();
        return redirect('lista-empleados');

	}

	//funcion encargada de cambiar a candidatos los empleados sin actividad en los ultimos 8 dias
	public function limpiar()
	{
		//obtener la fecha actual
		$fecha = new DateTime('now');
		$empleadosInactivos = array();
		$diasTolerancia = 16; //los dias que un empleado puede aparecer como inactivo sin ser convertido en candidato
		$cont = 0; //un contador con el numero de empleados inactivos que fueron convertidos en candidatos

		foreach(Empleado::where('estado', 'empleado')->where('contratable', true)->get() as $empleado){
			//obtiene la checada mas reciente del empleado
			$checada = Checada::where('idEmpleado', $empleado->idEmpleado)->orderBy('fecha','desc')->first();

			//si no existe checada, verificar si ha habido actividad durante los ultimos 8 dias
			if($checada === null){
				if($fecha->diff(new DateTime($empleado->updated_at))->format('%a') >= $diasTolerancia) {
					//modifica el empleado a candidato y lo guarda en la base de datos
					$empleado->estado = 'candidato';
					$empleado->save();
					$cont++;
				}
				continue;
			}

			//obtiene la cantidad de dias entre hoy y la ultima checada registrada del empleado
			if($fecha->diff(new DateTime($checada->fecha))->format('%a') >= $diasTolerancia){ 
				//modifica el empleado a candidato y lo guarda en la base de datos
				$empleado->estado = 'candidato';
				$empleado->save();
				$cont++;
			}
		}

		//regresa al listado de candidatos
		return redirect()->route('mostrar_candidatos')->with('error','Se conviertieron ' . $cont . ' empleados inactivos a candidatos');
	}

	public function historial_get(){
		return view('empleados/historial');
	}

	public function historial_post(Request $request){
		if($request->ajax()){
			$empleado = Empleado::find($request->input('id'));
	        $datos['nombre']=$empleado->ap_paterno." ".$empleado->ap_materno." ".$empleado->nombres;
	        $datos['id']=$empleado->idEmpleado;
	        $fecha= new DateTime($empleado->fecha_nacimiento);
	        $datos['fecha']=$fecha->format('d-m-Y');
	        $datos['curp']=$empleado->curp;
	        $datos['imss']=$empleado->imss;
	        $datos['cuenta']=$empleado->no_cuenta;
	        $datos['rfc']=$empleado->rfc;
	        $datos['perfil']= strtoupper($empleado->tipo_perfil);
	        $datos['visa']=ucwords($empleado->visa);
	        $datos['foto']=$empleado->foto;
	        
	        //Obtener nombre de estado
	        $idestado=$empleado->idestado;
	        $estado = Estado::find($idestado);
	        $datos['estado']=$estado->nombre;
	        //Obtener datos de localización
	        $datosLocalizacion = DatosLocalizacion::where('idEmpleado',$empleado->idEmpleado)->first();
	    	$datos['telefono']=$datosLocalizacion->tel_casa." ".$datosLocalizacion->tel_cel;
	    	$colonia=Colonia::find($datosLocalizacion->idColonia);
	    	$datos['direccion']=strtoupper($datosLocalizacion->calle." ".$datosLocalizacion->no_exterior." ".$datosLocalizacion->no_interior." ".$colonia->nombre);
	    	$datos['contacto']="Llamar a ".ucwords($datosLocalizacion->nombre_contacto)." al telefono ".$datosLocalizacion->tel_contacto;
	    	 
	    	//obtener empresas y fecha de ingreso
	    	$primeraChecada=Checada::where('idEmpleado',$empleado->idEmpleado)->first();
	    	if($primeraChecada!=null){
		    	$fechaI= new DateTime($primeraChecada->fecha);
		    	$datos['fechaI']=$fechaI->format('d-m-Y');

		    	$empresas = array();
		    	$diasPorSemanaA = array();
		    	return json_encode($datos);
		    	$checadas = Checada::distinct()->where('idEmpleado',$empleado->idEmpleado)->get(['idCliente'])->orderBy('fecha');
		    	
		    	foreach ($checadas as $checada) {

		    		$empresa['nombre']=Cliente::where('idCliente',$checada->idCliente)->first(['nombre']);

		    		$empresa['dias']=Checada::where('idCliente',$checada->idCliente)->where('idEmpleado',$empleado->idEmpleado)->count();
		    		
		    		$fecha = new DateTime($checada->fecha);
		    		 
		    		array_push($empresas, $empresa);
		    		array_push($diasPorSemanaA, $fecha->format('W'));
		    	}
		    	$datos['empresas']=$empresas;
		    	$datos['diasPorSemana']=$diasPorSemanaA;
		    }else
		    	$datos['sinChecada']=true;
	    return json_encode($datos);
    }else{
    	return json_encode(false);
    	}
	}
}