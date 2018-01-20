<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Modelos\Notificacion;
use DateTime;

class UsuarioController extends Controller {

	
	public function lista_get(){
		
			return view('administrador/lista_usuarios')->with('usuarios', User::all());
			
	}

	public function baja_post_ajax(Request $request){
		if($request->ajax()){
			$usuarios = $request->input('id');
				
			foreach($usuarios as $usuario){
				$user = User::where('id', $usuario);
				$user->delete();
			}
			
		
			return json_encode(true);

		}
	}

	public function privilegio_post_ajax(Request $request)
	{
		if($request->ajax()){
			$user = User::find($request->input('id'));
			$user->role = $request->input('role');
			$user->save();
			$notificacion = new Notificacion();
		   
		    $notificacion->mensaje = 'Tus priviligios fueron modificados a ' . $request->input('role');
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = Auth::user()->name;
			$notificacion->destinatario = $user->id;
			$notificacion->asunto = 'Privilegios';
			$notificacion->save();
			return json_encode($user);
		}else
			return response('No autorizado.', 401);
	}
	//Queda pendiente porque bcrypt es un hash y no se puede desencriptar
	/*public function password_post_ajax(Request $request)
	{
		
			$user = User::find($request->input('id'));
			$password = \Crypt::decrypt($user->password);
			
			return json_encode($password);
		
	}*/



}