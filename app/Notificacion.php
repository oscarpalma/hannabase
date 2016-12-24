<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {

	//
	protected $table = 'notificaciones';
	protected $primaryKey = 'idNotificaciones';
	protected $fillable =['idNotificaciones','mensaje','visto','area'];
	public $timestamps = false;
}
