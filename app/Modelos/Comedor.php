<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Comedor extends Model {
	//
	protected $table = 'comedores';
	protected $primaryKey = 'idComedores';
	protected $fillable = ['idEmpleado','semana','fecha','cantidad'];
	public $timestamps = true;
}

