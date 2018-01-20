<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modelos\Empleado;
use App\Modelos\Estado;
use App\Modelos\Colonia;
use App\Modelos\DatosLocalizacion;
use Validator;
use App;
//use App\ExamenMedico;
//use App\Checada;
use DateTime;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
class CandidatoController extends Controller {


	
			##  CANDIDATOS ##

	public function alta_get()
	{
				$estados = Estado::all();
				$colonias= Colonia::where('idColonia','>',0)->orderBy('nombre')->get();
				
			    return view('candidatos/alta_candidato')->with('colonias',$colonias)->with('estados',$estados);
		
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
			$perfil = $request->input('tipo_perfil');
			$visa = $request->input('visa');
			$cuenta = $request->input('no_cuenta');

		$validarCurp = new CURP();
		$validator = Validator::make([
			'curp' => $curp,
			'imss' => $imss,
			'no_cuenta' => $cuenta],

			[
			'imss' => 'unique:empleados,imss',
			'curp' => 'unique:empleados,curp',
			'no_cuenta' => 'unique:empleados,no_cuenta'
			]);

		//Validar que los campos no se encuentren repetidos
		if($validator->fails() && $validator->messages()->has('curp')){
			$empleado = Empleado::where('curp',$curp)->first();
			if($empleado->contratable){
				$errores['nombre'] = 'El empleado ya existe en la base de datos';
			}
			else{
				$errores['nombres'] = 'El empleado ya existe en la base de datos y se encuentra en lista negra';
			}
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
				//$errores['curp'] = $validarCurp->generar($request);
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
			$empleado = new Empleado([
				'nombres' => $nombre,
				'ap_paterno' => $paterno,
				'curp' => $curp,
				'imss' => $imss,
				'genero' => $genero,
				'tipo_perfil' => $perfil,
				'estado' => 'candidato',
				'contratable' => true,
				'idestado' => $estado->id_estados,
				'fecha_nacimiento' => $fecha_nacimiento,
				'visa' => $visa,
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

			return redirect()->route('registro_candidato')->with('success',$empleado->idEmpleado);
		}

		}

		
	}

	public function editar_get($idEmpleado){
			$empleado = Empleado::find($idEmpleado);
			$contacto = DatosLocalizacion::where('idEmpleado',$idEmpleado)->first();
			//$empleado = Empleado::where('idEmpleado',$idEmpleado)->first();
			$estados = Estado::all();
			$colonias= Colonia::all();
			$datosLocalizacion = array('estados' => $estados,'colonias'=>$colonias, 'empleado' => $empleado, 'contacto' => $contacto , 'success'=>'nothing');
			return view('candidatos/editar_candidato')->with('colonias',$colonias)->with('estados',$estados)->with('empleado',$empleado)->with('contacto',$contacto);
	}

	public function editar_post($idEmpleado,Request $request){
			$curp = new CURP();
		if(!$curp->validar($request, $curp->generar($request)) || strlen($request->input('curp')) != 18){
			$errores = ['curp' => 'La CURP no es correcta para los datos del empleado'];
			return redirect()->back()->withErrors($errores)->withInput($request->flash());
		}
		$empleado = Empleado::find($idEmpleado);
		
		
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
		$empleado->ap_paterno = mb_strtoupper($request->input('ap_paterno'));
		$empleado->genero = $request->input('genero');
		$empleado->tipo_perfil = $request->input('tipo_perfil');
		$empleado->idestado = $estado->id_estados;
		$empleado->fecha_nacimiento = $request->input('fecha_nacimiento');
		$empleado->visa = $request->input('visa');
		$empleado->save();

		
		

		
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
		return redirect()->route('lista_candidatos');
	}

	public function lista_get(){
		
			$empleados = Empleado::where('contratable',true)->where('estado','candidato')->get();
			//$empleados = Empleado::where('contratable',true)->get();
			$informacion = array();
			foreach($empleados as $_empleado){
				//$examen = ExamenMedico::where('empleado',$_empleado->idEmpleado)->orderBy('created_at','desc')->first();
				$examen=null;
				$empleado['empleado'] = $_empleado;
				if($examen === null) $empleado['examen'] = null;
				elseif($examen->aprobado) $empleado['examen'] = true;
				else $empleado['examen'] = false;
				array_push($informacion, $empleado);
			}
			return view('candidatos/lista_candidatos')->with('informacion',$informacion);
			
			//return view('candidatos/lista_candidatos');
		
	}

	public function enviar_lista_negra(Request $request){
			
			if($request->ajax()){
				
				foreach ($request->input('id') as $id) {
					$empleado = Empleado::find($id);
					$empleado->contratable = 0;
					$empleado->save();
				}
				
			return json_encode(true);
			}

			
		}

	public function lista_negra_get(){
					
		$empleados = Empleado::where('contratable',false)->get();
			
				
		return view('candidatos/lista_negra')->with('empleados',$empleados);
		
		
	}

	public function baja(Request $request){
		if($request->ajax()){
			foreach ($request->input('id') as $id) {
			$empleado = Empleado::find($id);
	        $empleado->delete();
	    }
    	return json_encode(true);
    }
      return json_encode(false);  
	}

	public function convertir(Request $request){
		if($request->ajax()){
			foreach ($request->input('id') as $id) {
			$empleado = Empleado::find($id);
	        $empleado->estado='empleado';
	        $empleado->save();
	        
	    }
	    return json_encode(true);
    }
        
	}

	public function datos(Request $request){
		
		if($request->ajax()){
			$empleado = Empleado::find($request->input('id'));
	        $datos['nombre']=$empleado->ap_paterno." ".$empleado->ap_materno." ".$empleado->nombres;
	        $datos['id']=$empleado->idEmpleado;
	        $fecha= new DateTime($empleado->fecha_nacimiento);
	        $datos['fecha']=$fecha->format('d-m-Y');
	        $datos['curp']=$empleado->curp;
	        $datos['imss']=$empleado->imss;
	        $datos['cuenta']=$empleado->no_cuenta;
	        $datos['perfil']= strtoupper($empleado->tipo_perfil);
	        $datos['visa']=ucwords($empleado->visa);
	        if($empleado->foto!=null)
	        	$datos['foto']="/storage/fotos/empleados/".$empleado->foto;
	        else
	        	$datos['foto']=null;
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
	    return json_encode($datos);
    }
    return json_encode(false);
	}

	

	

	
 
	

	

	

	

	

	

	
	
	

	

	

	

	
}