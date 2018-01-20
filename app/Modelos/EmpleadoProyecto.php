<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class EmpleadoProyecto extends Model {

	//
	protected $table = 'empleadosProyecto';
	protected $primaryKey = 'idEmpleado';

	protected $fillable = ['idEmpleado','ap_paterno','ap_materno','nombres','curp','imss','idestado','fecha_nacimiento','genero'];
	public $timestamps = true;
}
