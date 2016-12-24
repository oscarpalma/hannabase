<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

	//
	protected $primaryKey = 'idCliente';
	protected $table = 'clientes';
	protected $fillable = ['idCliente','nombre','direccion','telefono','contacto'];
	public $timestamps = false;
}
