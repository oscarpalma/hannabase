<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comedor extends Model {

	//

	protected $table = "comedores";
	protected $fillable = ['idEmpleado', 'semana', 'fecha', 'cantidad'];
	public $timestamps = false;

}
