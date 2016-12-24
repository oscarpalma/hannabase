<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDescuento extends Model {

	//Anteriormente el modelo 'Descuento'
	protected $table = 'tipo_descuento';
	protected $primaryKey = 'id_descuento';
	public $timestamps = false;

}
