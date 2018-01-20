<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Reembolso extends Model {
	//
	protected $table = 'reembolso';
	protected $primaryKey = 'idReembolso';
	protected $fillable = ['idEmpleado','descuento','fecha','semana','comentario'];
	public $timestamps = true;
}

