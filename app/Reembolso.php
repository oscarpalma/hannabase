<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reembolso extends Model {

	//
	protected $table = 'reembolso';
	protected $primaryKey = 'id_descuentos';
	protected $fillable =['empleado','descuento','fecha','comentario','semana'];
}
