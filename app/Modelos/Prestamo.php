<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model {

	//Contenido anterior en el modelo 'TipoDescuento'
	protected $table = 'prestamo';
	protected $primaryKey = 'idPrestamo';
	protected $fillable =['idEmpleado','monto','concepto','fecha','semana'];
	public $timestamps = true;

}
