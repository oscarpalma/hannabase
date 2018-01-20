<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model {

	protected $table = 'requerimiento';
	protected $primaryKey = 'idRequerimiento';

	protected $fillable = ['tabla','semana', 'year'];
	public $timestamps = false;

}
