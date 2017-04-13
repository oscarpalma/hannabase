<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model {

	//
	protected $primaryKey = 'idCotizacion';
	protected $table = 'cotizaciones';
	protected $fillable = ['idCotizacion','solicitante','fecha','idarea','responsable','concepto','tipo_pago','idtemporal'];
	public $timestamps = false;
}