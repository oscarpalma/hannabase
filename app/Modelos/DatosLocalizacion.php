<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DatosLocalizacion extends Model {

	//
	protected $fillable = ['idEmpleado','tel_casa','tel_cel','calle','no_interior','no_exterior','idColonia','nombre_contacto','tel_contacto','tipo_parentesco'];
	protected $table = 'datos_localizacion';
	protected $primaryKey ='idEmpleado';
	public $timestamps = false;
}
