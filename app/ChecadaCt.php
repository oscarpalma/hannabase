<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecadaCt extends Model {

	//
	protected $primaryKey = 'idChecadaCt';
	protected $fillable = ['idEmpleadoCt','fecha','hora_entrada','hora_salida','horas_ordinarias','horas_extra','incidencia','comentarios','idUsuario'];
	protected $table = 'checadas_ct';
	public $timestamps = false;
}
