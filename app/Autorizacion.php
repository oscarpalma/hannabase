<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model {

	//
	protected $primaryKey = 'idAutorizacion';
	protected $table = 'autorizaciones';
	protected $fillable = ['idAutorizacion','solicitante','fecha','idarea','responsable','concepto','tipo_pago','idproveedor','descripcion','precio_unitario','cantidad','total'];
	public $timestamps = false;
}