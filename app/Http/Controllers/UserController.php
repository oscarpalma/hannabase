<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DateTime;
use Mail;
use Session;
use Redirect;
use App\Notificacion;
use App\AreaCt;
use App\Proveedor;
use App\Cotizacion;
use App\EmpleadoCt;

use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!Auth::guest())
			return view('perfil_usuario');

		else
			return redirect()->route('login');
	}

	public function lista()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador')
			return view('admin/usuarios')->with('usuarios', User::all());

		else
			return view('errors/restringido');
	}

	public function cambiarPrivilegios($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){
			$user = User::find($id)->first();
			return view('admin/modificar_usuario')->with('usuario', $user);
		}

		else
			return view('errors/restringido');
	}

	public function modificar(Request $request, $id)
	{
		$user = User::find($id);
		$user->role = $request->input('role');
		$user->save();
		$notificacion = new Notificacion();
		   
		    $notificacion->mensaje = 'Tus priviligios fueron modificados a ' . $request->input('role');
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = Auth::user()->nombre;
			$notificacion->destinatario = $id;
			$notificacion->asunto = 'Privilegios';
			$notificacion->save();
		return redirect('usuarios');
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
	public function update(Request $request)
	{
		//
                $user = Auth::user();
                $user->nombre = $request->input('name');
                $user->email = $request->input('email');
                $user->save();
                return redirect()->route('usuario');
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
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){			
			$user = User::find($id);
			$user->delete();
			return redirect()->route('lista_usuarios');
		}

		else
			return view('errors/restringido');
	}

}