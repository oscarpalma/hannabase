<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FormatoKpi extends Model {

	protected $table = 'formato_kpi';
	protected $primaryKey = 'idFormato';

	protected $fillable = ['tabla','area'];
	public $timestamps = false;

}
