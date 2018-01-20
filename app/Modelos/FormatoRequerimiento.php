<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FormatoRequerimiento extends Model {

	protected $table = 'formato_requerimiento';
	protected $primaryKey = 'idFormato';

	protected $fillable = ['tabla'];
	public $timestamps = false;

}
