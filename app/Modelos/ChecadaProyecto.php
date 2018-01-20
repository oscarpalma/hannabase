<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ChecadaProyecto extends Model {
	//
	protected $table = 'checadasProyecto';
	protected $primaryKey = 'idChecada';
	protected $fillable = ['idCliente','idTurno','idEmpleado','fecha','hora_entrada','hora_salida','horas_ordinarias','horas_extra','idUsuario'];
	public $timestamps = false;
}

