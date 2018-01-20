<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DirectorioPersonal extends Model {

	//
	protected $table = 'directorio_personal';
	protected $primaryKey = 'idDirectorioP';
	protected $fillable = ['nombre','puesto','celular','correo'];
	public $timestamps = false;
}
