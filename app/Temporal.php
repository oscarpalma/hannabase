<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporal extends Model {

	//
	protected $primaryKey = 'idTemporal';
	protected $table = 'temporales';
	protected $fillable = ['idTemporal','proveedor','descripcion','precio_unitario','cantidad','total'];
	public $timestamps = false;
}