<?php namespace App\Services;

use App\User;
use Validator;
use App\Notificacion;
use DateTime;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$usuarios_area = User::where('role','administrador')->get();
			foreach ($usuarios_area as $usuario) {
			
			 
		$mensaje = "Un nuevo usuario ha sido registrado en el sistema; revise la informacion para asignar los privilegios apropiados. El correo utilizado para el registro fue: " . $data['email'];
	    $notificacion = new Notificacion();
	    $notificacion->destinatario = $usuario->id;
	    $notificacion->mensaje = $mensaje;
		$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
		$notificacion->remitente = 'Sistema';
		$notificacion->asunto = 'Nuevo usuario';
		$notificacion->save();
		} 
		return User::create([
			'nombre' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'role' => null,
		]);
	}

}