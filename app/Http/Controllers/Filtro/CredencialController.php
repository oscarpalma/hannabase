<?php namespace App\Http\Controllers\Filtro;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\EmpleadoCt;
use App\DatosLocalizacion;
use App\ExamenMedico;
use Validator;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Contracts\Filesystem\Factory;

class CredencialController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor']))
			return view('filtro/credencial');

		else
			return view('errors/restringido');
	}
	public function verificar(Request $request){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor'])){
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
					$examen = ExamenMedico::where('empleado',$empleado->idEmpleado)->first();
					//si no se encontro el examen medico:
					if($examen === null) $prospecto['observacion'] = "No ha presentado examen médico";
					//si no aprobo el examen medico:
					elseif(!$examen->aprobado) $prospecto['observacion'] = "No aprobó el examen médico";

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
			//enviar a la vista
			return view('filtro/credencial')->with('prospectos',$prospectos);
		}

		else
			return view('errors/restringido');
	}
	

	public function detalleCredencial($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor'])){
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
				
			    
			     
			    $credencial['foto'] = $empleado->foto;
			     
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

	    else
	    	return view('errors/restringido');
	}
	
	//Subir foto para credencial
	public function foto(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor'])){
			$empleado = Empleado::where('estado','empleado')->get();
			return view('filtro/subirFoto')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
	}
	public function subirFoto(Request $request){
		
        $rules = ['image' => 'required|image|max:1024*1024*1',];
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.image' => 'Formato no permitido',
            'image.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect('foto-credencial')->withErrors($validator);
        }
        else{
        	$noempleado = $request->input('idEmpleado');

        	//eliminar foto previa
        	$foto = Empleado::where('idEmpleado', '=', $noempleado)->first();
if($foto->foto != null){
        	$foto = explode('/',$foto->foto);
        	\Storage::delete($foto[1]);}

        	//Cambiar nombre de foto para que no se repitan
            $name = str_random(30) . '-' . $request->file('image')->getClientOriginalName();
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  \File::get($request->file('image')));
            //$request->file('image')->move('fotos', $name);
            //guardar ruta en base de datos
            $user = new Empleado;
            $user->where('idEmpleado', '=', $noempleado)
                 ->update(['foto' => 'fotos/'.$name]);
            return redirect('foto-credencial')->with('status', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }

    //funciones para las fotos de los empleados de oficina
	public function fotoCt(){
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor'])){
			$empleado = EmpleadoCt::all();
			return view('filtro/subirFoto')->with('empleadoCt',$empleado);
		}

		else
			return view('errors/restringido');
	}
	public function subirFotoCt(Request $request){
		
        $rules = ['image' => 'required|image|max:1024*1024*1',];
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.image' => 'Formato no permitido',
            'image.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect('foto-ct')->withErrors($validator);
        }
        else{
        	$noempleado = $request->input('idEmpleado');

        	//eliminar foto previa
        	$foto = EmpleadoCt::where('idEmpleadoCt', '=', $noempleado)->first();
        	if($foto->foto != null){
        		$foto = explode('/',$foto->foto);
        		\Storage::delete($foto[1]);
        	}

        	//Cambiar nombre de foto para que no se repitan
            $name = str_random(30) . '-' . $request->file('image')->getClientOriginalName();
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  \File::get($request->file('image')));
            //$request->file('image')->move('fotos', $name);
            //guardar ruta en base de datos
            $user = new EmpleadoCt;
            $user->where('idEmpleadoCt', '=', $noempleado)
                 ->update(['foto' => 'fotos/'.$name]);
            return redirect('foto-ct')->with('status', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }

    public function tomarFoto(){
    	if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor'])){
			$empleado = Empleado::where('estado','empleado')->get();
			return view('filtro/camera')->with('empleado',$empleado);
		}

		else
			return view('errors/restringido');
    	
    }

    public function subirFoto2(){

    	$Base64Img = Input::get('image');
    	list(, $Base64Img) = explode(';', $Base64Img);
list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
$Base64Img = base64_decode($Base64Img);
    	$name = str_random(30) . '-' . 'imagen';
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  $Base64Img);
    	$user = new Empleado;
            $user->where('idEmpleado', '=', 5000)
                 ->update(['foto' => Input::get('image')]);
            return redirect('foto-credencial')->with('status', 'Su imagen de perfil ha sido cambiada con éxito');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function destroy($id)
	{
		//
	}

}