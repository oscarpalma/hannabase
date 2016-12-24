<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model {

	//
	protected $primaryKey = 'id';
	protected $table = 'material';
	protected $fillable = ['id','idMaterial','area','nombre','marca','modelo','descripcion','accesorios','contraseña','antivirus','estado','unidades','precioUnitario','precioTotal','codigoBarras','foto','fecha'];
	public $timestamps = false;
}