<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Checada extends Model {
	//
	protected $table = 'checadas';
	protected $primaryKey = 'idChecada';
	protected $fillable = ['idCliente','idTurno','idEmpleado','fecha','hora_entrada','hora_salida','horas_ordinarias','horas_extra','incidencia','comentarios','idUsuario'];
	public $timestamps = false;
}

