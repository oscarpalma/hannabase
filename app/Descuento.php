<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model {

	//Contenido anterior en el modelo 'TipoDescuento'
	protected $table = 'descuento';
	protected $primaryKey = 'id_descuentos';
	protected $fillable =['empleado','descuento','fecha','comentario','semana'];
}
