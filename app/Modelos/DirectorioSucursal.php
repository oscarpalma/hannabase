<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DirectorioSucursal extends Model {

	//
	protected $table = 'directorio_sucursales';
	protected $primaryKey = 'idDirectorioS';
	protected $fillable = ['sucursal','telefonos','area'];
	public $timestamps = false;
}