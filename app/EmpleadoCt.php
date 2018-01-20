<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadoCt extends Model {

	//
	protected $table = 'empleados_ct';
	protected $primaryKey = 'idEmpleadoCt';

	protected $fillable = ['idEmpleadoCt','ap_paterno','ap_materno','nombres','curp','imss','idestado','fecha_nacimiento','rfc','genero','area','no_cuenta','fecha_ingreso','estado'];
}
