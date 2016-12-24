<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Checada extends Model {

	//
	protected $primaryKey = 'idChecada';
	protected $fillable = ['idChecada','idCliente','idTurno','idEmpleado','fecha','hora_entrada','hora_salida','horas_ordinarias','horas_extra','incidencia','comentarios','idUsuario'];
	protected $table = 'checadas';
	public $timestamps = false;
}
