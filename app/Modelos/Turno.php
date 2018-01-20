<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model {
	//
	protected $table = 'turnos';
	protected $primaryKey = 'idTurno';
	protected $fillable = ['idCliente','hora_entrada','hora_salida','horas_trabajadas'];
	
	public $timestamps = false;
}

