<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;
use App\Notificacion;
use App\User;
use Illuminate\Http\Request;
use App\AreaCt;
class MensajeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role,['administrador','contabilidad'])){

			$user = User::all();
			return view('admin/mensaje')->with('usuarios',$user);
			}

		else
			return view('errors/restringido');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

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
			$notificacion->remitente = Auth::user()->nombre;
			$notificacion->asunto = $request->input('asunto');
			$notificacion->save();
			 } 
		    
		} 
	}else if ($tipo==='usuarios'){

			$notificacion = new Notificacion();
		    $notificacion->destinatario = $request->input('usuario');
		    $notificacion->mensaje = $request->input('mensaje');
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = Auth::user()->nombre;
			$notificacion->asunto = $request->input('asunto');
			$notificacion->save();

	}
		
		return redirect('mensaje');
	}

	//ver un mensaje
	public function ver($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else{
			$notificacion = Notificacion::where('idNotificaciones',$id)->first();
			$notificaciones = [$notificacion];
			return view('ver_mensaje')->with('notificaciones',$notificaciones);
		}
	}

	public function verTodos()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else
		{
			$notificaciones = Notificacion::where('idNotificaciones', '>', 0)->OrderBy('fecha', 'desc')->get();

			return view('ver_mensaje')->with('notificaciones',$notificaciones);
		}
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
