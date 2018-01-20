<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model {
	//
	protected $table = 'descuento';
	protected $primaryKey = 'idDescuento';
	protected $fillable = ['idEmpleado','descuento','fecha','semana','comentario'];
	public $timestamps = true;
}

