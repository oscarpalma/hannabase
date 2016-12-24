<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialSistemas extends Model {

	//
	protected $primaryKey = 'id';
	protected $table = 'materialSistemas';
	protected $fillable = ['idMaterial','contrasena','antivirus'];
	public $timestamps = false;
}