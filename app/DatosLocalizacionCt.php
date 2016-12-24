<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosLocalizacionCt extends Model {

	//
	protected $fillable = ['idEmpleadoCt','tel_casa','tel_cel','calle','no_interior','no_exterior','idColonia','nombre_contacto','tel_contacto','tipo_parentesco'];
	protected $table = 'datos_localizacion_ct';
	protected $primaryKey = 'idEmpleadoCt';
	public $timestamps = false;
}
