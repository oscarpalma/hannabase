<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorioPersonalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directorio_personal',function(Blueprint $table){
			$table->increments('idDirectorioP');
			$table->string("nombre",100);
			$table->string("puesto",45);
			$table->string("celular",255);
			$table->string("correo",45);
			$table->integer("area")->unsigned();	

			$table->foreign('area')->references('idArea')->on('areas_crtm')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('directorio_personal');
	}

}
