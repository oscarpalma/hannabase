<?php namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {

	//
	protected $table = 'estados';
	protected $primaryKey = 'id_estados';
	public $timestamps = false;
}
