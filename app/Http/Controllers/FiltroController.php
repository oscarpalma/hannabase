<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Modelos\Empleado;
use App\Modelos\Descuento;
use App\Modelos\Reembolso;
use App\Modelos\TipoDescuento;
use App\Modelos\DatosLocalizacion;
use Validator;
use DateTime;
class FiltroController extends Controller {

	public function verificar_get(){
			return view('filtro/verificarProspecto');

	}

	public function verificar_post(Request $request){
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
				//$examen = ExamenMedico::where('empleado',$empleado->idEmpleado)->orderBy('created_at','desc')->first();
				$examen = true;
				//si no se encontro el examen medico:
				if($examen === null) $prospecto['observacion'] = "No ha presentado examen médico";
				//si no aprobo el examen medico:
				//elseif(!$examen->aprobado) $prospecto['observacion'] = "No aprobó el examen médico";
			}
			//guardar el prospecto encontrado al array con los demas prospectos
			array_push($prospectos, $prospecto);
		}

		//enviar a la vista
		return view('filtro/verificarProspecto')->with('prospectos',$prospectos);
	}

	public function credencial_get(){
			return view('filtro/credencial');

	}

	public function credencial_post(Request $request){

			//obtener el texto ingresado y separarlo en un array, en el que cada elemento es una curp diferente
			$noempleado = $request->input('empleadoid');
			//eliminar cualquier espacio blanco en el string
			$noempleado = preg_replace('/\s+/', '',$noempleado);
			//remover comas al principio e inicio del string, si las hay
			$noempleado = trim($noempleado,',');
			//separar el string en un array, utilizando comas como el separador
			$noempleado = explode(',',$noempleado);
			//crear un array para almacenar los prospectos encontrados
			$prospectos = array();

			//iterrar entre las curps ingresadas
			foreach($noempleado as $empleadoid){
				//guardar cada prospecto como un array
				$prospecto = array();
				//buscar al empleado con base en la curp
				$empleado = Empleado::where('idEmpleado',$empleadoid)->first();

				if( $empleado === null){
					// $prospecto['noempleado'] = 'N/A';
					// $prospecto['nombre'] = 'N/A';
					// $prospecto['curp'] = 'N/A';
					// $prospecto['noimss'] = 'N/A';
					// $prospecto['estado'] = 'N/A';
					//$prospecto['observacion'] = 'No registrado';
					// $prospecto['foto'] = 'N/A';
				}
				//si se encontro al empleado:
				else{
					$prospecto['noempleado']= $empleado->idEmpleado;
					$prospecto['nombre'] = $empleado->ap_paterno . " " . $empleado->ap_materno . ", " . $empleado->nombres;
					$prospecto['curp'] = strtoupper($empleado->curp);
					$prospecto['noimss']=$empleado->imss;
					$prospecto['localizacion'] ="";
					$prospecto['foto'] = $empleado->foto;
					if($empleado->estado == 'candidato') $prospecto['estado'] = 'Candidato';
					else $prospecto['estado'] = 'Empleado';
					if($empleado->contratable) $prospecto['observacion'] = "Puede trabajar";
					else {
						$prospecto['observacion'] = "Lista negra";
						$prospecto['estado'] = 'No Contratable';
					}
					//buscar el registro medico
					//$examen = ExamenMedico::where('empleado',$empleado->idEmpleado)->first();
					$examen = true;
					//si no se encontro el examen medico:
					if($examen === null) $prospecto['observacion'] = "No ha presentado examen médico";
					//si no aprobo el examen medico:
					//elseif(!$examen->aprobado) $prospecto['observacion'] = "No aprobó el examen médico";

					//buscar el registro medico
					$localizacion = DatosLocalizacion::where('idEmpleado',$empleado->idEmpleado)->first();
					if($localizacion === null) $prospecto['localizacion'] = "No se encontraron datos de localizacion";
					
					elseif($localizacion != null)
					{
						$prospecto['localizacion']= "En caso de emergencia llamar a: ". $localizacion->nombre_contacto .",Telefono: ". $localizacion->tel_contacto;
					}
					//guardar el prospecto encontrado al array con los demas prospectos
				array_push($prospectos, $prospecto);
				}
			}
			return view('filtro/credencial')->with('prospectos',$prospectos);
				
			
		
	}

	public function detalleCredencial($id)
	{
			//$empleado = Empleado::where('idEmpleado',$id)->first();
			$empleado = Empleado::find($id);
			
			$credencial = array();

			if($empleado != null){
				$credencial['noempleado']= $empleado->idEmpleado;
				$credencial['nombre'] = $empleado->nombres;
				$credencial['apellidos'] = $empleado->ap_paterno . " " . $empleado->ap_materno;
				$credencial['curp'] = strtoupper($empleado->curp);
				$credencial['rfc']=$empleado->rfc;
				$credencial['noimss']=$empleado->imss;
				$credencial['localizacion'] ="";
				
			    
			     
			    $credencial['foto'] = 'storage/fotos/empleados/' . $empleado->foto;
			     
				//$credencial['foto'] = $empleado->foto;
			}
			
			$localizacion = DatosLocalizacion::where('idEmpleado',$empleado->idEmpleado)->first();
		
			if($localizacion != null)
			{
				$credencial['nombre_contacto']=  $localizacion->nombre_contacto;
				$credencial['tel_contacto'] = $localizacion->tel_contacto;

			}
	        
	        return view('filtro/detallecredencial')->with('credencial',$credencial);
	   
	}

	public function descuento_get()
	{
			$descuentos = TipoDescuento::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			//se envian tanto la listas de empleados como de descuentos en un solo array
			$informacion = ['descuentos' => $descuentos, 'empleados' => $empleados];
			return view('filtro/alta_descuento')->with('informacion',$informacion);
		
	}

	public function descuento_post(Request $request)
	{
		//
		$fecha = new DateTime($request->input('fecha'));

		$empleado = Empleado::find($request->input('idEmpleado'));
		$tipo_descuento = TipoDescuento::find($request->input('idDescuento'));
		$descuento = new Descuento([
			'idEmpleado'    => $empleado->idEmpleado,
			'descuento'   => $tipo_descuento->idTipoDescuento,
			'fecha'       => $fecha,
			'comentario' => $request->input('comentario'),
			'semana'      => $fecha->format('W')
			]);

		$descuento->save();

		return redirect()->route('descuento_empleado')->withInput()->with('success','Descuento registrado con éxito');
	}

