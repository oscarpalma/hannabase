<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class logro extends Model {

	//
	protected $primaryKey = 'idLogro';
	protected $table = 'logro';
	protected $fillable = ['plan','actual','fecha','semana','pk_idTipoKpi'];
	public $timestamps = false;
}