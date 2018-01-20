<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LogroKpi extends Model {

	protected $table = 'logro_kpi';
	protected $primaryKey = 'idLogro';

	protected $fillable = ['tabla','semana','year','area'];
	public $timestamps = false;

}
