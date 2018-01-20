<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modelos\ClienteProyecto;
use App\Modelos\TurnoProyecto;
use Auth;
use Illuminate\Http\Request;

class ClienteProyectoController extends Controller {

	public function alta_get(){
		
			return view('clientes_proyectos/alta_cliente');
	
	}

		public function alta_post(Request $request)
	{
		$cliente = new ClienteProyecto([
			'nombre' => $request->input('nombre'),
			'telefono' => $request->input('telefono'),
			'contacto' => $request->input('contacto'),
			'direccion' => $request->input('direccion')
			]);

		if(ClienteProyecto::where('nombre',$cliente->nombre)->first() == null){
			$cliente->save();

		//buscar el cliente que fue guardado en la base de datos para obtener su id recien asignado
			//$cliente = Cliente::where('nombre', $cliente->nombre)->first();
			$hora_entrada=$request->input('hora_entrada');
			$hora_salida=$request->input('hora_salida');
			$horas_trabajadas=$request->input('horas_trabajadas');
			for ($i=0; $i < count($hora_entrada); $i++) { 
				$turno = new TurnoProyecto([
				'idCliente' => $cliente->idCliente,
				'hora_entrada' => $hora_entrada[$i],
				'hora_salida' => $hora_salida[$i],
				'horas_trabajadas' => $horas_trabajadas[$i]
				]);

			$turno->save();
			}
			

			return view('clientes_proyectos/alta_cliente')->with('success',true);
		}

		else
			return view('clientes_proyectos/alta_cliente')->with('error',true);
	}

	public function lista_get(){
					
			$clientes = ClienteProyecto::all();
			return view('clientes_proyectos/lista_clientes')->with('clientes',$clientes);

	}

	public function baja_post_ajax(Request $request){
		if($request->ajax()){
			$clientes = $request->input('id');
				
			foreach($clientes as $cliente){
				$cliente = ClienteProyecto::where('idCliente', $cliente);
				$cliente->delete();
			}
			return json_encode(true);

		}
	}

	public function turnos_get_ajax(Request $request){
		if($request->ajax()){
			$cliente = $request->input('id');
			$turnos = TurnoProyecto::where('idCliente',$cliente)->get();
			
			return json_encode($turnos);

		}
	}

	public function turnos_post_ajax(Request $request){
		if($request->ajax()){
			$turno = new TurnoProyecto([
				'idCliente' => $request->input('id'),
				'hora_entrada' => $request->input('hora_entrada'),
				'hora_salida' => $request->input('hora_salida'),
				'horas_trabajadas' => $request->input('horas_trabajadas')
				]);

			$turno->save();
			
			return json_encode($turno);

		}
	}

}
