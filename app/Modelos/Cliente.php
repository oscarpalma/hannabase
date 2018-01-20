<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
	//
	protected $table = 'clientes';
	protected $primaryKey = 'idCliente';
	protected $fillable = ['nombre','telefono','contacto','direccion'];
	
	public $timestamps = false;
}

