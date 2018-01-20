<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;
use App\Modelos\Notificacion;
use App\User;
use Illuminate\Http\Request;
use App\Modelos\AreaCrtm;
class MensajeController extends Controller {

	
	public function index()
	{
		$user = User::all();
			return view('administrador/mensaje')->with('usuarios',$user);
			
	}

	
	//enviar un mensaje
	public function create(Request $request)
	{
		$tipo = $request->input('tipo');
		if ($tipo==='area'){
		$destinatarios = $request->input('destinatarios');
		for ($i=0;$i<count($destinatarios);$i++)    
		{    
			$usuarios_area = User::where('role',$destinatarios[$i])->get();
			foreach ($usuarios_area as $usuario) {
			$notificacion = new Notificacion();
		    $notificacion->destinatario = $usuario->id;
		    $notificacion->mensaje = $request->input('mensaje');
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = Auth::user()->name;
			$notificacion->asunto = $request->input('asunto');
			$notificacion->save();
			 } 
		    
		} 
	}else if ($tipo==='usuarios'){

		$notificacion = new Notificacion();
		    $notificacion->destinatario = $request->input('usuario');
		    $notificacion->mensaje = $request->input('mensaje');
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = Auth::user()->name;
			$notificacion->asunto = $request->input('asunto');
			$notificacion->save();

	}
		
		return redirect('mensaje');
	}

	//ver un mensaje
	public function ver($id)
	{
		
			$notificacion = Notificacion::where('idNotificaciones',$id)->first();
			$notificaciones = [$notificacion];
			return view('mensajes/ver_mensaje')->with('notificaciones',$notificaciones);
		
	}

	public function verTodos()
	{
		
			$notificaciones = Notificacion::where('idNotificaciones', '>', 0)->OrderBy('fecha', 'desc')->get();

			return view('mensajes/ver_mensaje')->with('notificaciones',$notificaciones);
		
	}

	

}