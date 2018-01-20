<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoDescuento extends Model {
	//
	protected $table = 'tipo_descuento';
	protected $primaryKey = 'idTipoDescuento';
	protected $fillable = ['nombre_descuento','precio'];
	public $timestamps = true;
}

