<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DatosLocalizacionProyecto extends Model {

	//
	protected $fillable = ['idEmpleado','tel_casa','tel_cel','calle','no_interior','no_exterior','idColonia'];
	protected $table = 'datos_localizacionProyecto';
	protected $primaryKey ='idEmpleado';
	public $timestamps = false;
}
