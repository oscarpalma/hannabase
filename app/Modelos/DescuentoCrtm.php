<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DescuentoCrtm extends Model {

	//Contenido anterior en el modelo 'TipoDescuento'
	protected $table = 'descuento_crtm';
	protected $primaryKey = 'idDescuento';
	protected $fillable =['idEmpleado','monto','concepto','fecha','semana'];
	public $timestamps = true;

}
