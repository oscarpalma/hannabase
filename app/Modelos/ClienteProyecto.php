<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ClienteProyecto extends Model {
	//
	protected $table = 'clientesProyecto';
	protected $primaryKey = 'idCliente';
	protected $fillable = ['nombre','telefono','contacto','direccion'];
	
	public $timestamps = false;
}

