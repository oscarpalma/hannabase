<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modelos\Cliente;
use App\Modelos\Turno;
use Auth;
use Illuminate\Http\Request;

class ClienteController extends Controller {

	

	public function alta_get(){
		
			return view('clientes/alta_cliente');
	
	}

		public function alta_post(Request $request)
	{
		$cliente = new Cliente([
			'nombre' => $request->input('nombre'),
			'telefono' => $request->input('telefono'),
			'contacto' => $request->input('contacto'),
			'direccion' => $request->input('direccion')
			]);

		if(Cliente::where('nombre',$cliente->nombre)->first() == null){
			$cliente->save();

		//buscar el cliente que fue guardado en la base de datos para obtener su id recien asignado
			//$cliente = Cliente::where('nombre', $cliente->nombre)->first();
			$hora_entrada=$request->input('hora_entrada');
			$hora_salida=$request->input('hora_salida');
			$horas_trabajadas=$request->input('horas_trabajadas');
			for ($i=0; $i < count($hora_entrada); $i++) { 
				$turno = new Turno([
				'idCliente' => $cliente->idCliente,
				'hora_entrada' => $hora_entrada[$i],
				'hora_salida' => $hora_salida[$i],
				'horas_trabajadas' => $horas_trabajadas[$i]
				]);

			$turno->save();
			}
			

			return view('clientes/alta_cliente')->with('success',true);
		}

		else
			return view('clientes/alta_cliente')->with('error',true);
	}

	public function lista_get(){
					
			$clientes = Cliente::all();
			return view('clientes/lista_clientes')->with('clientes',$clientes);

	}

	public function baja_post_ajax(Request $request){
		if($request->ajax()){
			$clientes = $request->input('id');
				
			foreach($clientes as $cliente){
				$cliente = Cliente::where('idCliente', $cliente);
				$cliente->delete();
			}
			return json_encode(true);

		}
	}

	public function turnos_get_ajax(Request $request){
		if($request->ajax()){
			$cliente = $request->input('id');
			$turnos = Turno::where('idCliente',$cliente)->get();
			
			return json_encode($turnos);

		}
	}

	public function turnos_post_ajax(Request $request){
		if($request->ajax()){
			$turno = new Turno([
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