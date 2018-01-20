<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model {

	//
	protected $table = 'empleados';
	protected $primaryKey = 'idEmpleado';

	protected $fillable = ['ap_paterno','ap_materno','nombres','curp','imss','idestado','fecha_nacimiento','tipo_perfil','genero','contratable','no_cuenta','estado','visa','foto'];
	public $timestamps = true;
}
