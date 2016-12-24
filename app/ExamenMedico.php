<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model {

	//
	protected $table = 'examen_medico';
	protected $fillable = ['empleado','antidoping','embarazo','vista','enfermedad','antidoping_comentario','embarazo_comentario','vista_comentario','enfermedad_comentario'];
	protected $primaryKey = 'id_examen';

}
