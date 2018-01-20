<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class BajasInventario extends Model {
	//
	protected $table = 'bajas_inventario';
	protected $primaryKey = 'idBajasInventario';
	protected $fillable = ['material','bajas','semana'];
	public $timestamps = false;
}