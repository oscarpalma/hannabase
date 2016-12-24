<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model {

	//
	protected $primaryKey = 'idTurno';
	protected $table = 'turnos';
	protected $fillable = ['idTurno','idCliente','hora_entrada','hora_salida','horas_trabajadas'];
	public $timestamps = false;
}
