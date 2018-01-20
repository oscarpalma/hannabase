<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model {

	//
	protected $primaryKey = 'idRequerimiento';
	protected $table = 'requerimientos';
	protected $fillable = ['idRequerimiento','idcliente','fecha_ingreso','requerimiento','ingreso','idusuario'];
	public $timestamps = false;
}