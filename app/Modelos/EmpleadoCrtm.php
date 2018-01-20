<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class EmpleadoCrtm extends Model {

	//
	protected $table = 'empleados_crtm';
	protected $primaryKey = 'idEmpleado';

	protected $fillable = ['ap_paterno','ap_materno','nombres','curp','imss','idestado','fecha_nacimiento','tipo_perfil','genero','no_cuenta','area','foto'];
	public $timestamps = true;
}
