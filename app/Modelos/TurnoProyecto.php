<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TurnoProyecto extends Model {
	//
	protected $table = 'turnosProyecto';
	protected $primaryKey = 'idTurno';
	protected $fillable = ['idCliente','hora_entrada','hora_salida','horas_trabajadas'];
	
	public $timestamps = false;
}