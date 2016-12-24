<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model {

	//
	protected $fillable = ['id_descuentos','empleado','monto','concepto','fecha','semana'];
	protected $table = 'prestamo';
	protected $primaryKey = 'id_descuentos';
	public $timestamps = true;
}