public function reembolso_get()
	{
			$descuentos = TipoDescuento::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			//se envian tanto la listas de empleados como de descuentos en un solo array
			$informacion = ['descuentos' => $descuentos, 'empleados' => $empleados];
			return view('filtro/alta_reembolso')->with('informacion',$informacion);
		
	}

	
	public function reembolso_post(Request $request)
	{
		$fecha = new DateTime($request->input('fecha'));
	

		$empleado = Empleado::find($request->input('idEmpleado'));
		$tipo_descuento = TipoDescuento::find($request->input('idDescuento'));
		$reembolso = new Reembolso([
			'idEmpleado'    => $empleado->idEmpleado,
			'descuento'   => $tipo_descuento->idTipoDescuento,
			'fecha'       => $fecha,
			'comentario' => $request->input('comentario'),
			'semana'      => $fecha->format("W")
			]);

		$reembolso->save();

		return redirect()->route('reembolso_empleado')->withInput()->with('success','Reembolso registrado con éxito');
	}

public function tomarFoto_get(){
    		$empleado = Empleado::where('estado','empleado')->get();
			return view('filtro/tomar_foto')->with('empleado',$empleado);
		
    	
    }

    public function tomarFoto_post(Request $request){
    	$empleado = $request->input('empleado');
		//eliminar foto previa
        $foto = Empleado::where('idEmpleado', '=', $empleado)->first();
        if ($foto->foto != null)
		{
        $foto = explode('/',$foto->foto);
        
		    \Storage::delete($foto[1]);
		}


		$Base64Img = $request->input('image');
    	list(, $Base64Img) = explode(';', $Base64Img);
		list(, $Base64Img) = explode(',', $Base64Img);
		//Decodificamos $Base64Img codificada en base64.
		$Base64Img = base64_decode($Base64Img);
    	$name = str_random(30) . '-' . $empleado;
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  $Base64Img);
    	$user = new Empleado;
            $user->where('idEmpleado', '=', $empleado)
                 ->update(['foto' => 'fotos/' . $name]);
		return json_encode(true);
 }

	public function subirFoto_get(){
    		$empleado = Empleado::where('estado','empleado')->get();
			return view('filtro/subir_foto')->with('empleado',$empleado);
		
    	
    }

    public function subirFoto_post(Request $request){
		
        $rules = ['image' => 'required|image|max:1024*1024*1',];
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.image' => 'Formato no permitido',
            'image.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->flash());
        }
        else{
        	$noempleado = $request->input('idEmpleado');

        	//eliminar foto previa
        	$foto = Empleado::where('idEmpleado', '=', $noempleado)->first();
			if($foto->foto != null){
        	
        	\Storage::disk('fotosEmpleados')->delete($foto->foto);}

        	//Cambiar nombre de foto para que no se repitan
            $name = 'empleado' . '-' . $noempleado  . '.'. $request->file('image')->getClientOriginalExtension();
            //guardar foto en disco local
            \Storage::disk('fotosEmpleados')->put($name,  \File::get($request->file('image')));
            //$request->file('image')->move('fotos', $name);
            //guardar ruta en base de datos
            $user = new Empleado;
            $user->where('idEmpleado', '=', $noempleado)
                 ->update(['foto' => $name]);
            return redirect('filtro/subir-foto')->with('success', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }

    public function lista_descuentos_get()
	{
		

			
			return view('filtro/listado_descuentos');
		
	}

	public function lista_descuentos_post(Request $request)
	{
		

			$semana = $request->input('semana');
			$descuentos = Descuento::where('semana',$semana)->orderBy('fecha')->get();
			$informacion = array();

			foreach ($descuentos as $descuento) {
				$empleado=Empleado::find($descuento->idEmpleado);
				$tipoDescuento=TipoDescuento::find($descuento->descuento);
				$info['no_empleado']=$descuento->idEmpleado;
				$info['nombre']= $empleado->ap_paterno.' '.$empleado->ap_materno.', '.$empleado->nombres;
				$info['material']=$tipoDescuento->nombre_descuento;
				$info['precio']=$tipoDescuento->precio;
				$info['fecha']=$descuento->fecha;
				$info['id']=$descuento->idDescuento;
				array_push($informacion,$info);
			}
			return view('filtro/listado_descuentos') -> with ('descuentos',$informacion)-> with ('semana',$semana);
		
	}

	public function eliminar_descuento_ajax(Request $request){
		
		if($request->ajax()){
			$descuentos = $request->input('descuentos');
				
			foreach($descuentos as $descuento){
				$_descuento = Descuento::where('idDescuento', $descuento);
				$_descuento->delete();
			}
			return json_encode(true);

		}
	}

}