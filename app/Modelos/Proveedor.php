<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model {

	//
	protected $table = 'proveedores';
	protected $fillable = ['nombre','contacto','telefono','email','credito'];

}
