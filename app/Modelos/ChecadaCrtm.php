<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ChecadaCrtm extends Model {
	//
	protected $table = 'checadas_crtm';
	protected $primaryKey = 'idChecada';
	protected $fillable = ['idEmpleado','fecha','hora_entrada','hora_salida','horas_ordinarias','horas_extra','incidencia','comentarios','idUsuario'];
	public $timestamps = false;
}

