<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoKpi extends Model {

	//
	protected $primaryKey = 'idTipoKpi';
	protected $table = 'tipoKpi';
	protected $fillable = ['nombre','unidad','pk_idAreaCt'];
	public $timestamps = false;
}