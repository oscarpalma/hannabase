<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EmpleadoCt;
use App\Estado;
use App\Colonia;
use App\AreaCt;
use App\DatosLocalizacionCt;
use Validator;
use App;
use Auth;
use App\DescuentoCt;
use App\Prestamo;

use Illuminate\Http\Request;

class EmpleadoCtController extends Controller {

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
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad','recepcion'])){
			$estados = Estado::all();
			$colonias= Colonia::where('idColonia','>',0)->orderBy('nombre')->get();
			$areas = AreaCt::all();
			$datosLocalizacionCt = array('estados' => $estados,'colonias'=>$colonias,'area' => $areas);
		    return view('registro_empleado_ct')->with('datosLocalizacion',$datosLocalizacionCt);
		}

		else
			return view('errors/restringido');
	}

	public function mostrarEmpleadosCt(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad','recepcion'])){
			$empleadosCt = EmpleadoCt::all();
			$areas = array(); //sera un array en el que el indice sera el numero de cada empleado
			foreach($empleadosCt as $empleado){
				$area = AreaCt::find($empleado->area);
				$areas[$empleado->idEmpleadoCt] = $area->nombre;
			}
			return view('lista_empleados_ct')->with('empleados',['empleados' => $empleadosCt, 'areas' => $areas]);
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
		$curp = new CURP();
		$validator = Validator::make([
			'curp' => $request->input('curp'),
			'imss' => $request->input('imss'),
			'no_cuenta' => $request->input('no_cuenta'),
			'rfc' => $request->input('rfc')],

			[
			'imss' => 'unique:empleados_ct,imss',
			'curp' => 'unique:empleados_ct,curp',
			'no_cuenta' => 'unique:empleados_ct,no_cuenta',
			'rfc' => 'unique:empleados_ct,rfc'
			]);

		if($validator->fails() && $validator->messages()->has('curp')){
			$empleado = EmpleadoCt::where('curp',$request->input('curp'))->first();
			$errores = ['nombres' => 'El empleado ya existe en la base de datos'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}

		else if($validator->fails()){
			return redirect()->back()->withErrors($validator->messages())->withInput($request->flash());
		}

		else if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP otorgada no es valida'];
//$errores = ['curp' => $curp->generar($request)];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}

		else{

			$estado = Estado::find($request->input('id_estados'));
			$area = AreaCt::find($request->input('area'));
			$empleadoCt = new EmpleadoCt([
				'nombres' =>strtoupper( $request->input('nombres')),
				'ap_paterno' => strtoupper($request->input('ap_paterno')),
				'curp' => strtoupper($request->input('curp')),
				'imss' => $request->input('imss'),
				'genero' => $request->input('genero'),
				'idestado' => $estado->id_estados,
				'fecha_nacimiento' => $request->input('fecha_nacimiento'),
				'area' => $area->idAreaCt,
				'fecha_ingreso' =>$request->input('fecha_ingreso')
				]);
			
			if($request->input('ap_materno') == "XX"){
				$empleadoCt->ap_materno = null;
			}
			else{
				$empleadoCt->ap_materno = strtoupper($request->input('ap_materno'));
			}
			
			if($request->input('no_cuenta') == ""){
				$empleadoCt->no_cuenta = null;
			}
			else{
				$empleadoCt->no_cuenta = $request->input('no_cuenta');
			}

			if($request->input('imss') == "")
				$empleadoCt->imss = null;

			else{
				$fecha_nacimiento = (string)$request->input('fecha_nacimiento');
				if($fecha_nacimiento[2].$fecha_nacimiento[3] != $request->input('imss')[4].$request->input('imss')[5]){
					$errores = ['imss' => 'El número del IMSS ingresado no coincide con los datos del empleado'];
					return redirect()->back()->withErrors($errores)->withInput($request->flash());
				}

				$empleadoCt->imss = $request->input('imss');
			}

			$rfc = new RFC();
			$fecha_nacimiento = $request->input('fecha_nacimiento');
			$nombre = $request->input('nombres');
			$paterno = $request->input('ap_paterno');
			$materno= $request->input('ap_materno');
			$dia= $fecha_nacimiento[8] .$fecha_nacimiento[9];
			$mes = $fecha_nacimiento[5] . $fecha_nacimiento[6];
			$anio = $fecha_nacimiento[0] . $fecha_nacimiento[1] . $fecha_nacimiento[2] . $fecha_nacimiento[3];

			if($request->input('rfc') == ""){
				$rfcGenerada = $rfc->obtener($nombre,$paterno,$materno,$dia,$mes,$anio);
				$validator = Validator::make(['rfc' => $rfcGenerada], ['rfc' => 'unique:empleados_ct,rfc']);

				if($validator->fails()){
					return redirect()->back()->withErrors($validator->messages())->withInput($request->flash());
				}

				else{
					$empleadoCt->rfc = $rfcGenerada;
				}
			}
			else if($rfc->validar($request,$rfc->obtener($nombre,$paterno,$materno,$dia,$mes,$anio))){
				$empleadoCt->rfc = $request->input('rfc');
			}
			else{
				$errores = ['rfc' => 'El RFC ingresado no coincide con los datos del empleado'];
				return redirect()->back()->withErrors($errores)->withInput($request->flash());
			}

			$empleadoCt->save();

			$colonia = Colonia::find($request->input('idColonia'));
			$datosLocalizacionCt = new DatosLocalizacionCt([
				'tel_casa'        => $request->input('tel_casa'),
				'tel_cel'         => $request->input('tel_cel'),
				'calle'           => $request->input('calle'),
				'no_interior'     => $request->input('no_interior'),
				'no_exterior'     => $request->input('no_exterior'),
				'idColonia'       => $colonia->idColonia,
				'idEmpleadoCt'    => $empleadoCt->idEmpleadoCt,
				'nombre_contacto' => $request->input('nombre_contacto'),
				'tel_contacto'    => $request->input('tel_contacto'),
				'tipo_parentesco' => $request->input('tipo_parentesco')
				]);

			$datosLocalizacionCt->save();
			
			return redirect()->route('registro_empleado_ct')->withInput()->with('success','Empleado registrado con éxito');
		}
	}

	public function modificarEmpleado($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		elseif(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = EmpleadoCt::find($idEmpleado);
			$contacto = DatosLocalizacionCt::where('idEmpleadoCt',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$areas = AreaCt::all();
			$datos = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'area'=>$areas,'success'=>'nothing');
			return view('empleados_ct/modificar')->with('datos',$datos);
		}

		else
			return view('errors/restringido');
	}

	public function actualizarEmpleado(Request $request, $idEmpleado){
		
		if(Auth::guest())
			return redirect()->route('login');

		elseif(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
		
		$curp = new CURP();
		$validator = Validator::make([
			'curp' => $request->input('curp'),
			'imss' => $request->input('imss'),
			'no_cuenta' => $request->input('no_cuenta'),
			'rfc' => $request->input('rfc')],

			[
			'imss' => 'unique:empleados_ct,imss',
			'curp' => 'unique:empleados_ct,curp',
			'no_cuenta' => 'unique:empleados_ct,no_cuenta',
			'rfc' => 'unique:empleados_ct,rfc'
			]);
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' =>'La CURP no es correcta para el nombre del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}
		$empleado = EmpleadoCt::find($idEmpleado);
		
		
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
		$empleado->ap_paterno =strtoupper( $request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->area = $request->input('area');
		$empleado->save();

		
		

		//$contacto->save();
		DatosLocalizacionCt::where('idEmpleadoCt', $idEmpleado)->update(array('tel_casa'=> $request->input('tel_casa'),'tel_cel' =>$request->input('tel_cel'),
		'calle' =>$request->input('calle'),
		'no_interior' =>$request->input('no_interior'),
		'no_exterior'=> $request->input('no_exterior'),
		'idColonia' =>$request->input('idColonia'),
		'nombre_contacto'=> $request->input('nombre_contacto'),
		'tel_contacto' =>$request->input('tel_contacto'),
		'tipo_parentesco' =>$request->input('tipo_parentesco')));

		$empleadosCt = EmpleadoCt::all();
			$areas = array(); //sera un array en el que el indice sera el numero de cada empleado
			foreach($empleadosCt as $empleado){
				$area = AreaCt::find($empleado->area);
				$areas[$empleado->idEmpleadoCt] = $area->nombre;
			}
			return redirect('empleados-ct-lista')->with('empleados',['empleados' => $empleadosCt, 'areas' => $areas]);

			}

		else
			return view('errors/restringido');
	}
	public function confirmarEliminarE($idEmpleado){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
			//enviar a una ventana para corroborar los datos del candidato al que se piensa promover
			$empleado = EmpleadoCt::find($idEmpleado);
			$area = AreaCt::find($empleado->area);
			return view('empleados_ct/confirmar')->with('empleado',['empleado'=>$empleado,'area'=>$area]);
		}

		else
			return view('errors/restringido');
	}

	public function descuentoEmpleado(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){

			$empleados = EmpleadoCt::all();

			return view('empleados_ct/descuento')->with('empleados',$empleados);

		}

		else
			return view('errors/restringido');
	}

	public function guardarDescuento(Request $request){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){

			$descuento = new DescuentoCt([
					'empleado' => $request->input('empleado'),
					'monto' => $request->input('monto'),
					'concepto' => $request->input('concepto'),
					'fecha' => $request->input('fecha'),
					'semana' => $request->input('semana')
				]);
			$descuento->save();
			$empleados = EmpleadoCt::all();
			return view('empleados_ct/descuento')->with('empleados',$empleados);

		}

		else
			return view('errors/restringido');
	}

	public function prestamo(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){

			$empleados = EmpleadoCt::all();

			return view('empleados_ct/prestamo')->with('empleados',$empleados);

		}

		else
			return view('errors/restringido');
	}

	public function guardarPrestamo(Request $request){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){

			$prestamo = new Prestamo([
					'empleado' => $request->input('empleado'),
					'monto' => $request->input('monto'),
					'concepto' => $request->input('concepto'),
					'fecha' => $request->input('fecha'),
					'semana' => $request->input('semana')
				]);
			$prestamo->save();
			$empleados = EmpleadoCt::all();
			return view('empleados_ct/prestamo')->with('empleados',$empleados);

		}

		else
			return view('errors/restringido');
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
	public function updateEmpleado($id)
	{

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
	public function destroy($idEmpleado)
	{
		
		$empleado = EmpleadoCt::find($idEmpleado);
        $empleado->delete();
        return redirect('empleados-ct-lista');

	}

}